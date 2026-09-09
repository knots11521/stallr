<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Admin') || $user->hasRole('Customer');
    }

    public function view(User $user, Order $order): bool
    {
        if ($user->hasRole('Admin')) {
            return true;
        }

        return $user->hasRole('Customer') && $order->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Customer');
    }

    public function update(User $user, Order $order): bool
    {
        return $user->hasRole('Admin');
    }

    public function delete(User $user, Order $order): bool
    {
        return $user->hasRole('Admin');
    }
}
