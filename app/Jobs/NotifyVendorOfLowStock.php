<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\User;
use App\Notifications\LowStockNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyVendorOfLowStock implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public function __construct(
        public User $vendorUser,
        public Product $product
    ) {
        $this->afterCommit = true;
    }

    public function handle(): void
    {
        $this->vendorUser->load('vendor');

        $this->vendorUser->notify(
            new LowStockNotification($this->product)
        );
    }
}
