<?php

namespace App\Listeners;

use App\Events\ProductLowStock;
use App\Jobs\NotifyVendorOfLowStock;

class SendLowStockNotificationListener
{
    public function handle(ProductLowStock $event): void
    {
        $product = $event->product;

        if (! $product->vendor || ! $product->vendor->user) {
            return;
        }

        NotifyVendorOfLowStock::dispatch(
            $product->vendor->user,
            $product
        );
    }
}
