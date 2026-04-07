<?php

namespace App\Livewire\Pages\Admin\Missions;

use App\Models\Mission;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public function delete(Mission $mission): void
    {
        $mission->delete();

        session()->flash('message', 'Missão removida com sucesso!');
    }

    public function toggleActive(Mission $mission): void
    {
        $mission->update([
            'is_active' => ! $mission->is_active,
        ]);
    }

    public function render()
    {
        return view('livewire.pages.admin.missions.index', [
            'missions' => Mission::latest()->paginate(10),
        ])->title('Gerenciar Missões');
    }
}
