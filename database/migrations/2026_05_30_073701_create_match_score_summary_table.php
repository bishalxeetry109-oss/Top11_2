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
        Schema::create('match_score_summary', function (Blueprint $table) {
            $table->id();

            $table->foreignId('match_id')->constrained()->onDelete('cascade');

            $table->integer('innings_1_runs')->default(0);
            $table->integer('innings_1_wickets')->default(0);
            $table->decimal('innings_1_overs', 4, 1)->default(0.0);

            $table->integer('innings_2_runs')->default(0);
            $table->integer('innings_2_wickets')->default(0);
            $table->decimal('innings_2_overs', 4, 1)->default(0.0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('match_score_summary');
        Schema::enableForeignKeyConstraints();

    }
};
