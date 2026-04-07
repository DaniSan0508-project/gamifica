<?php

namespace App\Livewire\Pages\Player\Orders;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.pages.player.orders.index', [
            'orders' => Order::with('reward')->where('user_id', auth()->id())->latest()->paginate(10),
        ])->title('Meus Resgates');
    }
}
