<?php

namespace App\Filament\Vendor\Resources\VendorProducts;

use App\Filament\Vendor\Resources\VendorProducts\Pages\CreateVendorProduct;
use App\Filament\Vendor\Resources\VendorProducts\Pages\EditVendorProduct;
use App\Filament\Vendor\Resources\VendorProducts\Pages\ListVendorProducts;
use App\Filament\Vendor\Resources\VendorProducts\Pages\ViewVendorProduct;
use App\Filament\Vendor\Resources\VendorProducts\Schemas\VendorProductForm;
use App\Filament\Vendor\Resources\VendorProducts\Schemas\VendorProductInfolist;
use App\Filament\Vendor\Resources\VendorProducts\Tables\VendorProductsTable;

use App\Models\Product;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;

class VendorProductResource extends Resource
{
    protected static ?string $model = Product::class;


    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;


    protected static ?string $recordTitleAttribute = 'name';


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('sku')
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('price')
                    ->numeric()
                    ->required(),

                TextInput::make('stock')
                    ->numeric()
                    ->required(),

                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),

                Select::make('categories')
                    ->relationship(
                        name: 'categories',
                        titleAttribute: 'name'
                    )
                    ->multiple()
                    ->preload()
                    ->required(),

                FileUpload::make('images')
                    ->label('Product Images')
                    ->multiple()
                    ->image()
                    ->disk('public')
                    ->directory('products')
                    ->visibility('public')
                    ->reorderable()
                    ->deletable()
                    ->dehydrated(true),


            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VendorProductInfolist::configure($schema);
    }


    public static function table(Table $table): Table
    {
        return VendorProductsTable::configure($table);
    }


    public static function getRelations(): array
    {
        return [];
    }


    public static function getPages(): array
    {
        return [
            'index' => ListVendorProducts::route('/'),
            'create' => CreateVendorProduct::route('/create'),
            'view' => ViewVendorProduct::route('/{record}'),
            'edit' => EditVendorProduct::route('/{record}/edit'),
        ];
    }


    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where(
                'vendor_id',
                Auth::user()->vendor->id
            );
    }
}
