<?php

namespace App\Filament\Admin\Resources\Products;

use App\Filament\Admin\Resources\Products\Pages\ListProducts;
use App\Filament\Admin\Resources\Products\Pages\ViewProduct;
use App\Filament\Admin\Resources\Products\Schemas\ProductInfolist;
use App\Models\Product;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    /*
    |--------------------------------------------------------------------------
    | Infolist
    |--------------------------------------------------------------------------
    */

    public static function infolist(Schema $schema): Schema
    {
        return ProductInfolist::configure($schema);
    }

    /*
    |--------------------------------------------------------------------------
    | Table
    |--------------------------------------------------------------------------
    */

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('vendor.store_name')
                    ->label('Vendor'),

                TextColumn::make('price')
                    ->money('PHP'),

                TextColumn::make('stock'),

                TextColumn::make('status')
                    ->badge(),
            ])

            ->actions([
                Action::make('approve')
                    ->label('Approve')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'approved',
                            'approved_at' => now(),
                            'approved_by' => Auth::id(),
                        ]);
                    }),

                Action::make('reject')
                    ->label('Reject')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'rejected',
                        ]);
                    }),
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public static function getRelations(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    | Pages
    |--------------------------------------------------------------------------
    */

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
            'view' => ViewProduct::route('/{record}'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Query
    |--------------------------------------------------------------------------
    */

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = Auth::user();

        if (!$user) {
            return $query;
        }

        if ($user->hasRole('Vendor')) {
            return $query->where(
                'vendor_id',
                $user->vendor?->id
            );
        }

        return $query;
    }
}
