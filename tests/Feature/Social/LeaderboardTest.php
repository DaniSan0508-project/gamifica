<?php

namespace Tests\Feature\Social;

use App\Models\Company;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;
use App\Livewire\Pages\Player\Dashboard;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->company = Company::factory()->create();
    $this->user = User::factory()->create([
        'company_id' => $this->company->id,
        'role' => UserRole::Employee->value,
        'name' => 'User Main',
        'points_balance' => 100,
    ]);
});

it('shows users from the same company in the leaderboard', function () {
    $userSameCompany = User::factory()->create([
        'company_id' => $this->company->id,
        'name' => 'User Same',
        'points_balance' => 200,
    ]);

    $otherCompany = Company::factory()->create();
    $userOtherCompany = User::factory()->create([
        'company_id' => $otherCompany->id,
        'name' => 'User Other',
        'points_balance' => 300,
    ]);

    $this->actingAs($this->user);

    Livewire::test(Dashboard::class)
        ->assertSee('User Main')
        ->assertSee('User Same')
        ->assertDontSee('User Other');
});

it('ranks users by points balance in the leaderboard', function () {
    User::factory()->create([
        'company_id' => $this->company->id,
        'name' => 'Second Place',
        'points_balance' => 150,
    ]);

    User::factory()->create([
        'company_id' => $this->company->id,
        'name' => 'First Place',
        'points_balance' => 500,
    ]);

    $this->actingAs($this->user);

    // Verify order in the leaderboard data
    Livewire::test(Dashboard::class)
        ->assertViewHas('leaderboard', function ($leaderboard) {
            return $leaderboard->first()->name === 'First Place' 
                && $leaderboard->get(1)->name === 'Second Place'
                && $leaderboard->get(2)->name === 'User Main';
        });
});
