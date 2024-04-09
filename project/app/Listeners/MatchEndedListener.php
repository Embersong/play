<?php

namespace App\Listeners;

use App\Events\MatchEnded;
use App\Exceptions\MatchEndedException;
use App\Models\LotteryGame;
use App\Models\LotteryGameMatchUser;
use App\Models\User;

class MatchEndedListener
{
    /**
     * Handle the event.
     *
     * @param MatchEnded $event
     * @return void
     */
    public function handle(MatchEnded $event)
    {
        $match_users = LotteryGameMatchUser::query()->where('lottery_game_match_id', $event->match->id)
            ->inRandomOrder()
            ->first();
        if (!$match_users) {
            throw new MatchEndedException();
        }
        $user = User::find($match_users->user_id);
        $score = $match_users->lotteryGameMatch->lotteryGame->reward_points;

        $user->points += $score;
        $user->save();
    }
}
