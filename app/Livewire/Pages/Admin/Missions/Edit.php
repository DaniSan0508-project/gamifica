<?php

namespace App\Livewire\Pages\Admin\Missions;

use App\Livewire\Forms\MissionForm;
use App\Models\Mission;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Edit extends Component
{
    public MissionForm $form;

    public function mount(Mission $mission)
    {
        $this->form->setMission($mission);
    }

    public function save()
    {
        $this->form->save();

        session()->flash('message', 'Missão atualizada com sucesso!');

        return redirect()->route('admin.missions.index');
    }

    public function render()
    {
        return view('livewire.pages.admin.missions.create')->title('Editar Missão');
    }
}
