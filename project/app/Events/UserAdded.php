<?php

namespace App\Events;

class UserAdded extends Event
{
    public int $user_id;
    public int $match_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $user_id, int $match_id)
    {
        $this->user_id = $user_id;
        $this->match_id = $match_id;
    }
}
