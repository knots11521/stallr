<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderConfirmation extends Component
{
    public Order $order;

    public function mount(Order $order): void
    {
        /*
        |--------------------------------------------------------------------------
        | Security
        |--------------------------------------------------------------------------
        |
        | A customer may only view their own order.
        |
        */

        abort_unless(
            $order->user_id === Auth::id(),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Load Order Relationships
        |--------------------------------------------------------------------------
        */

        $this->order = $order->load([
            'vendorOrders.vendor',
            'vendorOrders.items',
        ]);
    }

    public function render()
    {
        return view(
            'livewire.orders.order-confirmation'
        );
    }
}
