<?php

namespace App\Livewire\Forms;

use App\Models\Reward;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class RewardForm extends Form
{
    use WithFileUploads;

    public ?Reward $reward = null;

    #[Validate('required|min:3|max:255')]
    public string $title = '';

    #[Validate('required|integer|min:1')]
    public int $cost = 100;

    #[Validate('required|integer|min:0')]
    public int $stock_quantity = 0;

    #[Validate('nullable|image|max:2048')]
    public $image;

    public function setReward(Reward $reward): void
    {
        $this->reward = $reward;

        $this->title = $reward->title;
        $this->cost = $reward->cost;
        $this->stock_quantity = $reward->stock_quantity;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'cost' => $this->cost,
            'stock_quantity' => $this->stock_quantity,
        ];

        if ($this->image) {
            $data['image_path'] = $this->image->store('rewards', 'public');
        }

        if ($this->reward) {
            $this->reward->update($data);
        } else {
            Reward::create($data);
        }

        $this->reset(['title', 'cost', 'stock_quantity', 'image', 'reward']);
    }
}
