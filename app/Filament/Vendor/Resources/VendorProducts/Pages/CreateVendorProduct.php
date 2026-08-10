<?php

namespace App\Filament\Vendor\Resources\VendorProducts\Pages;

use App\Filament\Vendor\Resources\VendorProducts\VendorProductResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateVendorProduct extends CreateRecord
{
    protected static string $resource = VendorProductResource::class;

    protected array $uploadedImagePaths = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();

        $this->uploadedImagePaths = $data['images'] ?? [];

        unset($data['images']);

        $data['vendor_id'] = $user->vendor->id;
        $data['status'] = 'pending';

        return $data;
    }

    protected function afterCreate(): void
    {
        foreach ($this->uploadedImagePaths as $index => $imagePath) {
            $this->record->images()->create([
                'image_path' => $imagePath,
                'sort_order' => $index,
            ]);
        }
    }
}
