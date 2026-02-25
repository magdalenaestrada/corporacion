<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('humedad_pesos', function (Blueprint $table) {
            $table->id();

            // FK a tu tabla humedad (singular)
            $table->foreignId('humedad_id')
                ->constrained('humedad')
                ->cascadeOnDelete();

            // Identifica la balanza: A=ALFA (pesos), K=KILATE (pesos_kilate)
            $table->enum('origen', ['A', 'K']);

            // Ticket de la balanza
            $table->unsignedBigInteger('nro_salida');

            // Snapshot opcional (te permite sumar sin volver a consultar balanzas)
            $table->bigInteger('neto')->nullable();

            $table->timestamps();

            // Evita duplicados por humedad + origen + ticket
            $table->unique(['humedad_id', 'origen', 'nro_salida']);
            $table->index(['origen', 'nro_salida']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('humedad_pesos');
    }
};
