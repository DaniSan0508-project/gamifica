<?php

namespace App\Livewire\Pages\Player\Feedbacks;

use App\Models\Feedback;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.pages.player.feedbacks.index', [
            'feedbacks' => Feedback::with('sender')
                ->where('receiver_id', auth()->id())
                ->latest()
                ->paginate(10),
        ])->title('Meus Reconhecimentos');
    }
}
