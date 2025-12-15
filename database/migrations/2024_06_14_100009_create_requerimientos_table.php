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
        Schema::create('requerimientos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id'); // Añadir columna cliente_id         
            // Definir la clave foránea
            //$table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->string('proteccion_au')->nullable();
            $table->string('proteccion_ag')->nullable();
            $table->string('proteccion_cu')->nullable();
            $table->string('deduccion_au')->nullable();
            $table->string('deduccion_ag')->nullable();
            $table->string('deduccion_cu')->nullable();
            $table->string('refinamiento_au')->nullable();
            $table->string('refinamiento_ag')->nullable();
            $table->string('refinamiento_cu')->nullable();
            $table->string('maquila')->nullable();
            $table->string('analisis')->nullable();
            $table->string('estibadores')->nullable();
            $table->string('igv')->nullable();
            $table->string('penalidad_as')->nullable();
            $table->string('penalidad_sb')->nullable();
            $table->string('penalidad_pb')->nullable();
            $table->string('penalidad_zn')->nullable();
            $table->string('penalidad_bi')->nullable();
            $table->string('penalidad_hg')->nullable();
            $table->string('penalidad_s')->nullable();
            $table->string('penalidad_h2o')->nullable();
            $table->string('merma')->nullable();
            $table->string('pagable_au')->nullable();
            $table->string('pagable_ag')->nullable();
            $table->string('pagable_cu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requerimientos');
    }
};
