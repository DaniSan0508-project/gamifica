<?php

namespace App\Livewire\Pages\Auth;

use App\Livewire\Forms\LoginForm;
use App\Enums\UserRole;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class Login extends Component
{
    public LoginForm $form;

    public function save()
    {
        $this->form->authenticate();

        $role = auth()->user()->role;
        if ($role === UserRole::Admin) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('player.dashboard');
    }

    public function render()
    {
        return view('livewire.pages.auth.login')->title('Gamifica - Login');
    }
}
