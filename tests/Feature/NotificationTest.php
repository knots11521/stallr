<?php

namespace Tests\Feature;

use App\Events\ProductLowStock;
use App\Events\VendorApproved;
use App\Jobs\NotifyVendorOfLowStock;
use App\Jobs\NotifyVendorOfNewOrder;
use App\Jobs\SendOrderConfirmationEmail;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorApplication;
use App\Notifications\VendorApprovedNotification;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Stripe\PaymentIntent;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    protected function createCustomer(): User
    {
        $user = User::factory()->create();
        $user->assignRole('Customer');

        return $user;
    }

    protected function createVendor(): Vendor
    {
        $user = User::factory()->create();
        $user->assignRole('Vendor');

        return Vendor::factory()->create([
            'user_id' => $user->id,
        ]);
    }

    protected function createApprovedProduct(Vendor $vendor, int $stock = 10, float $price = 100): Product
    {
        return Product::factory()->create([
            'vendor_id' => $vendor->id,
            'status' => 'approved',
            'stock' => $stock,
            'price' => $price,
            'low_stock_threshold' => 5,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Order Confirmation Email
    |--------------------------------------------------------------------------
    */

    public function test_order_confirmation_email_sent_on_order_placed(): void
    {
        Queue::fake();

        $customer = $this->createCustomer();
        $vendor = $this->createVendor();
        $product = $this->createApprovedProduct($vendor, stock: 10, price: 100);

        $cart = Cart::firstOrCreate(['user_id' => $customer->id]);
        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $this->actingAs($customer);

        session(['checkout_items' => [$product->id]]);

        $service = app(OrderService::class);

        $order = $service->createPendingOrder(
            stripePaymentIntentId: 'pi_notification_test',
            expectedAmount: 10000,
            currency: 'PHP'
        );

        $paymentIntent = PaymentIntent::constructFrom([
            'id' => 'pi_notification_test',
            'amount' => 10000,
            'currency' => 'php',
            'status' => 'succeeded',
            'metadata' => [
                'order_id' => (string) $order->id,
                'user_id' => (string) $customer->id,
            ],
        ]);

        $service->finalizePaymentIntent($paymentIntent);

        Queue::assertPushed(SendOrderConfirmationEmail::class);
        Queue::assertPushed(NotifyVendorOfNewOrder::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Low Stock Notification
    |--------------------------------------------------------------------------
    */

    public function test_low_stock_notification_when_stock_below_threshold(): void
    {
        Queue::fake();

        $vendor = $this->createVendor();
        $product = $this->createApprovedProduct($vendor, stock: 3, price: 100);

        ProductLowStock::dispatch($product);

        Queue::assertPushed(NotifyVendorOfLowStock::class, function ($job) use ($vendor, $product) {
            return $job->vendorUser->id === $vendor->user_id
                && $job->product->id === $product->id;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Vendor Approval Notification
    |--------------------------------------------------------------------------
    */

    public function test_vendor_approval_notification(): void
    {
        Notification::fake();

        $user = User::factory()->create();
        $application = VendorApplication::create([
            'user_id' => $user->id,
            'store_name' => 'Test Store',
            'description' => 'Test description',
            'status' => 'pending',
        ]);

        $vendor = $user->vendor()->create([
            'store_name' => 'Test Store',
            'slug' => 'test-store',
            'is_verified' => true,
            'is_active' => true,
        ]);

        VendorApproved::dispatch($vendor, $application);

        Notification::assertSentTo(
            $user,
            VendorApprovedNotification::class
        );
    }
}
