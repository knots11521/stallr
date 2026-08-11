<?php

namespace App\Filament\Vendor\Resources\VendorProducts\Pages;

use App\Filament\Vendor\Resources\VendorProducts\VendorProductResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditVendorProduct extends EditRecord
{
    protected static string $resource = VendorProductResource::class;

    /**
     * Image paths submitted by the FileUpload field.
     */
    protected array $submittedImagePaths = [];


    /*
    |--------------------------------------------------------------------------
    | Load Existing Images
    |--------------------------------------------------------------------------
    */

    protected function mutateFormDataBeforeFill(array $data): array
    {
        /*
         * Load existing product images into the FileUpload field.
         *
         * These paths come directly from product_images.
         */
        $data['images'] = $this->record
            ->images()
            ->orderBy('sort_order')
            ->pluck('image_path')
            ->toArray();

        return $data;
    }


    /*
    |--------------------------------------------------------------------------
    | Before Save
    |--------------------------------------------------------------------------
    */

    protected function mutateFormDataBeforeSave(array $data): array
    {
        /*
         * Get the images currently submitted by Filament.
         */
        $this->submittedImagePaths = $data['images'] ?? [];

        /*
         * IMPORTANT:
         *
         * Get the original images directly from the database.
         *
         * Do NOT use a protected property populated during
         * mutateFormDataBeforeFill(), because Livewire requests
         * are separate.
         */
        $originalImagePaths = $this->record
            ->images()
            ->pluck('image_path')
            ->toArray();

        /*
         * Find images that existed in the database but are
         * no longer present in the FileUpload.
         */
        $removedImagePaths = array_diff(
            $originalImagePaths,
            $this->submittedImagePaths
        );

        /*
         * Delete removed images.
         */
        foreach ($removedImagePaths as $imagePath) {

            $image = $this->record
                ->images()
                ->where('image_path', $imagePath)
                ->first();

            if (! $image) {
                continue;
            }

            /*
             * Delete the physical file.
             */
            Storage::disk('public')->delete(
                $image->image_path
            );

            /*
             * Delete the product_images record.
             */
            $image->delete();
        }

        /*
         * 'images' is not a column in the products table.
         */
        unset($data['images']);

        return $data;
    }


    /*
    |--------------------------------------------------------------------------
    | After Save
    |--------------------------------------------------------------------------
    */

    protected function afterSave(): void
    {
        /*
         * Get image paths that are already stored in the database.
         */
        $existingImagePaths = $this->record
            ->images()
            ->pluck('image_path')
            ->toArray();

        /*
         * Add newly uploaded images.
         */
        foreach ($this->submittedImagePaths as $imagePath) {

            /*
             * Skip images that already existed.
             */
            if (in_array($imagePath, $existingImagePaths, true)) {
                continue;
            }

            $this->record->images()->create([
                'image_path' => $imagePath,
                'sort_order' => $this->record->images()->count(),
            ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Redirect
    |--------------------------------------------------------------------------
    */

    protected function getRedirectUrl(): string
    {
        return VendorProductResource::getUrl('view', [
            'record' => $this->record,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Header Actions
    |--------------------------------------------------------------------------
    */

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
