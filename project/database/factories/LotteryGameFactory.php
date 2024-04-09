<?php

namespace Database\Factories;

use App\Models\LotteryGame;
use Illuminate\Database\Eloquent\Factories\Factory;

class LotteryGameFactory extends Factory
{
    protected $model = LotteryGame::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'gamer_count' => $this->faker->numberBetween(2, 3), // число игроков
            'reward_points' => $this->faker->numberBetween(10, 100),
        ];
    }
}
