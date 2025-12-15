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
        Schema::create('despachos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blending_id')->constrained()->onDelete('cascade'); // Relación con blending
            $table->decimal('totalTMH', 10, places: 3)->nullable();
            $table->string('masomenos')->nullable(); 
            $table->date('fecha')->nullable(); 
            $table->string('observacion')->nullable(); 
            $table->string('codigo')->nullable(); 
            $table->string('deposito')->nullable(); 
            $table->string('destino')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('despachos');
    }
};
