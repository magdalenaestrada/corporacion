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
        Schema::create('ac_activos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('imei')->nullable();
            $table->string('codigo_barras')->nullable();
            $table->string('especificaciones')->nullable();
            $table->string('observaciones')->nullable();
            $table->string('valor')->nullable();
            $table->unsignedBigInteger('empleado_id')->nullable(); 
            $table->unsignedBigInteger('ac_activo_estado_id')->nullable(); 
            $table->unsignedBigInteger('ac_categoria_id')->nullable(); 

            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('restrict');
            $table->foreign('ac_activo_estado_id')->references('id')->on('ac_activos_estados')->onDelete('restrict');
            $table->foreign('ac_categoria_id')->references('id')->on('ac_categorias')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ac_activos');
    }
};
