<?php

namespace App\Listeners;

use App\Events\VendorApproved;
use App\Jobs\NotifyVendorOfApproval;

class SendVendorApprovalNotificationListener
{
    public function handle(VendorApproved $event): void
    {
        NotifyVendorOfApproval::dispatch(
            $event->vendor->user,
            $event->vendor
        );
    }
}
