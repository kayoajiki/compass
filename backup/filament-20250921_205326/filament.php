<?php

return [
    'default_filesystem_disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),
    'default_avatar_provider' => \Filament\AvatarProviders\UiAvatarsProvider::class,
    'default_theme_mode' => \Filament\Support\Facades\FilamentView::class,
    'dark_mode' => true,
    'database_notifications' => [
        'enabled' => false,
        'polling_interval' => '30s',
    ],
    'user_menu' => [
        'avatar' => true,
        'logout' => [
            'label' => 'ログアウト',
        ],
        'profile' => [
            'label' => 'プロフィール',
        ],
    ],
    'global_search' => [
        'enabled' => true,
    ],
    'breadcrumbs' => [
        'enabled' => true,
    ],
    'max_content_width' => null,
    'notifications' => [
        'database' => [
            'enabled' => false,
        ],
    ],
    'panels' => [
        'admin' => [
            'id' => 'admin',
            'path' => '/admin',
            'auth_guard' => 'web',
            'login' => \Filament\Pages\Auth\Login::class,
            'pages' => [
                \Filament\Pages\Dashboard::class,
            ],
            'resources' => [
                // Resources will be added here
            ],
            'middleware' => [
                'web',
                'auth',
            ],
            'brand_name' => 'FortuneCompass 管理',
            'navigation_items' => [
                [
                    'label' => 'ダッシュボード',
                    'icon' => 'heroicon-o-home',
                    'url' => '/admin',
                ],
            ],
        ],
    ],
];