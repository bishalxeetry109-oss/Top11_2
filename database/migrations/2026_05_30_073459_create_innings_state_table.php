<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('innings_state', function (Blueprint $table) {
            $table->id();

            $table->foreignId('match_id')->constrained()->onDelete('cascade');
            $table->foreignId('innings_id')
                ->constrained('match_innings')
                ->onDelete('cascade');

            $table->foreignId('striker_id')->nullable()->constrained('match_players');
            $table->foreignId('non_striker_id')->nullable()->constrained('match_players');
            $table->foreignId('bowler_id')->nullable()->constrained('match_players');

            $table->integer('last_ball_number')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('innings_state');
        Schema::enableForeignKeyConstraints();

    }
};
