<?php

namespace App\Filament\Vendor\Resources\VendorOrders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VendorOrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Order Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('order.order_number')
                                    ->label('Order Number'),

                                TextEntry::make('order.created_at')
                                    ->label('Order Date')
                                    ->dateTime('M d, Y h:i A'),

                                TextEntry::make('order.user.name')
                                    ->label('Customer'),

                                TextEntry::make('order.user.email')
                                    ->label('Customer Email'),

                                TextEntry::make('status')
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

                                TextEntry::make('order.payment_status')
                                    ->label('Payment Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'pending' => 'warning',
                                        'paid' => 'success',
                                        'failed' => 'danger',
                                        default => 'gray',
                                    }),

                                TextEntry::make('total')
                                    ->label('Store Total')
                                    ->money('PHP')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Order Items')
                    ->schema([
                        TextEntry::make('items')
                            ->label('Items')
                            ->view('filament.vendor-order-items'),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
