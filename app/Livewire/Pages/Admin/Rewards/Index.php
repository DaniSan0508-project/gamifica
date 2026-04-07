<?php

namespace App\Livewire\Pages\Admin\Rewards;

use App\Models\Reward;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public function delete(Reward $reward): void
    {
        $reward->delete();

        session()->flash('message', 'Prêmio removido com sucesso!');
    }

    public function render()
    {
        return view('livewire.pages.admin.rewards.index', [
            'rewards' => Reward::latest()->paginate(10),
        ])->title('Gerenciar Loja');
    }
}
