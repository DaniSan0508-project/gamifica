<?php

namespace App\Livewire\Pages\Admin\Orders;

use App\Models\Order;
use App\Enums\OrderStatus;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public function deliver(Order $order): void
    {
        $order->update([
            'status' => OrderStatus::Delivered,
            'delivered_at' => now(),
        ]);

        session()->flash('message', 'Pedido marcado como entregue!');
    }

    public function render()
    {
        return view('livewire.pages.admin.orders.index', [
            'orders' => Order::with(['user', 'reward'])->latest()->paginate(10),
        ])->title('Gerenciar Pedidos');
    }
}
