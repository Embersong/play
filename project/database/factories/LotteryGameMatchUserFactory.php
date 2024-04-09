<?php

namespace Database\Factories;
use App\Models\LotteryGameMatch;
use App\Models\LotteryGameMatchUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LotteryGameMatchUserFactory extends Factory
{

    protected $model = LotteryGameMatchUser::class;

    public function definition()
    {
        $userIds = User::pluck('id')->toArray();
        $lotteryGameMatchIds = LotteryGameMatch::pluck('id')->toArray();

        $userId = $this->faker->unique()->randomElement($userIds);
        $lotteryGameMatchId = $this->faker->unique()->randomElement($lotteryGameMatchIds);

        return [
            'user_id' => $userId,
            'lottery_game_match_id' => $lotteryGameMatchId,
        ];
    }


}
