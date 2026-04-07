<?php

namespace Tests\Feature\Player;

use App\Models\Company;
use App\Models\Reward;
use App\Models\User;
use App\Enums\UserRole;
use App\Enums\TransactionType;
use App\Models\PointTransaction;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;
use App\Livewire\Pages\Player\Shop\Index as PlayerShop;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->company = Company::factory()->create();
    $this->user = User::factory()->create([
        'company_id' => $this->company->id,
        'role' => UserRole::Employee->value,
        'points_balance' => 200,
    ]);
});

it('can redeem a reward and deduct points', function () {
    $reward = Reward::factory()->create([
        'company_id' => $this->company->id,
        'cost' => 150,
        'stock_quantity' => 10,
    ]);

    $this->actingAs($this->user);

    Livewire::test(PlayerShop::class)
        ->call('redeem', $reward->id)
        ->assertHasNoErrors();

    $this->user->refresh();
    expect($this->user->points_balance)->toBe(50);

    $reward->refresh();
    expect($reward->stock_quantity)->toBe(9);

    $transaction = PointTransaction::where('user_id', $this->user->id)->first();
    expect($transaction)->not->toBeNull()
        ->and($transaction->amount)->toBe(-150)
        ->and($transaction->type)->toBe(TransactionType::RewardRedeem);
});

it('cannot redeem reward if balance is insufficient', function () {
    $reward = Reward::factory()->create([
        'company_id' => $this->company->id,
        'cost' => 500,
        'stock_quantity' => 10,
    ]);

    $this->actingAs($this->user);

    Livewire::test(PlayerShop::class)
        ->call('redeem', $reward->id)
        ->assertHasNoErrors()
        ->assertSee('Saldo insuficiente');

    $this->user->refresh();
    expect($this->user->points_balance)->toBe(200);
});
