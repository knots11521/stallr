<?php

namespace App\Livewire\Dashboard;

use App\Models\Order;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardStats extends Component
{
    public function render()
    {
        $user = Auth::user();

        $totalOrders = Order::query()
            ->where('user_id', $user->id)
            ->count();

        $totalSpent = Order::query()
            ->where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->sum('total');

        $cartCount = app(CartService::class)->count();

        $recentOrders = Order::query()
            ->where('user_id', $user->id)
            ->with('vendorOrders.vendor')
            ->latest()
            ->limit(5)
            ->get();

        $vendor = $user->vendor;

        $vendorStats = null;

        if ($vendor) {
            $vendorStats = [
                'total_products' => $vendor->products()->count(),
                'pending_products' => $vendor->products()
                    ->where('status', 'pending')
                    ->count(),
                'approved_products' => $vendor->products()
                    ->where('status', 'approved')
                    ->count(),
                'low_stock_products' => $vendor->products()
                    ->whereColumn('stock', '<=', 'low_stock_threshold')
                    ->count(),
            ];
        }

        return view('livewire.dashboard.dashboard-stats', [
            'user' => $user,
            'totalOrders' => $totalOrders,
            'totalSpent' => $totalSpent,
            'cartCount' => $cartCount,
            'recentOrders' => $recentOrders,
            'vendor' => $vendor,
            'vendorStats' => $vendorStats,
        ]);
    }
}
