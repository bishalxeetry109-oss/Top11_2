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
        Schema::create('ball_by_ball', function (Blueprint $table) {
            $table->id();

            $table->foreignId('match_id')->constrained()->onDelete('cascade');
            $table->foreignId('innings_id')->constrained('match_innings')->onDelete('cascade');

            $table->integer('over');
            $table->integer('ball');

            $table->foreignId('striker_id')->constrained('match_players');
            $table->foreignId('non_striker_id')->nullable()->constrained('match_players');
            $table->foreignId('bowler_id')->constrained('match_players');

            $table->integer('runs')->default(0);

            $table->boolean('is_wicket')->default(false);
            $table->string('wicket_type')->nullable();

            $table->string('type'); // run, dot, wide, noball, wicket

            $table->text('commentary')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('ball_by_ball');
        Schema::enableForeignKeyConstraints();

    }
};
