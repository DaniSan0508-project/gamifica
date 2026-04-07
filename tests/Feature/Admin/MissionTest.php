<?php

namespace Tests\Feature\Admin;

use App\Models\Company;
use App\Models\Mission;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;
use App\Livewire\Pages\Admin\Missions\Create as MissionCreate;
use App\Livewire\Pages\Admin\Missions\Index as MissionIndex;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->company = Company::factory()->create();
    $this->admin = User::factory()->create([
        'company_id' => $this->company->id,
        'role' => UserRole::Admin->value,
    ]);
});

it('can list missions for its own company', function () {
    Mission::factory()->create(['company_id' => $this->company->id, 'title' => 'Mission A']);
    
    $otherCompany = Company::factory()->create();
    Mission::factory()->create(['company_id' => $otherCompany->id, 'title' => 'Mission B']);

    $this->actingAs($this->admin);

    Livewire::test(MissionIndex::class)
        ->assertSee('Mission A')
        ->assertDontSee('Mission B');
});

it('can create a mission', function () {
    $this->actingAs($this->admin);

    Livewire::test(MissionCreate::class)
        ->set('form.title', 'New Mission')
        ->set('form.description', 'Description')
        ->set('form.points_reward', 50)
        ->call('save')
        ->assertRedirect(route('admin.missions.index'));

    $mission = Mission::where('title', 'New Mission')->first();
    expect($mission)->not->toBeNull()
        ->and($mission->company_id)->toBe($this->company->id)
        ->and($mission->points_reward)->toBe(50);
});

it('validates mission fields', function () {
    $this->actingAs($this->admin);

    Livewire::test(MissionCreate::class)
        ->set('form.title', '')
        ->set('form.points_reward', -10)
        ->call('save')
        ->assertHasErrors(['form.title', 'form.points_reward']);
});
