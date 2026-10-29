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
        Schema::create('batsman_scorecards', function (Blueprint $table) {
    $table->id();

    $table->foreignId('match_id')->constrained()->onDelete('cascade');
    $table->foreignId('innings_id')->constrained('match_innings')->onDelete('cascade');
    $table->foreignId('player_id')->constrained('players');

    $table->integer('runs')->default(0);
    $table->integer('balls')->default(0);
    $table->integer('fours')->default(0);
    $table->integer('sixes')->default(0);

    $table->boolean('is_out')->default(false);
    $table->string('how_out')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::disableForeignKeyConstraints();
    Schema::dropIfExists('batsman_scorecards');
    Schema::enableForeignKeyConstraints();

    }
};
