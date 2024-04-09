<?php

namespace Database\Seeders;

use App\Models\LotteryGameMatch;
use Illuminate\Database\Seeder;

class LotteryGameMatchSeeder extends Seeder
{
    public function run(): void
    {
        LotteryGameMatch::factory(10)->create();
    }
}
