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
        Schema::create('retiros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('despacho_id')->constrained()->onDelete('cascade'); // Relación con despacho
            $table->string('nro_salida')->nullable(); 
            $table->string('precinto')->nullable(); 
            $table->string('guia')->nullable(); 
            $table->decimal('bruto', 10, 3)->nullable(); 
            $table->decimal('tara', 10, 3)->nullable(); 
            $table->decimal('neto', 10, 3)->nullable(); 
            $table->string('tracto')->nullable(); 
            $table->string('carreta')->nullable(); 
            $table->string('guia_transporte')->nullable(); 
            $table->string('ruc_empresa')->nullable(); 
            $table->string('razon_social')->nullable(); 
            $table->string('licencia')->nullable(); 
            $table->string( 'conductor')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retiros');
    }
};
