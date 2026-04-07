<?php

namespace Tests\Feature\Player;

use App\Models\Company;
use App\Models\Reward;
use App\Models\User;
use App\Enums\UserRole;
use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;
use App\Livewire\Pages\Player\Shop\Index as PlayerShop;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->company = Company::factory()->create();
    $this->user = User::factory()->create([
        'company_id' => $this->company->id,
        'role' => UserRole::Employee->value,
        'points_balance' => 500,
    ]);
});

it('creates an order and generates a voucher code when redeeming a reward', function () {
    $reward = Reward::factory()->create([
        'company_id' => $this->company->id,
        'cost' => 100,
        'stock_quantity' => 10,
    ]);

    $this->actingAs($this->user);

    Livewire::test(PlayerShop::class)
        ->call('redeem', $reward->id);

    $order = Order::where('user_id', $this->user->id)->first();
    
    expect($order)->not->toBeNull()
        ->and($order->points_cost)->toBe(100)
        ->and($order->status)->toBe(OrderStatus::Pending)
        ->and($order->voucher_code)->toStartWith('GAM-');
    
    expect($this->user->refresh()->points_balance)->toBe(400);
});

it('allows admin to mark an order as delivered', function () {
    $order = Order::factory()->create([
        'company_id' => $this->company->id,
        'status' => OrderStatus::Pending,
    ]);

    $admin = User::factory()->create([
        'company_id' => $this->company->id,
        'role' => UserRole::Admin->value,
    ]);

    $this->actingAs($admin);

    Livewire::test(\App\Livewire\Pages\Admin\Orders\Index::class)
        ->call('deliver', $order->id);

    expect($order->refresh()->status)->toBe(OrderStatus::Delivered)
        ->and($order->delivered_at)->not->toBeNull();
});
