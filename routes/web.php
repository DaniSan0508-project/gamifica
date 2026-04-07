<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\Auth\Login;
use App\Livewire\Pages\Admin\Dashboard as AdminDashboard;
use App\Livewire\Pages\Player\Dashboard as PlayerDashboard;

use App\Livewire\Pages\Admin\Missions\Index as MissionIndex;
use App\Livewire\Pages\Admin\Missions\Create as MissionCreate;
use App\Livewire\Pages\Admin\Missions\Edit as MissionEdit;
use App\Livewire\Pages\Admin\Rewards\Index as RewardIndex;
use App\Livewire\Pages\Admin\Rewards\Create as RewardCreate;
use App\Livewire\Pages\Admin\Rewards\Edit as RewardEdit;
use App\Livewire\Pages\Admin\Orders\Index as AdminOrderIndex;
use App\Livewire\Pages\Admin\Feedbacks\Index as AdminFeedbackIndex;

use App\Livewire\Pages\Player\Shop\Index as PlayerShopIndex;
use App\Livewire\Pages\Player\Orders\Index as PlayerOrderIndex;
use App\Livewire\Pages\Player\Feedbacks\Index as PlayerFeedbackIndex;
use App\Livewire\Pages\Common\SendFeedback;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === \App\Enums\UserRole::Admin 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('player.dashboard');
    }
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', function () {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    })->name('logout');

    Route::get('/player', PlayerDashboard::class)->name('player.dashboard');
    Route::get('/player/shop', PlayerShopIndex::class)->name('player.shop.index');
    Route::get('/player/orders', PlayerOrderIndex::class)->name('player.orders.index');
    Route::get('/player/feedbacks', PlayerFeedbackIndex::class)->name('player.feedbacks.index');
    Route::get('/feedbacks/send', SendFeedback::class)->name('feedbacks.send');

    Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
        Route::get('/admin', AdminDashboard::class)->name('admin.dashboard');
        
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/missions', MissionIndex::class)->name('missions.index');
            Route::get('/missions/create', MissionCreate::class)->name('missions.create');
            Route::get('/missions/{mission}/edit', MissionEdit::class)->name('missions.edit');

            Route::get('/rewards', RewardIndex::class)->name('rewards.index');
            Route::get('/rewards/create', RewardCreate::class)->name('rewards.create');
            Route::get('/rewards/{reward}/edit', RewardEdit::class)->name('rewards.edit');

            Route::get('/orders', AdminOrderIndex::class)->name('orders.index');
            Route::get('/feedbacks', AdminFeedbackIndex::class)->name('feedbacks.index');
        });
    });
});
