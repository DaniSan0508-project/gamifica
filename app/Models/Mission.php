<?php

namespace App\Models;

use App\Models\Traits\HasCompany;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['company_id', 'title', 'description', 'points_reward', 'is_active'])]
class Mission extends Model
{
    use HasFactory, HasUuids, HasCompany;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'points_reward' => 'integer',
        ];
    }
}
