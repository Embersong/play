<?php

namespace App\Listeners;

use App\Events\UserAdded;
use App\Exceptions\MatchFullException;
use App\Exceptions\UserAddedException;
use App\Models\LotteryGameMatch;
use App\Models\LotteryGameMatchUser;

class UserAddedListener
{

    /**
     * Handle the event.
     *
     * @param UserAdded $event
     * @return void
     * @throws UserAddedException
     * @throws MatchFullException
     */
    public function handle(UserAdded $event): void
    {
        $lotteryGameMatch = LotteryGameMatch::query()->find($event->match_id);
        $gamerCount = $lotteryGameMatch->lotteryGame->gamer_count;
        $userCount = $lotteryGameMatch->lotteryGameMatchUsers()->count();

        if ($userCount >= $gamerCount) {
            throw new MatchFullException();
        }

        $existingRecord = LotteryGameMatchUser::query()
            ->where('user_id', $event->user_id)
            ->where('lottery_game_match_id', $event->match_id)
            ->first();

        if ($existingRecord) {
            throw new UserAddedException();
        }
    }
}
