<?php

namespace App\Events;

use App\Models\Vendor;
use App\Models\VendorApplication;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VendorApproved
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Vendor $vendor,
        public VendorApplication $application
    ) {}
}
