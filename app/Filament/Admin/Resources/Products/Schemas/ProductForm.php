<?php

namespace App\Filament\Admin\Resources\Products\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('vendor_id')
                    ->relationship('vendor', 'id')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('sku')
                    ->label('SKU')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->default(0),
                Select::make('status')
                    ->options(['draft' => 'Draft', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'])
                    ->default('draft')
                    ->required(),
                Toggle::make('is_featured')
                    ->required(),
                DateTimePicker::make('approved_at'),
                TextInput::make('approved_by')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
