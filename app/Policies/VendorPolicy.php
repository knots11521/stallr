<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vendor;

class VendorPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Admin');
    }

    public function view(User $user, Vendor $vendor): bool
    {
        return $user->hasRole('Admin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Admin');
    }

    public function update(User $user, Vendor $vendor): bool
    {
        if ($user->hasRole('Admin')) {
            return true;
        }

        return $vendor->user_id === $user->id;
    }

    public function delete(User $user, Vendor $vendor): bool
    {
        return $user->hasRole('Admin');
    }
}
