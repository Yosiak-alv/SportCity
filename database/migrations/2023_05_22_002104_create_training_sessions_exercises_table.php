<?php

use App\Models\Exercise;
use App\Models\TrainingSession;
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
        Schema::create('training_sessions_exercises', function (Blueprint $table) {
            $table->foreignIdFor(TrainingSession::class)->nullable(false)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Exercise::class)->nullable(false)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('repetitions');
            $table->text('instructions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_sessions_exercises');
    }
};
