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
        Schema::create('bowler_scorecards', function (Blueprint $table) {
            $table->id();

            $table->foreignId('match_id')->constrained()->onDelete('cascade');
            $table->foreignId('innings_id')->constrained('match_innings')->onDelete('cascade');
            $table->foreignId('player_id')->constrained('players');

            $table->decimal('overs', 4, 1)->default(0.0);
            $table->integer('balls')->default(0);

            $table->integer('runs_conceded')->default(0);
            $table->integer('wickets')->default(0);
            $table->integer('maidens')->default(0);
            $table->decimal('economy', 4, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('bowler_scorecards');
        Schema::enableForeignKeyConstraints();

    }
};
