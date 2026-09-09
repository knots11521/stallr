<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PlatformStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(
                'Total Revenue',
                '₱'.number_format((float) Order::where('payment_status', 'paid')->sum('total'), 2)
            ),

            Stat::make(
                'Total Orders',
                Order::where('payment_status', 'paid')->count()
            ),

            Stat::make(
                'Total Vendors',
                Vendor::count()
            ),

            Stat::make(
                'Total Products',
                Product::where('status', 'approved')->count()
            ),

            Stat::make(
                'Total Customers',
                User::role('Customer')->count()
            ),
        ];
    }
}
