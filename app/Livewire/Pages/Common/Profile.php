<?php

namespace App\Livewire\Pages\Common;

use App\Livewire\Forms\ProfileForm;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class Profile extends Component
{
    use WithFileUploads;

    public ProfileForm $form;

    public function mount(): void
    {
        $this->form->setUser(auth()->user());
    }

    public function save(): void
    {
        $this->form->save();

        session()->flash('message', 'Perfil atualizado com sucesso! ✨');

        // Refresh user data globally to show the new avatar immediately
        $this->form->setUser(auth()->user()->fresh());
    }

    public function render()
    {
        return view('livewire.pages.common.profile')->title('Meu Perfil');
    }
}
