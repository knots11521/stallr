<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\Vendor;
use App\Models\VendorApplication;
use App\Observers\ReviewObserver;
use App\Policies\CartPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\OrderPolicy;
use App\Policies\ProductPolicy;
use App\Policies\UserPolicy;
use App\Policies\VendorApplicationPolicy;
use App\Policies\VendorPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.custom');
        Paginator::defaultSimpleView('vendor.pagination.custom');

        Review::observe(ReviewObserver::class);

        Gate::policy(
            VendorApplication::class,
            VendorApplicationPolicy::class
        );

        Gate::policy(
            Product::class,
            ProductPolicy::class
        );

        Gate::policy(
            Order::class,
            OrderPolicy::class
        );

        Gate::policy(
            Cart::class,
            CartPolicy::class
        );

        Gate::policy(
            Category::class,
            CategoryPolicy::class
        );

        Gate::policy(
            Vendor::class,
            VendorPolicy::class
        );

        Gate::policy(
            User::class,
            UserPolicy::class
        );

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
