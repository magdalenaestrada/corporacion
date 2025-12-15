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
        Schema::create('liquidaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('muestra_id');
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('resumen_id')->nullable();
            $table->foreign('muestra_id')->references('id')->on('muestras');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('resumen_id')->references('id')->on('resumens');
            $table->decimal('peso', 10, 2);
            $table->string('lote');
            $table->string('producto');
            $table->decimal('cotizacion_au', 10, 2);
            $table->decimal('cotizacion_ag', 10, 2);
            $table->decimal('cotizacion_cu', 10, 2);
            $table->string('tms')->nullable();
            $table->string('tmns')->nullable();
            $table->string('ley_au')->nullable();
            $table->string('formula_au')->nullable();
            $table->string('precio_au')->nullable();
            $table->string('val_au')->nullable();
            $table->string('ley_ag')->nullable();
            $table->string('formula_ag')->nullable();
            $table->string('precio_ag')->nullable();
            $table->string('val_ag')->nullable();
            $table->string('ley_cu')->nullable();
            $table->string('formula_cu')->nullable();
            $table->string('precio_cu')->nullable();
            $table->string('val_cu')->nullable();
            $table->string('total_valores')->nullable();
            $table->string('formula_fi_au')->nullable();
            $table->string('fina_au')->nullable();
            $table->string('formula_fi_ag')->nullable();
            $table->string('fina_ag')->nullable();
            $table->string('formula_fi_cu')->nullable();
            $table->string('fina_cu')->nullable();
            $table->string('total_deducciones')->nullable();
            $table->string('total_as')->nullable();
            $table->string('total_sb')->nullable();
            $table->string('total_pb')->nullable();
            $table->string('total_bi')->nullable();
            $table->string('total_hg')->nullable();
            $table->string('total_s')->nullable();
            $table->string('total_penalidades')->nullable();
            $table->string('total_us')->nullable();
            $table->string('valorporlote')->nullable();
            $table->string('valor_igv')->nullable();
            $table->string('total_porcentajeliqui')->nullable();
            $table->string('saldo')->nullable();
            $table->string('detraccion')->nullable();
            $table->string('total_liquidacion')->nullable();
            $table->string('procesoplanta')->nullable();
            $table->string('adelantosextras')->nullable();
            $table->string('prestamos')->nullable();
            $table->string('otros_descuentos')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->string('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liquidaciones');
    }
};
