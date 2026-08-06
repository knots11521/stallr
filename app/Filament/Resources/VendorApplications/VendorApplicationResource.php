<?php

namespace App\Filament\Resources\VendorApplications;

use App\Filament\Resources\VendorApplications\Pages\CreateVendorApplication;
use App\Filament\Resources\VendorApplications\Pages\EditVendorApplication;
use App\Filament\Resources\VendorApplications\Pages\ListVendorApplications;
use App\Filament\Resources\VendorApplications\Schemas\VendorApplicationForm;
use App\Filament\Resources\VendorApplications\Tables\VendorApplicationsTable;
use App\Models\VendorApplication;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;

class VendorApplicationResource extends Resource
{
    protected static ?string $model = VendorApplication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'store_name';

    public static function form(Schema $schema): Schema
    {
        return VendorApplicationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('user.name')
                    ->label('User'),

                TextColumn::make('store_name')
                    ->label('Business'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),

            ])
            ->actions([

                Action::make('approve')
                    ->label('Approve')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn($record) => $record->status === 'pending')
                    ->action(function ($record) {

                        $record->update([
                            'status' => 'approved',
                        ]);

                        if (!$record->user->hasRole('Vendor')) {
                            $record->user->assignRole('Vendor');
                        }

                        // Remove Customer role after becoming Vendor
                        if ($record->user->hasRole('Customer')) {
                            $record->user->removeRole('Customer');
                        }
                    }),


                Action::make('reject')
                    ->label('Reject')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn($record) => $record->status === 'pending')
                    ->action(function ($record) {

                        $record->update([
                            'status' => 'rejected',
                        ]);
                    }),


                Action::make('reopenApplication')
                    ->label('Reopen Application')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn($record) => in_array($record->status, [
                        'approved',
                        'rejected',
                    ]))
                    ->action(function ($record) {

                        // Send application back for review
                        $record->update([
                            'status' => 'pending',
                        ]);


                        // Remove Vendor role if previously approved
                        if ($record->user->hasRole('Vendor')) {
                            $record->user->removeRole('Vendor');
                        }


                        // Restore Customer role
                        if (!$record->user->hasRole('Customer')) {
                            $record->user->assignRole('Customer');
                        }
                    }),

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVendorApplications::route('/'),
            'create' => CreateVendorApplication::route('/create'),
            // 'edit' => EditVendorApplication::route('/{record}/edit'),
        ];
    }
}
