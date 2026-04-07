<?php

namespace Tests\Feature\Social;

use App\Models\Company;
use App\Models\Feedback;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;
use App\Livewire\Pages\Common\SendFeedback;
use App\Livewire\Pages\Player\Feedbacks\Index as PlayerFeedbacks;
use App\Livewire\Pages\Admin\Feedbacks\Index as AdminFeedbacks;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->company = Company::factory()->create();
    $this->user = User::factory()->create([
        'company_id' => $this->company->id,
        'role' => UserRole::Employee->value,
        'name' => 'John Employee',
    ]);
    $this->admin = User::factory()->create([
        'company_id' => $this->company->id,
        'role' => UserRole::Admin->value,
        'name' => 'Jane Admin',
    ]);
});

it('allows an employee to send feedback to a colleague', function () {
    $colleague = User::factory()->create(['company_id' => $this->company->id, 'name' => 'Bob Colleague']);

    $this->actingAs($this->user);

    Livewire::test(SendFeedback::class)
        ->set('receiver_id', $colleague->id)
        ->set('message', 'Great job on the project!')
        ->call('save')
        ->assertRedirect(route('player.feedbacks.index'));

    $feedback = Feedback::where('sender_id', $this->user->id)->first();
    expect($feedback)->not->toBeNull()
        ->and($feedback->receiver_id)->toBe($colleague->id)
        ->and($feedback->message)->toBe('Great job on the project!');
});

it('allows an employee to see only their own received feedbacks', function () {
    $colleague = User::factory()->create(['company_id' => $this->company->id]);
    
    // Feedback for John
    Feedback::create([
        'company_id' => $this->company->id,
        'sender_id' => $colleague->id,
        'receiver_id' => $this->user->id,
        'message' => 'Feedback for John',
    ]);

    // Feedback for Someone Else
    $someoneElse = User::factory()->create(['company_id' => $this->company->id]);
    Feedback::create([
        'company_id' => $this->company->id,
        'sender_id' => $colleague->id,
        'receiver_id' => $someoneElse->id,
        'message' => 'Feedback for Someone Else',
    ]);

    $this->actingAs($this->user);

    Livewire::test(PlayerFeedbacks::class)
        ->assertSee('Feedback for John')
        ->assertDontSee('Feedback for Someone Else');
});

it('allows an admin to see all feedbacks in the company', function () {
    $user1 = User::factory()->create(['company_id' => $this->company->id, 'name' => 'User One']);
    $user2 = User::factory()->create(['company_id' => $this->company->id, 'name' => 'User Two']);

    Feedback::create([
        'company_id' => $this->company->id,
        'sender_id' => $user1->id,
        'receiver_id' => $user2->id,
        'message' => 'Kudos from One to Two',
    ]);

    $this->actingAs($this->admin);

    Livewire::test(AdminFeedbacks::class)
        ->assertSee('Kudos from One to Two');
});

it('allows admin to award bonus points via feedback', function () {
    $colleague = User::factory()->create([
        'company_id' => $this->company->id, 
        'points_balance' => 0
    ]);

    $this->actingAs($this->admin);

    Livewire::test(SendFeedback::class)
        ->set('receiver_id', $colleague->id)
        ->set('message', 'Excellent leadership!')
        ->set('points_bonus', 100)
        ->call('save');

    expect($colleague->refresh()->points_balance)->toBe(100);
});
