<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotteryGameMatch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'game_id', 'start_date', 'start_time', 'winner_id', 'is_finished',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function lotteryGame()
    {
        return $this->belongsTo(LotteryGame::class, 'game_id');
    }

    public function lotteryGameMatchUsers()
    {
        return $this->hasMany(LotteryGameMatchUser::class, 'lottery_game_match_id');
    }
}
