<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Reward;
use App\Models\User;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'user_id' => User::factory(),
            'reward_id' => Reward::factory(),
            'voucher_code' => 'GAM-' . strtoupper(Str::random(8)),
            'points_cost' => fake()->numberBetween(100, 1000),
            'status' => OrderStatus::Pending,
        ];
    }
}
