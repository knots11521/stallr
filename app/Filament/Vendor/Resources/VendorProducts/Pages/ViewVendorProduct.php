<?php

namespace App\Filament\Vendor\Resources\VendorProducts\Pages;

use App\Filament\Vendor\Resources\VendorProducts\VendorProductResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewVendorProduct extends ViewRecord
{
    protected static string $resource = VendorProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
