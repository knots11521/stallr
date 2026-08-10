<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Admin can view everything.
     * Vendor can view only their own products.
     * Customer can view approved products.
     */
    public function view(User $user, Product $product): bool
    {
        if ($user->hasRole('Admin')) {
            return true;
        }

        if ($user->hasRole('Vendor')) {
            return $product->vendor->user_id === $user->id;
        }

        return $product->status === 'approved';
    }

    /**
     * Vendors can create products.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Vendor');
    }

    /**
     * Vendors can update only their own products.
     * Admin can update everything.
     */
    public function update(User $user, Product $product): bool
    {
        if ($user->hasRole('Admin')) {
            return true;
        }

        return $user->hasRole('Vendor')
            && $product->vendor->user_id === $user->id;
    }

    /**
     * Vendors can delete only their own products.
     * Admin can delete everything.
     */
    public function delete(User $user, Product $product): bool
    {
        if ($user->hasRole('Admin')) {
            return true;
        }

        return $user->hasRole('Vendor')
            && $product->vendor->user_id === $user->id;
    }

    /**
     * Only admins can approve.
     */
    public function approve(User $user): bool
    {
        return $user->hasRole('Admin');
    }

    /**
     * Only admins can reject.
     */
    public function reject(User $user): bool
    {
        return $user->hasRole('Admin');
    }
}
