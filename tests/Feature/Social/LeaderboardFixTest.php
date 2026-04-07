<?php

namespace Tests\Feature\Social;

use App\Models\Company;
use App\Models\User;
use App\Enums\UserRole;
use App\Models\Reward;
use App\Services\PointService;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;
use App\Livewire\Pages\Player\Dashboard;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->company = Company::factory()->create();
    $this->user = User::factory()->create([
        'company_id' => $this->company->id,
        'role' => UserRole::Employee->value,
        'name' => 'John Player',
        'points_balance' => 500,
    ]);
});

it('clears leaderboard cache automatically when points are updated via PointService', function () {
    $cacheKey = 'leaderboard_' . $this->company->id;

    // 1. Initial leaderboard state (cached)
    $this->actingAs($this->user);
    Livewire::test(Dashboard::class);
    
    expect(Cache::has($cacheKey))->toBeTrue();

    // 2. Update points (Redeem reward)
    $reward = Reward::factory()->create(['company_id' => $this->company->id, 'cost' => 100]);
    app(PointService::class)->redeemReward($this->user, $reward);

    // 3. Cache should be cleared by UserObserver
    expect(Cache::has($cacheKey))->toBeFalse();
});

it('excludes admins from the leaderboard ranking', function () {
    $admin = User::factory()->create([
        'company_id' => $this->company->id,
        'role' => UserRole::Admin->value,
        'name' => 'The Boss',
        'points_balance' => 9999,
    ]);

    $this->actingAs($this->user);

    Livewire::test(Dashboard::class)
        ->assertSee('John Player')
        ->assertDontSee('The Boss');
});

it('maintains correct order after multiple point changes', function () {
    $otherUser = User::factory()->create([
        'company_id' => $this->company->id,
        'name' => 'Other Player',
        'points_balance' => 100,
    ]);

    $this->actingAs($this->user);

    // Initial check
    Livewire::test(Dashboard::class)
        ->assertViewHas('leaderboard', function ($leaderboard) {
            return $leaderboard->first()->name === 'John Player';
        });

    // Award points to other user to overtake John
    app(PointService::class)->awardPoints($otherUser, 1000, 'Super Performance');

    // Check again - John player should be second now
    Livewire::test(Dashboard::class)
        ->assertViewHas('leaderboard', function ($leaderboard) {
            return $leaderboard->first()->name === 'Other Player'
                && $leaderboard->get(1)->name === 'John Player';
        });
});
