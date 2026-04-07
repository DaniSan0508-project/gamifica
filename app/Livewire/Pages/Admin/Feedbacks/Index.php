<?php

namespace App\Livewire\Pages\Admin\Feedbacks;

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
        return view('livewire.pages.admin.feedbacks.index', [
            'feedbacks' => Feedback::with(['sender', 'receiver'])
                ->latest()
                ->paginate(15),
        ])->title('Gestão de Reconhecimentos');
    }
}
