<?php

namespace App\Livewire\Pages\Admin\Missions;

use App\Livewire\Forms\MissionForm;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Create extends Component
{
    public MissionForm $form;

    public function save()
    {
        $this->form->save();

        session()->flash('message', 'Missão criada com sucesso!');

        return redirect()->route('admin.missions.index');
    }

    public function render()
    {
        return view('livewire.pages.admin.missions.create')->title('Nova Missão');
    }
}
