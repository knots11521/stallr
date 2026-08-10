<?php

namespace App\Filament\Vendor\Resources\VendorProducts\Pages;

use App\Filament\Vendor\Resources\VendorProducts\VendorProductResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditVendorProduct extends EditRecord
{
    protected static string $resource = VendorProductResource::class;

    protected array $uploadedImagePaths = [];

    protected function mutateFormDataBeforeSave(array $data): array
    {
        /*
         * FileUpload is named 'images', so Filament
         * puts the uploaded image paths in $data['images'].
         */
        $this->uploadedImagePaths = $data['images'] ?? [];

        /*
         * 'images' is not a column in the products table.
         */
        unset($data['images']);

        return $data;
    }

    protected function afterSave(): void
    {
        /*
         * Add newly uploaded images to product_images.
         */
        foreach ($this->uploadedImagePaths as $imagePath) {
            $this->record->images()->create([
                'image_path' => $imagePath,
                'sort_order' => $this->record->images()->count(),
            ]);
        }
    }

    protected function getRedirectUrl(): string
    {
        return VendorProductResource::getUrl('view', [
            'record' => $this->record,
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
