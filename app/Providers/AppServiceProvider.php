<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\VendorApplication;
use App\Policies\VendorApplicationPolicy;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Gate::policy(
            VendorApplication::class,
            VendorApplicationPolicy::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
