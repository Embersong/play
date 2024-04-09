<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotteryGame extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'gamer_count', 'reward_points',
    ];

    public function lotteryGameMatches()
    {
        return $this->hasMany(LotteryGameMatch::class, 'game_id');
    }
}
