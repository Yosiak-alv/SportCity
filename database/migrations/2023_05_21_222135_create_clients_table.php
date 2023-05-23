<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Gym;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('dui')->unique();
            $table->string('name');
            $table->string('lastname');
            $table->string('genre');
            $table->string('phone');
            $table->text('address');
            $table->date('birth_date');
            $table->string('height');
            $table->string('weight');

            $table->foreignIdFor(Gym::class)->nullable(false)->constrained()->cascadeOnUpdate()->restrictOnDelete();

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
