<?php

namespace Tests\Feature\Player;

use App\Models\Company;
use App\Models\Mission;
use App\Models\User;
use App\Enums\UserRole;
use App\Enums\TransactionType;
use App\Models\PointTransaction;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;
use App\Livewire\Pages\Player\Dashboard;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->company = Company::factory()->create();
    $this->user = User::factory()->create([
        'company_id' => $this->company->id,
        'role' => UserRole::Employee->value,
        'points_balance' => 0,
    ]);
});

it('can complete a mission and receive points', function () {
    $mission = Mission::factory()->create([
        'company_id' => $this->company->id,
        'points_reward' => 100,
        'is_active' => true,
    ]);

    $this->actingAs($this->user);

    Livewire::test(Dashboard::class)
        ->call('completeMission', $mission->id)
        ->assertHasNoErrors();

    $this->user->refresh();
    expect($this->user->points_balance)->toBe(100);

    $transaction = PointTransaction::where('user_id', $this->user->id)->first();
    expect($transaction)->not->toBeNull()
        ->and($transaction->amount)->toBe(100)
        ->and($transaction->type)->toBe(TransactionType::MissionComplete);
});
