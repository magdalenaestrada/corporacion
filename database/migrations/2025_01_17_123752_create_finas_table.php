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
        Schema::create('finas', function (Blueprint $table) {
            $table->id();
            $table->string('codigoBlending')->nullable();
            $table->decimal('total_tmh', 15, 3)->nullable();
            $table->decimal('porcentaje_h2o', 15, 3)->nullable();
            $table->decimal('total_tms', 15, 3)->nullable();
            $table->decimal('au_promedio', 15, 5)->nullable();
            $table->decimal('ag_promedio', 15, 5)->nullable();
            $table->decimal('cu_promedio', 15, 5)->nullable();
            $table->decimal('as_promedio', 15, 5)->nullable();
            $table->decimal('sb_promedio', 15, 5)->nullable();
            $table->decimal('pb_promedio', 15, 5)->nullable();
            $table->decimal('zn_promedio', 15, 5)->nullable();
            $table->decimal('bi_promedio', 15, 5)->nullable();
            $table->decimal('hg_promedio', 15, 5)->nullable();
            $table->decimal('total_valor_lote', 15, 3)->nullable();
            $table->decimal('total_liquidacion', 15, 3)->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finas');
    }
};
