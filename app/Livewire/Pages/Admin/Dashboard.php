<?php

namespace App\Livewire\Pages\Admin;

use App\Models\ActivityLog;
use App\Models\Order;
use App\Models\PointTransaction;
use App\Models\User;
use App\Enums\OrderStatus;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        $companyId = auth()->user()->company_id;

        // Métricas Scoped por Empresa
        $totalPointsAwarded = PointTransaction::where('amount', '>', 0)->sum('amount');
        $totalPointsRedeemed = abs(PointTransaction::where('amount', '<', 0)->sum('amount'));
        $totalUsers = User::count(); // Já possui Global Scope por empresa
        $pendingOrders = Order::where('status', OrderStatus::Pending)->count();

        return view('livewire.pages.admin.dashboard', [
            'totalPointsAwarded' => $totalPointsAwarded,
            'totalPointsRedeemed' => $totalPointsRedeemed,
            'totalUsers' => $totalUsers,
            'pendingOrders' => $pendingOrders,
            'recentActivity' => ActivityLog::with('user')->latest()->limit(8)->get(),
        ])->title('Painel de Controle - Gamifica');
    }
}
