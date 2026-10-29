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
        Schema::create('balls', function (Blueprint $table) {
            $table->id();

            $table->foreignId('match_id')->constrained()->onDelete('cascade');
            $table->foreignId('innings_id')->constrained('match_innings')->onDelete('cascade');

            $table->foreignId('striker_id')->constrained('match_players');
            $table->foreignId('bowler_id')->constrained('match_players');

            $table->integer('over');
            $table->integer('ball_number'); // 1-6

            $table->string('type'); // run, dot, wide, wicket, noball
            $table->integer('runs')->default(0);

            $table->boolean('is_legal')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('balls');
        Schema::enableForeignKeyConstraints();

    }
};
