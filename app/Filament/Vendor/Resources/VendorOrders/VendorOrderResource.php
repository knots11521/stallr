<?php

namespace App\Filament\Vendor\Resources\VendorOrders;

use App\Filament\Vendor\Resources\VendorOrders\Pages\ListVendorOrders;
use App\Filament\Vendor\Resources\VendorOrders\Pages\ViewVendorOrder;
use App\Filament\Vendor\Resources\VendorOrders\Schemas\VendorOrderInfolist;
use App\Filament\Vendor\Resources\VendorOrders\Tables\VendorOrdersTable;
use App\Models\VendorOrder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class VendorOrderResource extends Resource
{
    protected static ?string $model = VendorOrder::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'order_id';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VendorOrderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VendorOrdersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVendorOrders::route('/'),
            'view' => ViewVendorOrder::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $vendor = Auth::user()->vendor;

        if (! $vendor) {
            return parent::getEloquentQuery()->whereRaw('0 = 1');
        }

        return parent::getEloquentQuery()
            ->where('vendor_id', $vendor->id)
            ->with(['order', 'items']);
    }
}
