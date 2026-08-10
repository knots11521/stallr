<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VendorApplication;

class VendorApplicationPolicy
{
    /**
     * Customer can create vendor applications.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Customer');
    }


    /**
     * Admin can approve applications.
     */
    public function approve(User $user, VendorApplication $vendorApplication): bool
    {
        return $user->hasRole('Admin');
    }


    /**
     * Admin can reject applications.
     */
    public function reject(User $user, VendorApplication $vendorApplication): bool
    {
        return $user->hasRole('Admin');
    }
}
