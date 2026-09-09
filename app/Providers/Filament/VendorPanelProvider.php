<?php

namespace App\Providers\Filament;

use App\Filament\Vendor\Widgets\VendorSalesChart;
use App\Filament\Vendor\Widgets\VendorStats;
use App\Filament\Vendor\Widgets\VendorTopProductsChart;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class VendorPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('vendor')
            ->path('vendor')
            ->topbar(false)

            /*
            |--------------------------------------------------------------------------
            | Sidebar
            |--------------------------------------------------------------------------
            */

            ->sidebarCollapsibleOnDesktop()

            /*
            |--------------------------------------------------------------------------
            | Colors & Theme
            |--------------------------------------------------------------------------
            */

            ->colors([
                'primary' => Color::Amber,
            ])
            ->viteTheme('resources/css/filament/vendor/theme.css')

            /*
            |--------------------------------------------------------------------------
            | Back to Store
            |--------------------------------------------------------------------------
            |
            | Placed at the bottom of the sidebar.
            |
            */

            ->navigationItems([
                NavigationItem::make('Back to Store')
                    ->url(fn () => route('dashboard'))
                    ->icon('heroicon-o-arrow-left')
                    ->sort(999),
            ])

            /*
            |--------------------------------------------------------------------------
            | Resources
            |--------------------------------------------------------------------------
            */

            ->discoverResources(
                in: app_path('Filament/Vendor/Resources'),
                for: 'App\\Filament\\Vendor\\Resources',
            )

            /*
            |--------------------------------------------------------------------------
            | Pages
            |--------------------------------------------------------------------------
            */

            ->discoverPages(
                in: app_path('Filament/Vendor/Pages'),
                for: 'App\\Filament\\Vendor\\Pages',
            )

            ->pages([
                Dashboard::class,
            ])

            /*
            |--------------------------------------------------------------------------
            | Widgets
            |--------------------------------------------------------------------------
            */

            ->discoverWidgets(
                in: app_path('Filament/Vendor/Widgets'),
                for: 'App\\Filament\\Vendor\\Widgets',
            )

            ->widgets([
                VendorStats::class,
                VendorSalesChart::class,
                VendorTopProductsChart::class,
            ])

            /*
            |--------------------------------------------------------------------------
            | Middleware
            |--------------------------------------------------------------------------
            */

            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])

            /*
            |--------------------------------------------------------------------------
            | Authentication
            |--------------------------------------------------------------------------
            */

            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
