<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\AdminStatsOverview;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'FortuneCompass 管理ダッシュボード';
    
    protected static ?string $navigationLabel = 'ダッシュボード';
    
    protected static ?string $navigationIcon = 'heroicon-o-home';
    
    protected static ?int $navigationSort = 1;
    
    public function getWidgets(): array
    {
        return [
            AdminStatsOverview::class,
        ];
    }
}
