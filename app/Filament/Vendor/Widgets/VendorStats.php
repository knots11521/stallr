<?php

namespace App\Filament\Vendor\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class VendorStats extends BaseWidget
{
    protected function getStats(): array
    {
        $vendor = auth()->user()->vendor;

        if (! $vendor) {
            return [];
        }

        return [

            Stat::make(
                'Total Products',
                $vendor->products()->count()
            ),

            Stat::make(
                'Pending Products',
                $vendor->products()
                    ->where('status', 'pending')
                    ->count()
            ),

            Stat::make(
                'Approved Products',
                $vendor->products()
                    ->where('status', 'approved')
                    ->count()
            ),

            Stat::make(
                'Rejected Products',
                $vendor->products()
                    ->where('status', 'rejected')
                    ->count()
            ),

            Stat::make(
                'Low Stock Products',
                $vendor->products()
                    ->where('stock', '<=', 5)
                    ->count()
            ),

        ];
    }
}
