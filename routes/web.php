<?php

use App\Http\Controllers\CheckoutSuccessController;
use App\Http\Controllers\StripeWebhookController;
use App\Livewire\Actions\Logout;
use App\Livewire\Cart\CartPage;
use App\Livewire\Checkout\CheckoutPage;
use App\Livewire\Orders\OrderConfirmation;
use App\Livewire\Orders\OrderHistory;
use App\Livewire\Products\ProductList;
use App\Livewire\Products\ProductShow;
use App\Livewire\Vendor\ApplicationPage;
use App\Models\Category;
use App\Http\Middleware\PreventAdminFromStore;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome', [
        'categories' => Category::orderBy('name')->get(),
    ]);
})->name('home');


/*
|--------------------------------------------------------------------------
| Public Marketplace
|--------------------------------------------------------------------------
|
| Guests, Customers, and Vendors can browse the marketplace.
| Admins are blocked from the customer-facing store.
|
*/

Route::middleware(PreventAdminFromStore::class)->group(function () {

    Route::get('/products', ProductList::class)
        ->name('products.index');

    Route::get('/products/{product:slug}', ProductShow::class)
        ->name('products.show');
});


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', Logout::class)
        ->name('logout');


    /*
    |--------------------------------------------------------------------------
    | Customer & Vendor Dashboard
    |--------------------------------------------------------------------------
    |
    | Customers and Vendors can access the regular dashboard.
    | Admins use the separate Filament Admin panel.
    |
    */

    Route::view('/dashboard', 'dashboard')
        ->middleware(['verified', 'role:Customer|Vendor'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Customer & Vendor Profile
    |--------------------------------------------------------------------------
    */

    Route::view('/profile', 'profile')
        ->middleware('role:Customer|Vendor')
        ->name('profile');


    /*
    |--------------------------------------------------------------------------
    | Customer & Vendor Marketplace
    |--------------------------------------------------------------------------
    |
    | Vendors are also marketplace customers, so both Customers
    | and Vendors can use cart, checkout, and orders.
    |
    */

    Route::middleware('role:Customer|Vendor')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Cart
        |--------------------------------------------------------------------------
        */

        Route::get('/cart', CartPage::class)
            ->name('cart');


        /*
        |--------------------------------------------------------------------------
        | Checkout
        |--------------------------------------------------------------------------
        */

        Route::get('/checkout', CheckoutPage::class)
            ->name('checkout');

        Route::get('/checkout/success', CheckoutSuccessController::class)
            ->name('checkout.success');


        /*
        |--------------------------------------------------------------------------
        | Orders
        |--------------------------------------------------------------------------
        */

        Route::prefix('orders')
            ->name('orders.')
            ->group(function () {

                Route::get('/', OrderHistory::class)
                    ->name('index');

                Route::get('/{order}', OrderConfirmation::class)
                    ->name('show');
            });
    });


    /*
    |--------------------------------------------------------------------------
    | Vendor Application
    |--------------------------------------------------------------------------
    |
    | Only Customers can submit a Vendor application.
    | Vendors cannot submit another application.
    |
    */

    Route::middleware('role:Customer')->group(function () {

        Route::get('/vendor/apply', ApplicationPage::class)
            ->name('vendor.apply');
    });
});


/*
|--------------------------------------------------------------------------
| Stripe Webhook
|--------------------------------------------------------------------------
|
| Stripe calls this endpoint directly.
| It must not require authentication or a CSRF token.
|
*/

Route::post('/stripe/webhook', StripeWebhookController::class)
    ->withoutMiddleware(ValidateCsrfToken::class)
    ->name('stripe.webhook');


/*
|--------------------------------------------------------------------------
| Breeze Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
