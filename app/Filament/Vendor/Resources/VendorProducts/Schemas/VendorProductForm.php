<?php

namespace App\Filament\Vendor\Resources\VendorProducts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class VendorProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('images')
                    ->label('Product Images')
                    ->multiple()
                    ->image()
                    ->directory('products')
                    ->disk('public')
                    ->visibility('public')
                    ->reorderable()
                    ->dehydrated(true),
            ]);
    }
}
