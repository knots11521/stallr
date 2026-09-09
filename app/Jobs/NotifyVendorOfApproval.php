<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Vendor;
use App\Notifications\VendorApprovedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyVendorOfApproval implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public function __construct(
        public User $vendorUser,
        public Vendor $vendor
    ) {
        $this->afterCommit = true;
    }

    public function handle(): void
    {
        $this->vendorUser->notify(
            new VendorApprovedNotification($this->vendor)
        );
    }
}
