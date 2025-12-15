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
        Schema::create('ingresos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();
            $table->dateTime('fecha_ingreso')->nullable();
            $table->string('identificador')->nullable();
            $table->string('nom_iden')->nullable();
            $table->string('ref_lote')->nullable();
            $table->string('peso_total')->nullable();
            $table->string('estado')->nullable();
            $table->string('NroSalida')->nullable();
            $table->string('procedencia')->nullable();
            $table->string('deposito')->nullable();
            $table->string('balanza')->nullable();
            $table->string('placa')->nullable();
            $table->string('tolva')->nullable();
            $table->string('guia_transporte')->nullable();
            $table->string('guia_remision')->nullable();
            $table->string('muestreo')->nullable();
            $table->string('preparacion')->nullable();
            $table->string('req_analisis')->nullable();
            $table->string('descuento')->nullable();
            $table->string('fecha_salida')->nullable();
            $table->string('retiro')->nullable();
            $table->string('pesoexterno')->nullable();
            $table->string('lote')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('fase')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingresos');
    }
};
