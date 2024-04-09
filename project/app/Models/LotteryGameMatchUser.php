<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotteryGameMatchUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id', 'lottery_game_match_id',
    ];

    public function lotteryGameMatch()
    {
        return $this->belongsTo(LotteryGameMatch::class, 'lottery_game_match_id');
    }
}
