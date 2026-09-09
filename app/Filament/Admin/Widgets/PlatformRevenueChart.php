<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class PlatformRevenueChart extends ChartWidget
{
    protected ?string $heading = 'Daily Revenue (Last 30 Days)';

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $dates = collect();
        for ($i = 29; $i >= 0; $i--) {
            $dates->push(now()->subDays($i)->format('Y-m-d'));
        }

        $revenue = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [now()->subDays(29), now()])
            ->selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $totals = $dates->map(fn (string $date) => $revenue->get($date, 0));

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
