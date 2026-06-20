<?php

namespace App\Providers\Filament;

use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\HtmlString;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('HSE Reporting')
            ->brandLogo(fn () => view('components.custom-brand-logo'))
    
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                \App\Filament\Widgets\WelcomeWidget::class,
                \App\Filament\Widgets\IncidentStatsWidget::class,
                \App\Filament\Widgets\IncidentChartWidget::class,
            ])
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
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
             ->renderHook(
                PanelsRenderHook::SIDEBAR_NAV_END,
                fn (): string => Blade::render('@include(\'components.sidebar-user-card\')'),
            )
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => new HtmlString('
                    <style>
                        .fi-user-menu {
                            display: none !important;
                        }
                    </style>
                '),
            )
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => new HtmlString('
                    <style>
                        .fi-user-menu {
                            display: none !important;
                        }

                        .fi-simple-layout {
                            position: relative;
                            background-color: #0a0a0c;
                            background-image:
                                radial-gradient(circle at 15% 15%, rgba(245, 158, 11, 0.07), transparent 45%),
                                radial-gradient(circle at 85% 85%, rgba(245, 158, 11, 0.05), transparent 45%);
                            overflow: hidden;
                        }

                        .fi-simple-layout::before {
                            content: "";
                            position: fixed;
                            inset: 0;
                            background-image: repeating-linear-gradient(135deg, rgba(245,158,11,0.025) 0 40px, transparent 40px 80px);
                            pointer-events: none;
                            z-index: 0;
                        }

                        /* Garis hazard tipis cuma di tepi atas, sebagai aksen, bukan full background */
                        .fi-simple-layout::after {
                            content: "";
                            position: fixed;
                            top: 0; left: 0; right: 0;
                            height: 4px;
                            background-image: repeating-linear-gradient(135deg, #f59e0b 0 12px, #18181b 12px 24px);
                            z-index: 50;
                        }

                        /* Card login dikasih elevasi biar gak nyatu sama background */
                        .fi-simple-layout .fi-simple-main {
                            position: relative;
                            z-index: 1;
                            background-color: rgba(17, 17, 20, 0.92) !important;
                            backdrop-filter: blur(8px);
                            box-shadow: 0 20px 50px -10px rgba(0, 0, 0, 0.6);
                        }
                    </style>
                '),
            );
    }
}