<?php

namespace App\Livewire\Pages\Common;

use App\Enums\UserRole;
use App\Models\Feedback;
use App\Models\User;
use App\Services\PointService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.app')]
class SendFeedback extends Component
{
    #[Validate('required|uuid|exists:users,id')]
    public string $receiver_id = '';

    #[Validate('required|string|min:5|max:1000')]
    public string $message = '';

    #[Validate('nullable|integer|min:0')]
    public int $points_bonus = 0;

    public function save(PointService $pointService)
    {
        $this->validate();

        $sender = auth()->user();
        $receiver = User::findOrFail($this->receiver_id);

        // Security check: must be same company
        if ($sender->company_id !== $receiver->company_id) {
            abort(404);
        }

        // Only admins can award bonus points through feedback for now
        $actualBonus = ($sender->role === UserRole::Admin) ? $this->points_bonus : 0;

        Feedback::create([
            'company_id' => $sender->company_id,
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'message' => $this->message,
            'points_bonus' => $actualBonus,
        ]);

        if ($actualBonus > 0) {
            $pointService->updatePoints(
                $receiver,
                $actualBonus,
                \App\Enums\TransactionType::AdminAdjustment,
                "Bônus recebido via feedback de {$sender->name}"
            );
        }

        session()->flash('message', 'Seu reconhecimento foi enviado com sucesso! 🚀');

        return redirect()->route($sender->role === UserRole::Admin ? 'admin.feedbacks.index' : 'player.feedbacks.index');
    }

    public function render()
    {
        return view('livewire.pages.common.send-feedback', [
            'colleagues' => User::where('id', '!=', auth()->id())->orderBy('name')->get(),
        ])->title('Enviar Reconhecimento');
    }
}
