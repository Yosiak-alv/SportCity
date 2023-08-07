<?php

use App\Models\Client;
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
        Schema::create('cash_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Client::class)->nullable(false)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('mensaje');
            $table->string('formaPago');
            $table->double('monto');
            $table->integer('suscription_id')->nullable();
            $table->integer('purchase_id')->nullable();
            $table->boolean('canceled')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_transactions');
    }
};
