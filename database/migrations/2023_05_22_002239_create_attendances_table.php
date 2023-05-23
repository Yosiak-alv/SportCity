<?php
use App\Models\Client;
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
        Schema::create('attendances', function (Blueprint $table) {
            $table->foreignIdFor(Client::class)->nullable(false)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(TrainingSession::class)->nullable(false)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamp('attendance_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
