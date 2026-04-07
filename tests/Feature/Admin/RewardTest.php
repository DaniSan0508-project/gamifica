<?php

namespace Tests\Feature\Admin;

use App\Models\Company;
use App\Models\Reward;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;
use App\Livewire\Pages\Admin\Rewards\Create as RewardCreate;
use App\Livewire\Pages\Admin\Rewards\Index as RewardIndex;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->company = Company::factory()->create();
    $this->admin = User::factory()->create([
        'company_id' => $this->company->id,
        'role' => UserRole::Admin->value,
    ]);
});

it('can list rewards for its own company', function () {
    Reward::factory()->create(['company_id' => $this->company->id, 'title' => 'Reward A']);
    
    $otherCompany = Company::factory()->create();
    Reward::factory()->create(['company_id' => $otherCompany->id, 'title' => 'Reward B']);

    $this->actingAs($this->admin);

    Livewire::test(RewardIndex::class)
        ->assertSee('Reward A')
        ->assertDontSee('Reward B');
});

it('can create a reward', function () {
    $this->actingAs($this->admin);

    Livewire::test(RewardCreate::class)
        ->set('form.title', 'New Prize')
        ->set('form.cost', 100)
        ->set('form.stock_quantity', 5)
        ->call('save')
        ->assertRedirect(route('admin.rewards.index'));

    $reward = Reward::where('title', 'New Prize')->first();
    expect($reward)->not->toBeNull()
        ->and($reward->company_id)->toBe($this->company->id)
        ->and($reward->cost)->toBe(100);
});
