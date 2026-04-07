<?php

namespace App\Livewire\Pages\Player;

use App\Models\ActivityLog;
use App\Models\Mission;
use App\Models\PointTransaction;
use App\Models\User;
use App\Services\PointService;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    /**
     * Completa uma missão (Simulação para demonstração da Fase 3).
     */
    public function completeMission(Mission $mission, PointService $pointService): void
    {
        $pointService->awardPoints(auth()->user(), $mission->points_reward, $mission->title);

        session()->flash('message', "Parabéns! Você ganhou {$mission->points_reward} pontos.");
    }

    public function render()
    {
        $user = auth()->user();

        // Caching do ranking por empresa por 10 minutos (Convertido para array para evitar erros de serialização)
        $leaderboard = Cache::remember('leaderboard_' . $user->company_id, now()->addMinutes(10), function () use ($user) {
            return User::select(['id', 'name', 'points_balance', 'company_id'])
                ->where('role', \App\Enums\UserRole::Employee)
                ->orderByDesc('points_balance')
                ->orderBy('name')
                ->limit(5)
                ->get()
                ->toArray();
        });

        return view('livewire.pages.player.dashboard', [
            'availableMissions' => Mission::where('is_active', true)->latest()->limit(5)->get(),
            'recentTransactions' => PointTransaction::where('user_id', $user->id)->latest()->limit(5)->get(),
            'leaderboard' => User::hydrate($leaderboard),
            'activityFeed' => ActivityLog::where('company_id', $user->company_id)
                ->with('user')
                ->latest()
                ->limit(10)
                ->get(),
        ])->title('Dashboard - Gamifica');
    }
}
