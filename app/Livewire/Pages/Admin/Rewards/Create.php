<?php

namespace App\Livewire\Pages\Admin\Rewards;

use App\Livewire\Forms\RewardForm;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class Create extends Component
{
    use WithFileUploads;

    public RewardForm $form;

    public function save()
    {
        $this->form->save();

        session()->flash('message', 'Prêmio criado com sucesso!');

        return redirect()->route('admin.rewards.index');
    }

    public function render()
    {
        return view('livewire.pages.admin.rewards.create')->title('Novo Prêmio');
    }
}
