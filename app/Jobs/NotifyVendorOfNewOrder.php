<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\User;
use App\Models\VendorOrder;
use App\Notifications\NewOrderNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyVendorOfNewOrder implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public function __construct(
        public User $vendorUser,
        public Order $order,
        public VendorOrder $vendorOrder
    ) {
        $this->afterCommit = true;
    }

    public function handle(): void
    {
        $this->vendorUser->load('vendor');

        $this->vendorUser->notify(
            new NewOrderNotification($this->order, $this->vendorOrder)
        );
    }
}
