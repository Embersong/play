<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lottery_game_match_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('lottery_game_match_id');

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('lottery_game_match_id')->references('id')->on('lottery_game_matches')->nullOnDelete();;

            $table->unique(['user_id', 'lottery_game_match_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lottery_game_match_users', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['lottery_game_match_id']);
            $table->dropUnique(['user_id', 'lottery_game_match_id']);
        });

        Schema::dropIfExists('lottery_game_match_users');



    }
};
