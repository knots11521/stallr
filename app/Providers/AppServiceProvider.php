<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\VendorApplication;
use App\Policies\ProductPolicy;
use App\Policies\VendorApplicationPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        Gate::policy(
            VendorApplication::class,
            VendorApplicationPolicy::class
        );

        Gate::policy(
            Product::class,
            ProductPolicy::class
        );

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
