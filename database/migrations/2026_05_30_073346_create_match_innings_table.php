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
        Schema::create('match_innings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('match_id')->constrained()->onDelete('cascade');

            $table->integer('innings_number'); // 1 or 2

            $table->foreignId('batting_team_id')->constrained('teams');
            $table->foreignId('bowling_team_id')->constrained('teams');

            $table->integer('runs')->default(0);
            $table->integer('wickets')->default(0);

            $table->decimal('overs', 4, 1)->default(0.0); // e.g. 5.3
            $table->integer('balls')->default(0);

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
        Schema::dropIfExists('match_innings');
        Schema::enableForeignKeyConstraints();

    }
};
