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
        Schema::create('humedades', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->foreignId('cliente_id')
                  ->constrained('clientes')
                  ->restrictOnDelete();

            $table->foreignId('estado_mineral_id')
                  ->constrained('estados_mineral')
                  ->restrictOnDelete();

            // Fechas principales
            $table->date('fecha_recepcion')->nullable();
            $table->date('fecha_emision')->nullable();

            // Periodo real de la muestra (inicio y fin)
            $table->date('periodo_inicio')->nullable();
            $table->date('periodo_fin')->nullable();

            // Datos de humedad
            $table->decimal('humedad', 8, 2)->nullable();

            // Observaciones
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('humedades');
    }
};
