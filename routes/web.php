<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Http\Controllers\Web\ReadingController;
use App\Http\Controllers\Web\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'profile.completed'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    
    // Logout route
    Route::post('logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
    
    // 個別鑑定
    Route::get('/reading-shop', [ReadingController::class, 'index'])->name('reading-shop');
    Route::post('/reading/checkout', [ReadingController::class, 'checkout'])->name('reading.checkout');
    Route::get('/reading/thanks', [ReadingController::class, 'thanks'])->name('reading.thanks');
    Route::get('/reading/canceled', [ReadingController::class, 'canceled'])->name('reading.canceled');

    // 物販
    Route::get('/shop', [ShopController::class, 'index'])->name('shop');
    Route::post('/shop/checkout', [ShopController::class, 'checkout'])->name('shop.checkout');
    Route::get('/shop/thanks', [ShopController::class, 'thanks'])->name('shop.thanks');
    Route::get('/shop/canceled', [ShopController::class, 'canceled'])->name('shop.canceled');
    
    // プロフィール設定
    Route::get('profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    
    // カレンダー機能
    Route::get('calendar', \App\Livewire\Astrology\Calendar\MonthlyIndex::class)->name('calendar');
    
    Route::get('calendar/chart', function () {
        return view('calendar.chart');
    })->name('calendar.chart');
    
    Route::middleware(['subscription'])->group(function () {
        Route::get('calendar/reading', function () {
            return view('calendar.reading');
        })->name('calendar.reading');
    });
    
    // 相性占い機能（Chart: 無料、Reading: 有料）
    Route::get('compatibility/chart', function () {
        return view('compatibility.chart');
    })->name('compatibility.chart');
    
    Route::middleware(['subscription'])->group(function () {
        Route::get('compatibility/reading', function () {
            return view('compatibility.reading');
        })->name('compatibility.reading');
    });

    // 占術ページ（Chart: 無料、Reading: 有料）
    Route::get('four-pillars/chart', \App\Livewire\Astrology\FourPillars\Chart::class)->name('four-pillars.chart');
    Route::get('ziwei/chart', \App\Livewire\Astrology\ZiWei\Chart::class)->name('ziwei.chart');
    Route::get('western/chart', \App\Livewire\Astrology\Western\Chart::class)->name('western.chart');
    Route::get('numerology/chart', \App\Livewire\Astrology\Numerology\Chart::class)->name('numerology.chart');
    
    Route::middleware(['subscription'])->group(function () {
        Route::get('four-pillars/reading', \App\Livewire\Astrology\FourPillars\Reading::class)->name('four-pillars.reading');
        Route::get('ziwei/reading', \App\Livewire\Astrology\ZiWei\Reading::class)->name('ziwei.reading');
        Route::get('western/reading', \App\Livewire\Astrology\Western\Reading::class)->name('western.reading');
        Route::get('numerology/reading', \App\Livewire\Astrology\Numerology\Reading::class)->name('numerology.reading');
    });
});

// Google認証
Route::get('auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// サブスクリプション関連
Route::get('pricing', [App\Http\Controllers\Web\SubscriptionController::class, 'plans'])->name('pricing');

Route::middleware(['auth'])->group(function () {
    // サブスクリプション管理
    Route::post('subscription/checkout', [App\Http\Controllers\Web\SubscriptionController::class, 'checkout'])->name('subscription.checkout');
    Route::post('subscription/cancel', [App\Http\Controllers\Web\SubscriptionController::class, 'cancel'])->name('subscription.cancel');
    Route::post('subscription/resume', [App\Http\Controllers\Web\SubscriptionController::class, 'resume'])->name('subscription.resume');
    Route::get('subscription/portal', [App\Http\Controllers\Web\SubscriptionController::class, 'portal'])->name('subscription.portal');
    Route::get('subscription/status', [App\Http\Controllers\Web\SubscriptionController::class, 'status'])->name('subscription.status');
});

// Stripe Webhook
Route::post('stripe/webhook', [App\Http\Controllers\Web\StripeWebhookController::class, 'handle'])->name('cashier.webhook');

// Admin Panel Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');
    
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
        
        // 商品管理
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class)->names([
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'show' => 'admin.products.show',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy',
        ]);
        
        // ユーザー管理
        Route::resource('users', App\Http\Controllers\Admin\UserController::class)->names([
            'index' => 'admin.users.index',
            'show' => 'admin.users.show',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]);
        
        // 注文管理
        Route::resource('orders', App\Http\Controllers\Admin\OrderController::class)->names([
            'index' => 'admin.orders.index',
            'show' => 'admin.orders.show',
            'edit' => 'admin.orders.edit',
            'update' => 'admin.orders.update',
            'destroy' => 'admin.orders.destroy',
        ]);
        Route::put('orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('admin.orders.update-status');
        
        // 統計ダッシュボード
        Route::get('stats', [App\Http\Controllers\Admin\StatsController::class, 'index'])->name('admin.stats.index');
        Route::get('stats/chart-data', [App\Http\Controllers\Admin\StatsController::class, 'getChartData'])->name('admin.stats.chart-data');
    });
});


require __DIR__.'/auth.php';
