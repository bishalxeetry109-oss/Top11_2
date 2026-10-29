<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contests', function (Blueprint $table) {
            $table->id();

            // Contest Info
            $table->string('name');

            // Match relation
            $table->foreignId('match_id')
                ->constrained('matches')
                ->onDelete('cascade');

            // 💰 Money system
            $table->decimal('entry_fee', 10, 2)->default(0);
            $table->decimal('prize_pool', 12, 2)->default(0);

            // 👥 Participation control
            $table->integer('max_spots')->default(0);
            $table->integer('joined_spots')->default(0);

            // 🟢 Status control
            $table->enum('status', ['open', 'live', 'closed'])
                ->default('open');

            // 🏆 Prize system
            $table->integer('first_prize')->nullable();
            $table->integer('winners_count')->nullable();

            // 🔥 IMPORTANT (ADD THIS)
            $table->boolean('is_featured')->default(false); // for homepage highlight
            $table->timestamp('starts_at')->nullable(); // contest scheduling

            $table->timestamps();

            // ⚡ Index for fast queries
            $table->index(['match_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('contests');
        Schema::enableForeignKeyConstraints();

    }
};