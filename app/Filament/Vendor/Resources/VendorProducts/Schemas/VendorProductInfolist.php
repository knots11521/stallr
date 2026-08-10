<?php

namespace App\Filament\Vendor\Resources\VendorProducts\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VendorProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /*
                |--------------------------------------------------------------------------
                | Product Overview
                |--------------------------------------------------------------------------
                */

                Section::make('Product Overview')
                    ->schema([
                        Grid::make(2)
                            ->schema([

                                /*
                                |--------------------------------------------------------------------------
                                | Product Images
                                |--------------------------------------------------------------------------
                                */

                                ImageEntry::make('images.image_path')
                                    ->label('Product Images')
                                    ->disk('public')
                                    ->visibility('public')
                                    ->height(180)
                                    ->width(180)
                                    ->extraImgAttributes([
                                        'class' => 'rounded-xl object-cover cursor-pointer',
                                    ])
                                    ->stacked()
                                    ->limit(6)
                                    ->limitedRemainingText(),

                                /*
                                |--------------------------------------------------------------------------
                                | Product Information
                                |--------------------------------------------------------------------------
                                */

                                Grid::make(2)
                                    ->schema([

                                        TextEntry::make('name')
                                            ->label('Product Name')
                                            ->weight('bold')
                                            ->size('lg')
                                            ->columnSpanFull(),

                                        TextEntry::make('sku')
                                            ->label('SKU'),

                                        TextEntry::make('price')
                                            ->label('Price')
                                            ->money('PHP')
                                            ->weight('bold'),

                                        TextEntry::make('stock')
                                            ->label('Stock')
                                            ->numeric(),

                                        TextEntry::make('status')
                                            ->label('Status')
                                            ->badge(),

                                        TextEntry::make('categories.name')
                                            ->label('Categories')
                                            ->badge()
                                            ->columnSpanFull(),

                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),

                /*
                |--------------------------------------------------------------------------
                | Description
                |--------------------------------------------------------------------------
                */

                Section::make('Description')
                    ->schema([
                        TextEntry::make('description')
                            ->hiddenLabel()
                            ->placeholder('No description provided.')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                /*
                |--------------------------------------------------------------------------
                | Product Settings
                |--------------------------------------------------------------------------
                */

                Section::make('Product Settings')
                    ->schema([
                        Grid::make(3)
                            ->schema([

                                IconEntry::make('is_featured')
                                    ->label('Featured')
                                    ->boolean(),

                                TextEntry::make('approved_at')
                                    ->label('Approved At')
                                    ->dateTime()
                                    ->placeholder('Not approved yet'),

                                TextEntry::make('approved_by')
                                    ->label('Approved By')
                                    ->placeholder('-'),

                            ]),
                    ])
                    ->columnSpanFull(),

                /*
                |--------------------------------------------------------------------------
                | Record Information
                |--------------------------------------------------------------------------
                */

                Section::make('Record Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([

                                TextEntry::make('created_at')
                                    ->label('Created')
                                    ->dateTime(),

                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime(),

                            ]),
                    ])
                    ->columnSpanFull(),

            ]);
    }
}
