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
        Schema::create('lottery_game_matches', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->time('start_time');
            $table->boolean('is_finished')->default(false);
            $table->unsignedBigInteger('winner_id')->nullable();
            $table->unsignedBigInteger('game_id');
            $table->foreign('winner_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('game_id')->references('id')->on('lottery_games')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lottery_game_matches', function (Blueprint $table) {
            $table->dropForeign(['winner_id']);
           });

        Schema::dropIfExists('lottery_game_matches');
    }
};
