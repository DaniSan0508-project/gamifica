<?php

namespace App\Livewire\Pages\Admin\Rewards;

use App\Livewire\Forms\RewardForm;
use App\Models\Reward;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class Edit extends Component
{
    use WithFileUploads;

    public RewardForm $form;

    public function mount(Reward $reward)
    {
        $this->form->setReward($reward);
    }

    public function save()
    {
        $this->form->save();

        session()->flash('message', 'Prêmio atualizado com sucesso!');

        return redirect()->route('admin.rewards.index');
    }

    public function render()
    {
        return view('livewire.pages.admin.rewards.create')->title('Editar Prêmio');
    }
}
