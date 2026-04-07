<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Models\ActivityLog;
use App\Models\Order;
use App\Models\PointTransaction;
use App\Models\Reward;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PointService
{
    /**
     * Adiciona ou subtrai pontos de um usuário de forma atômica.
     */
    public function updatePoints(User $user, int $amount, TransactionType $type, string $description): PointTransaction
    {
        return DB::transaction(function () use ($user, $amount, $type, $description) {
            // Atualizar saldo do usuário
            $user->points_balance += $amount;
            $user->save();

            // Registrar log de atividade social
            ActivityLog::create([
                'company_id' => $user->company_id,
                'user_id' => $user->id,
                'message' => $description,
            ]);

            // Registrar a transação
            return PointTransaction::create([
                'company_id' => $user->company_id,
                'user_id' => $user->id,
                'amount' => $amount,
                'type' => $type,
                'description' => $description,
            ]);
        });
    }

    /**
     * Adiciona pontos por completar uma missão.
     */
    public function awardPoints(User $user, int $points, string $missionTitle): PointTransaction
    {
        return $this->updatePoints(
            $user,
            $points,
            TransactionType::MissionComplete,
            "Missão concluída: {$missionTitle}"
        );
    }

    /**
     * Deduz pontos e gera um pedido de resgate.
     */
    public function redeemReward(User $user, Reward $reward): Order
    {
        return DB::transaction(function () use ($user, $reward) {
            // Deduzir pontos
            $this->updatePoints(
                $user,
                -$reward->cost,
                TransactionType::RewardRedeem,
                "Resgate de prêmio: {$reward->title}"
            );

            // Decrementar estoque
            $reward->decrement('stock_quantity');

            // Criar pedido
            return Order::create([
                'company_id' => $user->company_id,
                'user_id' => $user->id,
                'reward_id' => $reward->id,
                'points_cost' => $reward->cost,
                'voucher_code' => 'GAM-' . strtoupper(Str::random(8)),
                'status' => \App\Enums\OrderStatus::Pending,
            ]);
        });
    }
}
