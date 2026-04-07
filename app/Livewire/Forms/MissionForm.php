<?php

namespace App\Livewire\Forms;

use App\Models\Mission;
use Livewire\Attributes\Validate;
use Livewire\Form;

class MissionForm extends Form
{
    public ?Mission $mission = null;

    #[Validate('required|min:3|max:255')]
    public string $title = '';

    #[Validate('nullable|string')]
    public string $description = '';

    #[Validate('required|integer|min:1')]
    public int $points_reward = 10;

    #[Validate('boolean')]
    public bool $is_active = true;

    public function setMission(Mission $mission): void
    {
        $this->mission = $mission;

        $this->title = $mission->title;
        $this->description = $mission->description ?? '';
        $this->points_reward = $mission->points_reward;
        $this->is_active = $mission->is_active;
    }

    public function save(): void
    {
        $this->validate();

        if ($this->mission) {
            $this->mission->update($this->all());
        } else {
            Mission::create($this->all());
        }

        $this->reset(['title', 'description', 'points_reward', 'is_active', 'mission']);
    }
}
