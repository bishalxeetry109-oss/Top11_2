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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();

            // Basic Info
            $table->string('sport'); // cricket, football
            $table->string('venue');
            $table->dateTime('start_time');

            // Teams
            $table->foreignId('team_a_id')->constrained('teams');
            $table->foreignId('team_b_id')->constrained('teams');

            $table->foreignId('toss_winner_id')->nullable()->constrained('teams');
            $table->foreignId('batting_first_id')->nullable()->constrained('teams');

            // Match State
            $table->enum('status', ['upcoming', 'live', 'completed'])->default('upcoming');
            $table->integer('current_innings')->default(1);
            $table->integer('overs_limit')->default(20);

            // Result
            $table->foreignId('winner_id')->nullable()->constrained('teams');
            $table->string('result_text')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('matches');
        Schema::enableForeignKeyConstraints();

    }
};
