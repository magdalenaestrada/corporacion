<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('humedad', function (Blueprint $table) {
            $table->id();

            // ✅ CÓDIGO DE INFORME (H2600063, H2600064, ...)
            $table->string('codigo', 20)->unique()->comment('Código de informe de ensayo');

            // FK a estados_mineral (MINERAL)
            $table->unsignedBigInteger('estado_mineral_id');

            // FK a clientes (RAZON SOCIAL)
            $table->unsignedBigInteger('cliente_id');

            // Fechas
            $table->date('fecha_recepcion')->nullable();
            $table->date('fecha_emision')->nullable();

            // Periodo de ensayo
            $table->date('periodo_inicio')->nullable();
            $table->date('periodo_fin')->nullable();

            // Resultado de humedad
            $table->decimal('humedad', 6, 3)->nullable(); // ej: 6.110

            // Observaciones
            $table->string('observaciones', 500)->nullable();

            $table->timestamps();

            // 🔑 Foreign keys
            $table->foreign('estado_mineral_id')
                ->references('id')
                ->on('estados_mineral');

            $table->foreign('cliente_id')
                ->references('id')
                ->on('clientes');

            // 📌 Índices
            $table->index('codigo');
            $table->index('fecha_recepcion');
            $table->index('cliente_id');
            $table->index('estado_mineral_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('humedad');
    }
};
