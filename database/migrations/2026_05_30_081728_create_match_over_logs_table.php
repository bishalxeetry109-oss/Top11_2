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
        Schema::create('match_over_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('match_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('innings_id')
                ->constrained('match_innings')
                ->onDelete('cascade');

            $table->foreignId('bowler_id')
                ->constrained('match_players')
                ->onDelete('cascade');

            $table->integer('over_number');   // e.g. 1,2,3...
            $table->integer('balls_faced')->default(0); // valid balls only (0–6)

            $table->integer('runs_conceded')->default(0);
            $table->integer('wickets')->default(0);

            $table->boolean('is_completed')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('match_over_logs');
        Schema::enableForeignKeyConstraints();

    }
};
