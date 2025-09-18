<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    
    // プロフィール設定
    Route::get('profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    
    // 有料機能（サブスクリプション必要）
    Route::middleware(['subscription'])->group(function () {
        Route::get('premium/calendar', function () {
            return view('premium.calendar');
        })->name('premium.calendar');
        
        Route::get('premium/compatibility', function () {
            return view('premium.compatibility');
        })->name('premium.compatibility');
    });
});

// Google認証
Route::get('auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// 価格ページ
Route::get('pricing', [App\Http\Controllers\PricingController::class, 'index'])->name('pricing');

require __DIR__.'/auth.php';
