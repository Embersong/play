<?php

namespace Database\Seeders;

use App\Models\LotteryGame;
use Illuminate\Database\Seeder;

class LotteryGameSeeder extends Seeder
{
    public function run(): void
    {
        LotteryGame::factory(5)->create();
    }
}
