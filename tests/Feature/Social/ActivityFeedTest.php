<?php

namespace Tests\Feature\Social;

use App\Models\Company;
use App\Models\Mission;
use App\Models\User;
use App\Enums\UserRole;
use App\Models\ActivityLog;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;
use App\Livewire\Pages\Player\Dashboard;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->company = Company::factory()->create();
    $this->user = User::factory()->create([
        'company_id' => $this->company->id,
        'role' => UserRole::Employee->value,
    ]);
});

it('creates an activity log when a mission is completed', function () {
    $mission = Mission::factory()->create([
        'company_id' => $this->company->id,
        'title' => 'Social Mission',
        'is_active' => true,
    ]);

    $this->actingAs($this->user);

    Livewire::test(Dashboard::class)
        ->call('completeMission', $mission->id);

    $log = ActivityLog::where('user_id', $this->user->id)->first();
    expect($log)->not->toBeNull()
        ->and($log->message)->toContain('Social Mission');
});

it('only shows activity logs from the same company', function () {
    ActivityLog::create([
        'company_id' => $this->company->id,
        'user_id' => $this->user->id,
        'message' => 'Log Company A',
    ]);

    $otherCompany = Company::factory()->create();
    $otherUser = User::factory()->create(['company_id' => $otherCompany->id]);
    ActivityLog::create([
        'company_id' => $otherCompany->id,
        'user_id' => $otherUser->id,
        'message' => 'Log Company B',
    ]);

    $this->actingAs($this->user);

    Livewire::test(Dashboard::class)
        ->assertSee('Log Company A')
        ->assertDontSee('Log Company B');
});
