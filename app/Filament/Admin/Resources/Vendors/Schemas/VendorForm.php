<?php

namespace App\Filament\Admin\Resources\Vendors\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VendorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Store Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('store_name')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255),
                            ]),

                        Textarea::make('description')
                            ->columnSpanFull(),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('phone')
                                    ->tel()
                                    ->maxLength(255),

                                TextInput::make('address')
                                    ->maxLength(255),
                            ]),
                    ]),

                Section::make('Verification & Status')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Toggle::make('is_verified')
                                    ->label('Verified'),

                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true),
                            ]),
                    ]),

                Section::make('Media')
                    ->schema([
                        FileUpload::make('logo')
                            ->image()
                            ->directory('vendors')
                            ->visibility('public'),

                        FileUpload::make('banner')
                            ->image()
                            ->directory('vendors')
                            ->visibility('public'),
                    ]),
            ]);
    }
}
