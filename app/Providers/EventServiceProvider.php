<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use App\Events\ProductLowStock;
use App\Events\VendorApproved;
use App\Listeners\NotifyVendorsOfNewOrderListener;
use App\Listeners\SendLowStockNotificationListener;
use App\Listeners\SendOrderConfirmationListener;
use App\Listeners\SendVendorApprovalNotificationListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderPlaced::class => [
            SendOrderConfirmationListener::class,
            NotifyVendorsOfNewOrderListener::class,
        ],

        ProductLowStock::class => [
            SendLowStockNotificationListener::class,
        ],

        VendorApproved::class => [
            SendVendorApprovalNotificationListener::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();
    }
}
