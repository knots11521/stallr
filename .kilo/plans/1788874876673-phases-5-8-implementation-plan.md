# Phases 5-8 Implementation Plan

## Project Context

**Tech stack**: Laravel 12 (PHP 8.2+), Filament 5.7 (admin+vendor panels), Livewire 4, Spatie Permission (roles: Admin/Vendor/Customer), Stripe, MySQL (SQLite in tests).

**Key codebase facts**:
- `OrderPlaced` event already exists and is dispatched in `OrderService::finalizePaymentIntent()`. `TestOrderPlacedListener` exists but is **dead code** (never registered). No `EventServiceProvider` exists (Laravel 12 skeleton).
- `QUEUE_CONNECTION=database` in `.env`; `jobs`, `job_batches`, `failed_jobs` tables already migrated. `composer dev` runs `queue:listen`.
- `MAIL_MAILER=log` in `.env`; `MAIL_MAILER=array` in `phpunit.xml`. `User` has `Notifiable` trait. No Notification or Mailable classes exist.
- Order/vendor_order statuses: `pending` → `processing` only. Status columns are plain strings (no enum).
- Low-stock hardcoded as `<= 5` in `VendorStats` widget. No threshold column on products.
- `users` table has `is_active` (bool). `vendors` table has `is_verified` but **no `is_active`**.
- `phpunit.xml` sets `QUEUE_CONNECTION=sync` and `MAIL_MAILER=array` — queued jobs run synchronously in tests.

## Resolved Design Decisions

| Decision | Choice |
|---|---|
| Low-stock threshold | Per-product column `low_stock_threshold` (default 5) on `products` table |
| Vendor order management UI | Filament Resource in `app/Filament/Vendor/Resources/VendorOrders/` |
| Notification channels | Mail + database (in-app) for vendor alerts; mail for customer confirmation |
| Average rating | Cached columns `average_rating` + `review_count` on `products` |
| Event-listener registration | Create `EventServiceProvider`, register in `bootstrap/app.php` via `->withProviders()` |
| Reviews moderation | Auto-publish (status defaults to `approved`); status column kept for future moderation |
| Order fulfillment statuses | `pending` → `processing` → `shipped` → `delivered` → `cancelled` |
| Charts | Filament built-in `ChartWidget` (Chart.js bundled with Filament, no npm change needed) |
| Reviews uniqueness | One review per (user_id, reviewable_id, reviewable_type) |

---

## Phase 5: Events, Notifications & Queues

### 5.1 — Infrastructure: EventServiceProvider

**Problem**: Laravel 12 has no `EventServiceProvider`. `OrderPlaced::dispatch()` fires but no listeners are registered. `TestOrderPlacedListener` is dead code.

**Action**: Create `app/Providers/EventServiceProvider.php` with a `$listen` array mapping events to listeners. Register it in `bootstrap/app.php`:

```php
->withProviders([
    App\Providers\EventServiceProvider::class,
])
```

### 5.2 — New Events

| Event | File | Dispatch site |
|---|---|---|
| `ProductLowStock` | `app/Events/ProductLowStock.php` | `OrderService::finalizePaymentIntent()` — after stock decrement, check each product's `stock <= low_stock_threshold` |
| `VendorApproved` | `app/Events/VendorApproved.php` | `VendorApplicationResource` approve action |

`OrderPlaced` already exists and is dispatched correctly in `OrderService::finalizePaymentIntent()` at line 131 (after `$order->fresh(...)`).

### 5.3 — Queued Jobs

All jobs implement `ShouldQueue`, use `$afterCommit = true`, and set `$tries = 3`.

| Job | Dispatched by | Sends to |
|---|---|---|
| `SendOrderConfirmationEmail` | `SendOrderConfirmationListener` (hears `OrderPlaced`) | Customer (User) via `OrderConfirmationNotification` (mail) |
| `NotifyVendorOfNewOrder` | `NotifyVendorsOfNewOrderListener` (hears `OrderPlaced`) | Each vendor in the order via `NewOrderNotification` (mail + database) |
| `NotifyVendorOfLowStock` | `SendLowStockNotificationListener` (hears `ProductLowStock`) | Product's vendor via `LowStockNotification` (mail + database) |
| `NotifyVendorOfApproval` | `SendVendorApprovalNotificationListener` (hears `VendorApproved`) | Vendor via `VendorApprovedNotification` (mail + database) |

**Dispatch pattern**: Listeners dispatch jobs (not send directly) so notification failures don't block event propagation.

### 5.4 — Laravel Notifications

| Notification | Channels | Recipient |
|---|---|---|
| `OrderConfirmationNotification` | `mail` | Customer (User) |
| `NewOrderNotification` | `mail`, `database` | Vendor (User) |
| `LowStockNotification` | `mail`, `database` | Vendor (User) |
| `VendorApprovedNotification` | `mail`, `database` | Vendor (User) |

**Mail views** (Blade templates):
- `resources/views/mail/order-confirmation.blade.php`
- `resources/views/mail/new-order.blade.php`
- `resources/views/mail/low-stock.blade.php`
- `resources/views/mail/vendor-approved.blade.php`

**Database notifications**: Use Laravel's built-in DbNotification content (title + body + action URL). The `notifications` table migration is published via `php artisan vendor:publish --tag="laravel-notifications-migrations"`.

### 5.5 — Listeners (replacing `TestOrderPlacedListener`)

Delete `app/Listeners/TestOrderPlacedListener.php` (dead code). Create:

| Listener | Hears | Action |
|---|---|---|
| `SendOrderConfirmationListener` | `OrderPlaced` | Dispatch `SendOrderConfirmationEmail` job |
| `NotifyVendorsOfNewOrderListener` | `OrderPlaced` | For each `vendorOrder.vendor.user`, dispatch `NotifyVendorOfNewOrder` job |
| `SendLowStockNotificationListener` | `ProductLowStock` | Dispatch `NotifyVendorOfLowStock` job |
| `SendVendorApprovalNotificationListener` | `VendorApproved` | Dispatch `NotifyVendorOfApproval` job |

### 5.6 — Model / Migration Changes

1. **Add `low_stock_threshold` to `products`**: New migration `add_low_stock_threshold_to_products_table` (unsignedTinyInteger, default 5). Add to `Product::$fillable` and `$casts`.
2. **Create `notifications` table**: Publish Laravel's notification migration.
3. **`OrderService::finalizePaymentIntent()`**: After decrementing stock (line 123), loop products and if `$product->stock <= $product->low_stock_threshold`, dispatch `ProductLowStock::dispatch($product)`. Use `$product->wasChanged('stock')` or compare previous value to avoid duplicate notifications.
4. **`VendorStats` widget**: Replace hardcoded `<= 5` with `whereColumn('stock', '<=', 'low_stock_threshold')`.
5. **`VendorApplicationResource` approve action**: After `$user->vendor()->create(...)`, dispatch `VendorApproved::dispatch($vendor->user, $vendorApplication, $vendor)`.

### 5.7 — Queue Worker

- `.env`: already `QUEUE_CONNECTION=database`. No change needed.
- For dev: `composer dev` already runs `queue:listen`. For manual: `php artisan queue:work --tries=1 --timeout=0`.
- For testing: `phpunit.xml` sets `QUEUE_CONNECTION=sync` — jobs run synchronously in tests.

### 5.8 — Demo & Validation

1. **Place an order**: Customer checks out → `finalizePaymentIntent` runs → `OrderPlaced` fires → listeners dispatch jobs → job runs (via `queue:work` process in `composer dev`) → email to `storage/logs/laravel.log` (MAIL_MAILER=log). Verify order confirmation email in log.
2. **Stock drops below threshold**: Create product with `stock=3`, `low_stock_threshold=5`. Place order for 1 unit → stock drops to 2 → `ProductLowStock` fires → `NotifyVendorOfLowStock` job → email to vendor's log. Verify low-stock email in log.
3. **Run** `php artisan test` to ensure all existing + new tests pass.

### 5.9 — Test File

`tests/Feature/NotificationTest.php`:
- `test_order_confirmation_email_sent_on_order_placed`: Use `Mail::fake()` + `Queue::fake()`, call `$orderService->finalizePaymentIntent()`, assert `SendOrderConfirmationEmail` job dispatched.
- `test_low_stock_notification_when_stock_below_threshold`: Create product with stock ≤ threshold, trigger stock decrement, assert `NotifyVendorOfLowStock` dispatched.
- `test_vendor_approval_notification`: Approve a VendorApplication via Filament action (or manually dispatch event), assert notification sent.

---

## Phase 6: Vendor Dashboard & Sales Stats

### 6.1 — Vendor Order Resource (Filament)

Create `app/Filament/Vendor/Resources/VendorOrders/`:

**Directory structure**:
```
app/Filament/Vendor/Resources/VendorOrders/
├── VendorOrderResource.php
├── Tables/VendorOrdersTable.php
├── Schemas/VendorOrderInfolist.php
└── Pages/
    ├── ListVendorOrders.php
    └── ViewVendorOrder.php
```

**VendorOrderResource**:
- `model = VendorOrder::class`
- `getEloquentQuery()`: scope to `vendor_id = auth()->user()->vendor->id`
- Table columns: Order # (via order.order_number), Order Date, Status badge, Items count, Total (money)
- `getPages()`: `index` (ListVendorOrders), `view` (ViewVendorOrder)
- No `create`/`edit` — vendor order updates go through status actions only

**ListVendorOrders**: Table has ViewAction only (no create/edit).

**ViewVendorOrder**: ViewRecord page showing:
- Order number, date, customer name/email
- Status dropdown action (pending → processing → shipped → delivered)
- Items table (product_name, quantity, unit_price, subtotal)
- Subtotal/Total

### 6.2 — Order Status Values

Current: `orders.status` and `vendor_orders.status` are plain strings defaulting to `'pending'`.

**Status flow for vendor_orders**: `pending` → `processing` → `shipped` → `delivered` → `cancelled`.
**Parent order status**: informational; admin can set via OrderResource. Vendor manages only `vendor_orders.status`.

**Status transitions** (enforced in the Filament status action):
- `processing` → `shipped` (vendor action)
- `shipped` → `delivered` (vendor action)
- Any active state → `cancelled` (vendor action, e.g. out of stock)
- `cancelled` / `delivered` are terminal states

### 6.3 — Sales Stats Charts

**Existing**: `app/Filament/Vendor/Widgets/VendorStats.php` — StatsOverviewWidget with product counts and low stock.

**New Chart widgets**:

1. **`VendorSalesChart`** (ChartWidget, `type: 'line'`): Revenue over time (last 30 days). Query grouped by date.
2. **`VendorTopProductsChart`** (ChartWidget, `type: 'bar'`): Top 5 products by revenue.

**Registration**: Add to `VendorPanelProvider::$widgets` alongside existing `VendorStats`.

### 6.4 — Inventory Integration with Phase 5

- `VendorProductResource` form: Add `low_stock_threshold` field (TextInput, numeric, default 5).
- `VendorProductsTable`: Add low-stock column or badge color-coding (`stock <= low_stock_threshold` = red).
- `VendorStats` widget: Already updated in Phase 5.

### 6.5 — Demo & Validation

1. **Vendor dashboard**: Log in as vendor, navigate to `/vendor` → see VendorStats + sales charts.
2. **Order management**: Vendor → VendorOrderResource list → click an order → update status from `processing` to `shipped`.
3. **Low stock indicator**: View VendorProducts list → see low-stock badge for products with `stock <= low_stock_threshold`.
4. **Queue worker**: Start `php artisan queue:work` → complete a purchase → verify vendor new-order notification email in `storage/logs/laravel.log`.

---

## Phase 7: Reviews & Ratings

### 7.1 — Database

Migration: `create_reviews_table`:
```php
Schema::create('reviews', function (Blueprint $table) {
    $table->id();
    $table->morphs('reviewable');          // reviewable_id, reviewable_type
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->unsignedTinyInteger('rating'); // 1-5
    $table->string('title')->nullable();
    $table->text('comment')->nullable();
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
    $table->timestamps();
    $table->unique(['reviewable_id', 'reviewable_type', 'user_id']);
});
```

Migration: `add_average_rating_to_products_table`:
```php
Schema::table('products', function (Blueprint $table) {
    $table->decimal('average_rating', 3, 2)->default(0);
    $table->unsignedInteger('review_count')->default(0);
});
```

### 7.2 — Models

**Review** (`app/Models/Review.php`):
- `$fillable = ['reviewable_id', 'reviewable_type', 'user_id', 'rating', 'title', 'comment']`
- `reviewable(): MorphTo`
- `user(): BelongsTo`

**Product** (`app/Models/Product.php`):
- Add `average_rating` and `review_count` to `$fillable` + `$casts`
- Add `reviews(): MorphMany` relationship
- Scope: `scopeTopRated($query)` — `orderByDesc('average_rating')`

### 7.3 — ReviewObserver (rating rollup)

`app/Observers/ReviewObserver.php`:
- `created`/`saved`/`updated`/`deleted`: call `$review->reviewable->recalculateRating()` if reviewable is a Product.

**Product::recalculateRating()**:
```php
public function recalculateRating(): void
{
    $avg = $this->reviews()->where('status', 'approved')->avg('rating');
    $this->average_rating = round((float) $avg, 2);
    $this->review_count = $this->reviews()->where('status', 'approved')->count();
    $this->save();
}
```

Register in `AppServiceProvider::boot()`:
```php
Review::observe(ReviewObserver::class);
```

### 7.4 — Purchase Verification

Only customers who purchased the product can review. Logic in `ReviewForm` Livewire component:

```php
public function canReview(Product $product): bool
{
    return auth()->check()
        && !Review::where('reviewable_id', $product->id)
            ->where('reviewable_type', Product::class)
            ->where('user_id', auth()->id())
            ->exists()
        && OrderItem::where('product_id', $product->id)
            ->whereHas('vendorOrder.order', fn($q) => 
                $q->where('user_id', auth()->id())
                  ->where('payment_status', 'paid')
            )
            ->exists();
}
```

### 7.5 — UI Components

**ReviewSection** (`app/Livewire/Products/ReviewSection.php`):
- `public Product $product`
- Loads approved reviews with user
- Computes `canReview`
- Renders `livewire.products.review-section`

**View** (`resources/views/livewire/products/review-section.blade.php`):
- Average rating display (stars + count)
- Sort dropdown: newest, highest rating, lowest rating
- List of reviews (user avatar, name, stars, date, comment)
- If `canReview`: embed `<livewire:review-form :product="$product" />`
- Else if already reviewed: show "You already reviewed this product"

**ReviewForm** (`app/Livewire/Products/ReviewForm.php`):
- Fields: `$rating` (1-5), `$title`, `$comment`
- Validation: `required|integer|min:1|max:5`, `string|max:255`, `nullable|string|max:2000`
- `submit()`: Check `canReview`, create `Review`. Observer recalculates product rating.
- Dispatch `reviewUpdated` event to refresh parent.

### 7.6 — Product Page Integration

Update `resources/views/livewire/products/product-show.blade.php`:
- Add `<livewire:review-section :product="$product" />` after the seller info card.

### 7.7 — ProductList Sort by Rating

Update `app/Livewire/Products/ProductList.php`:
- Add `'rating'` (and `'rating_low'`) to the `$sort` switch statement.
- Case `'rating'`: `$products->orderByDesc('average_rating')`
- Case `'rating_low'`: `$products->orderBy('average_rating')`
- Update the product-list view to include rating sort option.

### 7.8 — Demo & Validation

1. **Customer reviews a purchased product**: Customer who bought product → product page → "Write a Review" form → submit 5-star review → product page shows updated average rating.
2. **Cannot review unpurchased product**: Form is hidden for non-purchasers.
3. **One review per product**: After submitting, form is replaced by "You already reviewed this product."

**Test file**: `tests/Feature/ReviewTest.php`
- `test_customer_can_review_purchased_product`
- `test_customer_cannot_review_unpurchased_product`
- `test_duplicate_review_prevented`

---

## Phase 8: Admin Panel Completion

### 8.1 — New Admin Filament Resources

#### OrderResource (`app/Filament/Admin/Resources/Orders/`)

```
app/Filament/Admin/Resources/Orders/
├── OrderResource.php
├── Tables/OrdersTable.php
├── Schemas/OrderInfolist.php
└── Pages/
    ├── ListOrders.php
    └── ViewOrder.php
```

- Model: `Order`
- Table columns: Order #, Customer (user.name), Status badge, Payment status badge, Total (money), Paid at, Created at
- Filters: status, payment_status, date range
- Actions: View only (admin reads, doesn't edit orders directly)
- ViewOrder page: infolist with order details + nested vendor orders table

#### VendorResource (`app/Filament/Admin/Resources/Vendors/`)

```
app/Filament/Admin/Resources/Vendors/
├── VendorResource.php
├── Tables/VendorsTable.php
├── Schemas/VendorInfolist.php
└── Pages/
    ├── ListVendors.php
    ├── ViewVendor.php
    └── EditVendor.php
```

- Model: `Vendor`
- Table columns: Store name, User, Verified badge, Active badge, Created at
- Edit form: Toggle `is_verified`, `is_active`, store info fields
- Uses inline action `toggleActive` to suspend/reactivate vendor

#### UserResource (`app/Filament/Admin/Resources/Users/`)

```
app/Filament/Admin/Resources/Users/
├── UserResource.php
├── Tables/UsersTable.php
├── Schemas/UserInfolist.php
└── Pages/
    ├── ListUsers.php
    ├── ViewUser.php
    └── EditUser.php
```

- Model: `User`
- Table columns: Name, Email, Roles badges, Active badge, Created at
- Edit form: Name, email, assign roles (multi-select via Spatie), toggle `is_active`

### 8.2 — Schema Changes

1. **Add `is_active` to vendors table**: New migration `add_is_active_to_vendors_table` (boolean, default true). Required for vendor suspension.

### 8.3 — Vendor Suspension Logic

When a vendor is suspended (`is_active = false`):
- **Vendor panel access blocked**: Update `User::canAccessPanel()` — for 'vendor' panel, also check `$this->vendor?->is_active`.
- **Products hidden from storefront**: Add scope to `ProductList::render()` — `whereHas('vendor', fn($q) => $q->where('is_active', true))`.
- **New orders blocked**: In `CartService::assertPurchasable()`, add check `!$product->vendor?->is_active`.

### 8.4 — Product Takedown

Already supported via `ProductResource` approve/reject actions in admin panel. Admin can set `status` to `rejected` or `draft` to take down a product. No migration needed — document the existing flow.

### 8.5 — Admin Dashboard Widgets

Create `app/Filament/Admin/Widgets/`:

1. **`PlatformStats`** (StatsOverviewWidget):
   - Total revenue (sum of all paid orders)
   - Total orders (count of orders with `payment_status = paid`)
   - Total vendors (count of vendors)
   - Total products (count of approved products)
   - Total customers (count of Customer role users)

2. **`PlatformRevenueChart`** (ChartWidget, `type: 'line'`):
   - Daily revenue for last 30 days

**Registration**: Add to `AdminPanelProvider::$widgets`:
```php
->widgets([
    AccountWidget::class,
    FilamentInfoWidget::class,
    PlatformStats::class,
    PlatformRevenueChart::class,
])
```

### 8.6 — Demo & Validation

1. **Admin oversight**: Log in as admin → `/admin` → see PlatformStats + revenue chart → navigate to Users, Vendors, Orders resources.
2. **Vendor suspension**: Admin → Vendors → Edit → uncheck "Active" → save → vendor can't access `/vendor`, products hidden from storefront.
3. **Order view**: Admin → Orders → click any order → see full details with vendor breakdown and items.

### 8.7 — Test File

`tests/Feature/AdminPanelTest.php`:
- `test_admin_can_view_all_orders`
- `test_vendor_suspension_hides_products`
- `test_admin_can_suspend_vendor`

---

## Implementation Order (Recommended)

1. **Phase 5** first (foundation): events, listeners, jobs, notifications, queue setup.
2. **Phase 7** (reviews) — independent of Phase 6, adds reviews table + average_rating columns.
3. **Phase 6** (vendor dashboard) — builds on order model + Phase 5 notifications.
4. **Phase 8** (admin completion) — adds resources, can run in parallel with Phase 6.

## File Manifest (All Files to Create/Modify)

### Phase 5
- CREATE `app/Providers/EventServiceProvider.php`
- EDIT `bootstrap/app.php`
- CREATE `app/Events/ProductLowStock.php`
- CREATE `app/Events/VendorApproved.php`
- DELETE `app/Listeners/TestOrderPlacedListener.php`
- CREATE `app/Listeners/SendOrderConfirmationListener.php`
- CREATE `app/Listeners/NotifyVendorsOfNewOrderListener.php`
- CREATE `app/Listeners/SendLowStockNotificationListener.php`
- CREATE `app/Listeners/SendVendorApprovalNotificationListener.php`
- CREATE `app/Jobs/SendOrderConfirmationEmail.php`
- CREATE `app/Jobs/NotifyVendorOfNewOrder.php`
- CREATE `app/Jobs/NotifyVendorOfLowStock.php`
- CREATE `app/Jobs/NotifyVendorOfApproval.php`
- CREATE `app/Notifications/OrderConfirmationNotification.php`
- CREATE `app/Notifications/NewOrderNotification.php`
- CREATE `app/Notifications/LowStockNotification.php`
- CREATE `app/Notifications/VendorApprovedNotification.php`
- CREATE mail views (4 files)
- MIGRATION: `add_low_stock_threshold_to_products_table`
- MIGRATION: create `notifications` table
- EDIT `app/Models/Product.php`
- EDIT `app/Services/OrderService.php`
- EDIT `app/Filament/Vendor/Widgets/VendorStats.php`
- EDIT `VendorApplicationResource.php` (dispatch VendorApproved)
- CREATE `tests/Feature/NotificationTest.php`

### Phase 6
- CREATE `VendorOrderResource.php` + supporting files (5 files total)
- EDIT `VendorProductResource.php` — add low_stock_threshold field
- EDIT `VendorProductsTable.php` — low-stock indicator
- CREATE `VendorSalesChart.php`, `VendorTopProductsChart.php`
- EDIT `VendorPanelProvider.php` — register widgets

### Phase 7
- MIGRATION: `create_reviews_table`
- MIGRATION: `add_average_rating_to_products_table`
- CREATE `app/Models/Review.php`
- EDIT `app/Models/Product.php`
- CREATE `app/Observers/ReviewObserver.php`
- EDIT `AppServiceProvider.php` — register observer
- CREATE `ReviewSection.php`, `ReviewForm.php` Livewire components
- CREATE view files (2)
- EDIT `product-show.blade.php` — include review section
- EDIT `ProductList.php` — add rating sort
- EDIT `product-list.blade.php` — add rating sort option
- CREATE `tests/Feature/ReviewTest.php`

### Phase 8
- MIGRATION: `add_is_active_to_vendors_table`
- CREATE `OrderResource.php` + supporting files (5 files)
- CREATE `VendorResource.php` + supporting files (7 files)
- CREATE `UserResource.php` + supporting files (6 files)
- CREATE `PlatformStats.php`, `PlatformRevenueChart.php`
- EDIT `AdminPanelProvider.php` — register widgets
- EDIT `User.php::canAccessPanel()` — vendor suspension check
- EDIT `CartService.php::assertPurchasable()` — block suspended vendors
- EDIT `ProductList.php::render()` — exclude suspended vendors
- CREATE `UserPolicy.php`
- EDIT `VendorPolicy.php` — add view/viewAny
- CREATE `tests/Feature/AdminPanelTest.php`

## Risks & Mitigations

| Risk | Mitigation |
|---|---|
| Queue jobs fail silently | `QUEUE_CONNECTION=sync` in tests; run `queue:work` + check logs in dev |
| ProductLowStock fires repeatedly | Compare previous stock value; only dispatch when crossing threshold |
| Average rating staleness | `ReviewObserver` on create/update/delete; bulk ops won't trigger (acceptable) |
| Order status inconsistency | Parent order status is informational; vendor manages vendor_order status |
| Vendor suspension breaks vendor login | `canAccessPanel` returns false gracefully; Filament shows access denied |
| Filament Chart widget needs Chart.js | Filament v5 bundles Chart.js in its assets. No npm change needed. |
| EventServiceProvider not loaded | Must register in `bootstrap/app.php` via `->withProviders()` |
| Duplicate reviews | Unique index on `(reviewable_id, reviewable_type, user_id)`; check in `canReview` |

## Validation Checklist

- [ ] `php artisan test` — all existing tests pass
- [ ] Place order → order confirmation email in log
- [ ] Stock drops below threshold → vendor low-stock notification in log
- [ ] Vendor application approved → vendor approval notification in log
- [ ] Vendor can view their orders in Filament vendor panel
- [ ] Vendor can update order fulfillment status (processing → shipped)
- [ ] Vendor sees sales charts on dashboard
- [ ] Customer who bought product can review
- [ ] Product page shows updated average rating
- [ ] Product list can sort by rating
- [ ] Admin can view all users, vendors, orders
- [ ] Admin can suspend a vendor (blocked from panel, products hidden)
- [ ] Admin dashboard shows platform stats + revenue chart
