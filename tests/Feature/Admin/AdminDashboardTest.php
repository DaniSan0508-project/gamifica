<?php

namespace Tests\Feature\Admin;

use App\Models\Company;
use App\Models\Order;
use App\Models\PointTransaction;
use App\Models\User;
use App\Enums\UserRole;
use App\Enums\TransactionType;
use App\Enums\OrderStatus;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;
use App\Livewire\Pages\Admin\Dashboard;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->company = Company::factory()->create();
    $this->admin = User::factory()->create([
        'company_id' => $this->company->id,
        'role' => UserRole::Admin->value,
    ]);
});

it('calculates the correct metrics for the admin dashboard', function () {
    // 1. Create some data for the current company
    User::factory(3)->create(['company_id' => $this->company->id]); // Total 4 with admin
    
    PointTransaction::create([
        'company_id' => $this->company->id,
        'user_id' => $this->admin->id,
        'amount' => 500,
        'type' => TransactionType::MissionComplete,
        'description' => 'Test Award',
    ]);

    PointTransaction::create([
        'company_id' => $this->company->id,
        'user_id' => $this->admin->id,
        'amount' => -200,
        'type' => TransactionType::RewardRedeem,
        'description' => 'Test Redeem',
    ]);

    Order::factory()->create([
        'company_id' => $this->company->id,
        'status' => OrderStatus::Pending,
    ]);

    // 2. Create data for another company (should be isolated)
    $otherCompany = Company::factory()->create();
    User::factory(10)->create(['company_id' => $otherCompany->id]);
    
    PointTransaction::create([
        'company_id' => $otherCompany->id,
        'user_id' => User::firstWhere('company_id', $otherCompany->id)->id,
        'amount' => 1000,
        'type' => TransactionType::MissionComplete,
        'description' => 'Other Award',
    ]);

    $this->actingAs($this->admin);

    Livewire::test(Dashboard::class)
        ->assertViewHas('totalUsers', 4)
        ->assertViewHas('totalPointsAwarded', 500)
        ->assertViewHas('totalPointsRedeemed', 200)
        ->assertViewHas('pendingOrders', 1);
});
