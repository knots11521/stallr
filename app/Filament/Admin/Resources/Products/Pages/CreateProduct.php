<?php

namespace App\Filament\Admin\Resources\Products\Pages;

use App\Filament\Admin\Resources\Products\ProductResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();

        $data['vendor_id'] = $user->vendor->id;

        $data['status'] = 'pending';

        return $data;
    }

    protected function afterCreate(): void
    {
        $product = $this->record;

        foreach ($this->data['images'] ?? [] as $index => $image) {

            $product->images()->create([
                'image_path' => $image,
                'sort_order' => $index,
            ]);
        }
    }
}
