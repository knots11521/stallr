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
| Product Routes
|--------------------------------------------------------------------------
*/

Route::get('/products', ProductList::class)
    ->name('products.index');

Route::get('/products/{product:slug}', ProductShow::class)
    ->name('products.show');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Authentication & Profile
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', Logout::class)
        ->name('logout');

    Route::view('/dashboard', 'dashboard')
        ->middleware('verified')
        ->name('dashboard');

    Route::view('/profile', 'profile')
        ->name('profile');


    /*
    |--------------------------------------------------------------------------
    | Customer Marketplace
    |--------------------------------------------------------------------------
    |
    | Customers can shop, maintain their cart, checkout, and view orders.
    |
    */

    Route::middleware('role:Customer')->group(function () {

        Route::get('/cart', CartPage::class)
            ->name('cart');

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


        /*
        |--------------------------------------------------------------------------
        | Vendor Application
        |--------------------------------------------------------------------------
        */

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
