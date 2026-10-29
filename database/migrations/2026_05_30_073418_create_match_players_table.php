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
       Schema::create('match_players', function (Blueprint $table) {
    $table->id();

    $table->foreignId('match_id')->constrained()->onDelete('cascade');
    $table->foreignId('player_id')->constrained()->onDelete('cascade');
    $table->foreignId('team_id')->constrained();
    $table->enum('role',['WK','BAT','AR','BOWL']);
    $table->float('credit');
    $table->boolean('is_playing')->default(true);
    $table->integer('batting_position')->nullable();

    $table->enum('batting_status', ['yet_to_bat', 'in_strike', 'in_non_strike', 'out'])
        ->default('yet_to_bat');

    $table->boolean('is_bowling')->default(false);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::disableForeignKeyConstraints();
    Schema::dropIfExists('match_players');
    Schema::enableForeignKeyConstraints();

    }
};
