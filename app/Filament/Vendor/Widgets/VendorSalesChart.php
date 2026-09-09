<?php

namespace App\Filament\Vendor\Widgets;

use App\Models\VendorOrder;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class VendorSalesChart extends ChartWidget
{
    protected ?string $heading = 'Sales (Last 30 Days)';

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $vendor = Auth::user()->vendor;

        if (! $vendor) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        $dates = collect();
        for ($i = 29; $i >= 0; $i--) {
            $dates->push(now()->subDays($i)->format('Y-m-d'));
        }

        $sales = VendorOrder::where('vendor_id', $vendor->id)
            ->whereIn('status', ['processing', 'shipped', 'delivered'])
            ->whereBetween('created_at', [now()->subDays(29), now()])
            ->selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $totals = $dates->map(fn (string $date) => $sales->get($date, 0));

        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $totals->values()->toArray(),
                    'borderColor' => 'rgb(245 158 11)',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $dates->map(fn (string $date) => Carbon::parse($date)->format('M d'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
