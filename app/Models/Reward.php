<?php

namespace App\Models;

use App\Models\Traits\HasCompany;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['company_id', 'title', 'cost', 'stock_quantity', 'image_path'])]
class Reward extends Model
{
    use HasFactory, HasUuids, HasCompany;

    protected function casts(): array
    {
        return [
            'cost' => 'integer',
            'stock_quantity' => 'integer',
        ];
    }
}
