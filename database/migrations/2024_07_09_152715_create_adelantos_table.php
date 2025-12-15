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
        Schema::create('adelantos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id'); 
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->date('fecha')->nullable();
            $table->string('nrofactura')->nullable();
            $table->string('proveedor')->nullable();
            $table->string('deposito')->nullable();
            $table->string('detraccion')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('total')->nullable();
            $table->string('estado')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adelantos');
    }
};
