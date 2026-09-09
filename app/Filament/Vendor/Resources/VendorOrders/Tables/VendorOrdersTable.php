<?php

namespace App\Filament\Vendor\Resources\VendorOrders\Tables;

use App\Models\VendorOrder;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VendorOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order.order_number')
                    ->label('Order #')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('order.created_at')
                    ->label('Date')
                    ->dateTime('M d, Y')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'processing' => 'info',
                        'shipped' => 'primary',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('items')
                    ->label('Items')
                    ->state(fn (VendorOrder $record) => $record->items->sum('quantity'))
                    ->numeric()
                    ->sortable(false),

                TextColumn::make('total')
                    ->label('Total')
                    ->money('PHP')
                    ->sortable(),
            ])
            ->defaultSort('order.created_at', 'desc')
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
