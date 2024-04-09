<?php

namespace App\Events;

use App\Models\LotteryGameMatch;

class MatchEnded extends Event
{
    public LotteryGameMatch $match;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(LotteryGameMatch $match)
    {
        $this->match = $match;
    }
}
