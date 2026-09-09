<?php

namespace App\Jobs;

use App\Models\Order;
use App\Notifications\OrderConfirmationNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOrderConfirmationEmail implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public function __construct(
        public Order $order
    ) {
        $this->afterCommit = true;
    }

    public function handle(): void
    {
        $this->order->load('user', 'vendorOrders.items', 'vendorOrders.vendor');

        if (! $this->order->user) {
            return;
        }

        $this->order->user->notify(
            new OrderConfirmationNotification($this->order)
        );
    }
}
