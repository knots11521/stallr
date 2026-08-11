<?php

namespace App\Filament\Admin\Resources\VendorApplications;

use App\Filament\Admin\Resources\VendorApplications\Pages\CreateVendorApplication;
use App\Filament\Admin\Resources\VendorApplications\Pages\ListVendorApplications;
use App\Filament\Admin\Resources\VendorApplications\Pages\ViewVendorApplication;
use App\Filament\Admin\Resources\VendorApplications\Schemas\VendorApplicationForm;
use App\Models\VendorApplication;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class VendorApplicationResource extends Resource
{
    protected static ?string $model = VendorApplication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'store_name';

    public static function form(Schema $schema): Schema
    {
        return VendorApplicationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('user.name')
                ->label('Applicant'),

            TextEntry::make('user.email')
                ->label('Email'),

            TextEntry::make('store_name')
                ->label('Business Name'),

            TextEntry::make('description')
                ->label('Description')
                ->columnSpanFull(),

            TextEntry::make('status')
                ->label('Status')
                ->badge()
                ->color(fn(string $state): string => match ($state) {
                    'pending' => 'warning',
                    'approved' => 'success',
                    'rejected' => 'danger',
                    default => 'gray',
                }),

            TextEntry::make('created_at')
                ->label('Applied At')
                ->dateTime(),

            TextEntry::make('updated_at')
                ->label('Last Updated')
                ->dateTime(),
        ]);
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
                ViewAction::make(),

                Action::make('approve')
                    ->label('Approve')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn($record) => $record->status === 'pending')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'approved',
                        ]);

                        $user = $record->user;

                        // Assign Vendor role.
                        if (!$user->hasRole('Vendor')) {
                            $user->assignRole('Vendor');
                        }

                        // Remove Customer role.
                        if ($user->hasRole('Customer')) {
                            $user->removeRole('Customer');
                        }

                        // Create Vendor profile.
                        if (!$user->vendor) {
                            $user->vendor()->create([
                                'store_name' => $record->store_name,
                                'slug' => Str::slug($record->store_name),
                                'description' => $record->description,
                                'is_verified' => true,
                            ]);
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
                        // Send application back for review.
                        $record->update([
                            'status' => 'pending',
                        ]);

                        $user = $record->user;

                        // Remove Vendor role if previously approved.
                        if ($user->hasRole('Vendor')) {
                            $user->removeRole('Vendor');
                        }

                        // Restore Customer role.
                        if (!$user->hasRole('Customer')) {
                            $user->assignRole('Customer');
                        }
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVendorApplications::route('/'),
            'create' => CreateVendorApplication::route('/create'),
            'view' => ViewVendorApplication::route('/{record}'),
        ];
    }
}
