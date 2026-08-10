<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class OrderHistory extends Component
{
    use WithPagination;

    public function render()
    {
        $orders = Order::query()
            ->where('user_id', Auth::id())
            ->with([
                'vendorOrders.vendor',
                'vendorOrders.items',
            ])
            ->latest()
            ->paginate(10);

        return view(
            'livewire.orders.order-history',
            [
                'orders' => $orders,
            ]
        );
    }
}
