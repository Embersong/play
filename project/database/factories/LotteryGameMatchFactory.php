<?php

namespace Database\Factories;

use App\Models\LotteryGame;
use App\Models\LotteryGameMatch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LotteryGameMatchFactory extends Factory
{
    protected $model = LotteryGameMatch::class;

    public function definition()
    {
        $game = LotteryGame::inRandomOrder()->first();
        $startDate = $this->faker->date();
        $startTime = $this->faker->time();
        //$winner = User::inRandomOrder()->first();


        return [
            'game_id' => $game->id,
            'start_date' => $startDate,
            'start_time' => $startTime,
            //'winner_id' => $winner->id,
        ];
    }
}
