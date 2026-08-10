<?php

namespace App\Filament\Resources\VendorApplications\Pages;

use App\Filament\Resources\VendorApplications\VendorApplicationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVendorApplication extends EditRecord
{
    protected static string $resource = VendorApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
