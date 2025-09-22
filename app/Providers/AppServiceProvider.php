<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ProfileObserverを登録
        \App\Models\Profile::observe(\App\Observers\ProfileObserver::class);
        
        // Filamentパネルはbootstrap/providers.phpで登録
    }
}
