<?php

namespace Tests\Feature\Common;

use App\Enums\UserRole;
use App\Livewire\Pages\Common\Profile;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->company = Company::factory()->create();
    $this->user = User::factory()->create([
        'company_id' => $this->company->id,
        'role' => UserRole::Employee->value,
        'name' => 'Original Name',
        'email' => 'original@example.com',
    ]);
});

it('can update profile information', function () {
    $this->actingAs($this->user);

    Livewire::test(Profile::class)
        ->set('form.name', 'Updated Name')
        ->set('form.email', 'updated@example.com')
        ->call('save')
        ->assertHasNoErrors();

    $this->user->refresh();
    expect($this->user->name)->toBe('Updated Name')
        ->and($this->user->email)->toBe('updated@example.com');
});

it('can upload an avatar', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('avatar.jpg');

    $this->actingAs($this->user);

    Livewire::test(Profile::class)
        ->set('form.avatar', $file)
        ->call('save')
        ->assertHasNoErrors();

    $this->user->refresh();
    expect($this->user->avatar_path)->not->toBeNull();

    Storage::disk('public')->assertExists($this->user->avatar_path);
});

it('prevents using an email that belongs to someone else in the same company', function () {
    User::factory()->create([
        'company_id' => $this->company->id,
        'email' => 'taken@example.com',
    ]);

    $this->actingAs($this->user);

    Livewire::test(Profile::class)
        ->set('form.email', 'taken@example.com')
        ->call('save')
        ->assertHasErrors(['form.email']);
});
