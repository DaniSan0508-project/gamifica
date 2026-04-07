<?php

namespace App\Livewire\Pages\Player\Shop;

use App\Models\Reward;
use App\Services\PointService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    /**
     * Resgata um prêmio da loja.
     */
    public function redeem(Reward $reward, PointService $pointService): void
    {
        $user = auth()->user();

        // Validar saldo
        if ($user->points_balance < $reward->cost) {
            session()->flash('error', "Saldo insuficiente para resgatar este prêmio.");
            return;
        }

        // Validar estoque
        if ($reward->stock_quantity <= 0) {
            session()->flash('error', "Desculpe, este prêmio está fora de estoque.");
            return;
        }

        // Processar o resgate (Cria pedido + Transação de Pontos + Baixa estoque)
        $order = $pointService->redeemReward($user, $reward);

        session()->flash('message', "Resgate realizado! Seu voucher é: {$order->voucher_code}. Apresente-o no RH para retirar seu prêmio.");
    }

    public function render()
    {
        return view('livewire.pages.player.shop.index', [
            'rewards' => Reward::where('stock_quantity', '>', 0)->latest()->get(),
        ])->title('Loja de Prêmios - Gamifica');
    }
}
