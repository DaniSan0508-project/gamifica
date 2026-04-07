<?php

use App\Enums\UserRole;
use App\Livewire\Pages\Auth\Login;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;

uses(LazilyRefreshDatabase::class);

it('prevents user from querying another companys users', function () {
    $companyA = Company::factory()->create();
    $companyB = Company::factory()->create();

    $userA = User::factory()->create(['company_id' => $companyA->id]);
    $userB = User::factory()->create(['company_id' => $companyB->id]);

    $this->actingAs($userA);

    // User A should only see User A in a query, because of the global scope
    $users = User::all();
    
    expect($users)->toHaveCount(1)
        ->and($users->first()->id)->toBe($userA->id);
});

it('authenticates and redirects admin to admin dashboard', function () {
    $admin = User::factory()->create([
        'role' => UserRole::Admin->value,
    ]);

    Livewire::test(Login::class)
        ->set('form.email', $admin->email)
        ->set('form.password', 'password')
        ->call('save')
        ->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticatedAs($admin);
});

it('authenticates and redirects employee to player dashboard', function () {
    $employee = User::factory()->create([
        'role' => UserRole::Employee->value,
    ]);

    Livewire::test(Login::class)
        ->set('form.email', $employee->email)
        ->set('form.password', 'password')
        ->call('save')
        ->assertRedirect(route('player.dashboard'));

    $this->assertAuthenticatedAs($employee);
});

it('shows error on invalid credentials', function () {
    Livewire::test(Login::class)
        ->set('form.email', 'wrong@email.com')
        ->set('form.password', 'wrong')
        ->call('save')
        ->assertHasErrors(['form.email']);

    $this->assertGuest();
});
