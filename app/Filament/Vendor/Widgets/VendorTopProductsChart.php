<?php

namespace App\Filament\Vendor\Widgets;

use App\Models\OrderItem;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class VendorTopProductsChart extends ChartWidget
{
    protected ?string $heading = 'Top Products by Revenue';

    protected int|string|array $columnSpan = 'half';

    protected function getData(): array
    {
        $vendor = Auth::user()->vendor;

        if (! $vendor) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        $topProducts = OrderItem::query()
            ->whereHas('vendorOrder', function ($query) use ($vendor) {
                $query->where('vendor_id', $vendor->id)
                    ->whereIn('status', ['processing', 'shipped', 'delivered']);
            })
            ->selectRaw('product_name, SUM(subtotal) as revenue, SUM(quantity) as quantity')
            ->groupBy('product_name')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $topProducts->pluck('revenue')->toArray(),
                    'backgroundColor' => 'rgba(245, 158, 11, 0.5)',
                    'borderColor' => 'rgb(245 158 11)',
                ],
            ],
            'labels' => $topProducts->pluck('product_name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
