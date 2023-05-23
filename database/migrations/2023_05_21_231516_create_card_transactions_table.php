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
        Schema::create('card_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Client::class)->nullable(false)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('idTransaccion');
            $table->boolean('esReal');
            $table->boolean('esAprobada');
            $table->string('codigoAutorizacion');
            $table->string('mensaje');
            $table->string('formaPago');
            $table->double('monto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_transactions');
    }
};
