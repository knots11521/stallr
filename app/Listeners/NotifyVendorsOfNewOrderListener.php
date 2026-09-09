<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Jobs\NotifyVendorOfNewOrder;

class NotifyVendorsOfNewOrderListener
{
    public function handle(OrderPlaced $event): void
    {
        foreach ($event->order->vendorOrders as $vendorOrder) {
            if ($vendorOrder->vendor && $vendorOrder->vendor->user) {
                NotifyVendorOfNewOrder::dispatch(
                    $vendorOrder->vendor->user,
                    $event->order,
                    $vendorOrder
                );
            }
        }
    }
}
