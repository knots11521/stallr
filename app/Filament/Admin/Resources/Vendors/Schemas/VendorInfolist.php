<?php

namespace App\Filament\Admin\Resources\Vendors\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VendorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Store Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('store_name')
                                    ->label('Store Name')
                                    ->weight('bold'),

                                TextEntry::make('slug')
                                    ->label('Slug'),

                                TextEntry::make('user.name')
                                    ->label('Owner'),

                                TextEntry::make('user.email')
                                    ->label('Email'),

                                TextEntry::make('phone')
                                    ->label('Phone')
                                    ->placeholder('-'),

                                TextEntry::make('address')
                                    ->label('Address')
                                    ->placeholder('-'),

                                TextEntry::make('description')
                                    ->label('Description')
                                    ->placeholder('-')
                                    ->columnSpanFull(),
                            ]),
                    ]),

                Section::make('Status')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                IconEntry::make('is_verified')
                                    ->label('Verified')
                                    ->boolean(),

                                IconEntry::make('is_active')
                                    ->label('Active')
                                    ->boolean(),

                                TextEntry::make('created_at')
                                    ->label('Created')
                                    ->dateTime('M d, Y h:i A'),
                            ]),
                    ]),
            ]);
    }
}
