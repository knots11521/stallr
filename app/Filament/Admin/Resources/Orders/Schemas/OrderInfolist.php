<?php

namespace App\Filament\Admin\Resources\Orders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Order Details')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('order_number')
                                    ->label('Order Number'),

                                TextEntry::make('created_at')
                                    ->label('Order Date')
                                    ->dateTime('M d, Y h:i A'),

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
                            ]),

                        Grid::make(3)
                            ->schema([
                                TextEntry::make('payment_status')
                                    ->label('Payment Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'pending' => 'warning',
                                        'paid' => 'success',
                                        'failed' => 'danger',
                                        default => 'gray',
                                    }),

                                TextEntry::make('paid_at')
                                    ->label('Paid At')
                                    ->dateTime('M d, Y h:i A'),

                                TextEntry::make('currency')
                                    ->label('Currency'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextEntry::make('subtotal')
                                    ->label('Subtotal')
                                    ->money('PHP'),

                                TextEntry::make('total')
                                    ->label('Total')
                                    ->money('PHP'),
                            ]),
                    ]),

                Section::make('Customer')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('user.name')
                                    ->label('Name'),

                                TextEntry::make('user.email')
                                    ->label('Email'),
                            ]),
                    ]),

                Section::make('Vendor Orders')
                    ->schema([
                        TextEntry::make('vendor_orders')
                            ->label('Orders')
                            ->view('filament.order-vendor-orders')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
