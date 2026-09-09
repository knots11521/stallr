<?php

namespace App\Filament\Vendor\Resources\VendorOrders\Pages;

use App\Filament\Vendor\Resources\VendorOrders\VendorOrderResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewVendorOrder extends ViewRecord
{
    protected static string $resource = VendorOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('mark_as_processing')
                ->label('Mark as Processing')
                ->color('info')
                ->action(fn (self $record) => $record->update(['status' => 'processing']))
                ->visible(fn (self $record) => $record->status === 'pending'),

            Action::make('mark_as_shipped')
                ->label('Mark as Shipped')
                ->color('primary')
                ->action(fn (self $record) => $record->update(['status' => 'shipped']))
                ->visible(fn (self $record) => in_array($record->status, ['pending', 'processing'])),

            Action::make('mark_as_delivered')
                ->label('Mark as Delivered')
                ->color('success')
                ->action(fn (self $record) => $record->update(['status' => 'delivered']))
                ->visible(fn (self $record) => in_array($record->status, ['pending', 'processing', 'shipped'])),

            Action::make('cancel_order')
                ->label('Cancel Order')
                ->color('danger')
                ->action(fn (self $record) => $record->update(['status' => 'cancelled']))
                ->requiresConfirmation()
                ->visible(fn (self $record) => ! in_array($record->status, ['cancelled', 'delivered'])),
        ];
    }
}
