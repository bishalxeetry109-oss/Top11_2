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
        Schema::create('match_states', function (Blueprint $table) {
            $table->id();

            $table->foreignId('match_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('innings_id')
                ->nullable()
                ->constrained('match_innings')
                ->onDelete('cascade');

            $table->enum('status', ['live', 'paused', 'completed'])
                ->default('live');

            $table->integer('current_innings')->default(1);

            $table->foreignId('last_ball_id')
                ->nullable()
                ->constrained('ball_by_ball')
                ->nullOnDelete();

            $table->integer('current_over')->default(0);
            $table->integer('current_ball')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::enableForeignKeyConstraints();
        Schema::dropIfExists('match_states');

    }
};
