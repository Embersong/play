<?php

namespace Database\Seeders;

use App\Models\LotteryGameMatchUser;
use Illuminate\Database\Seeder;

class LotteryGameMatchUsersSeeder extends Seeder
{
    public function run(): void
    {
        LotteryGameMatchUser::factory(10)->create();
    }
}
