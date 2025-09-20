<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use App\Http\Middleware\EnsureAdminAccess;

class AdminPanelProvider extends PanelProvider
{
    public static function make(): Panel
    {
        return Panel::make()
            ->id('admin')
            ->path('/admin')
            ->colors([
                'primary' => '#8F78B4',
                'secondary' => '#E7D7C9',
            ])
            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\\Filament\\Resources',
            )
            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\\Filament\\Pages',
            )
            ->login()
            ->brandName('FortuneCompass 管理')
            ->favicon(asset('favicon.ico'))
            ->navigationGroups([
                '商品管理',
                '注文管理',
                'ユーザー管理',
                'システム設定',
            ])
            ->topNavigation(false)
            ->sidebarCollapsibleOnDesktop()
            ->darkMode(false)
            ->authMiddleware([
                EnsureAdminAccess::class,
            ]);
    }

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('/admin')
            ->colors([
                'primary' => '#8F78B4',
                'secondary' => '#E7D7C9',
            ])
            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\\Filament\\Resources',
            )
            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\\Filament\\Pages',
            )
            ->login()
            ->brandName('FortuneCompass 管理')
            ->favicon(asset('favicon.ico'))
            ->navigationGroups([
                '商品管理',
                '注文管理',
                'ユーザー管理',
                'システム設定',
            ])
            ->topNavigation(false)
            ->sidebarCollapsibleOnDesktop()
            ->darkMode(false)
            ->authMiddleware([
                EnsureAdminAccess::class,
            ]);
    }
}
