<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required')]
    public string $password = '';

    #[Validate('boolean')]
    public bool $remember = false;

    public function authenticate(): void
    {
        $this->validate();

        if (! Auth::attempt($this->only(['email', 'password']), $this->remember)) {
            throw ValidationException::withMessages([
                'form.email' => trans('auth.failed'),
            ]);
        }

        session()->regenerate();
    }
}
