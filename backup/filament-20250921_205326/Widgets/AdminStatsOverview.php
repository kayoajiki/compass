<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;

class AdminStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('総商品数', Product::count())
                ->description('登録されている商品数')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('success'),
            Stat::make('アクティブ商品', Product::where('is_active', true)->count())
                ->description('販売中の商品数')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('info'),
            Stat::make('総ユーザー数', User::count())
                ->description('登録済みユーザー数')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),
            Stat::make('総注文数', Order::count())
                ->description('これまでの注文数')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('primary'),
        ];
    }
}
