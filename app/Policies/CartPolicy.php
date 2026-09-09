<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\User;

class CartPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Customer');
    }

    public function view(User $user, Cart $cart): bool
    {
        return $user->hasRole('Admin') || $cart->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Customer');
    }

    public function update(User $user, Cart $cart): bool
    {
        return $user->hasRole('Admin') || $cart->user_id === $user->id;
    }

    public function delete(User $user, Cart $cart): bool
    {
        return $user->hasRole('Admin') || $cart->user_id === $user->id;
    }
}
