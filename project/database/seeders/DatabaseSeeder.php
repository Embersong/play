<?php

namespace Database\Seeders;

use App\Models\LotteryGame;
use App\Models\LotteryGameMatch;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Song',
            'email' => 'admin@admin.ru',
            'is_admin' => 1,
            'points' => 0,
            'password' => Hash::make('123')
        ]);

        $this->call([
            UsersSeeder::class,
            LotteryGameSeeder::class,
            LotteryGameMatchSeeder::class,
           // LotteryGameMatchUsersSeeder::class,
        ]);
    }
}
