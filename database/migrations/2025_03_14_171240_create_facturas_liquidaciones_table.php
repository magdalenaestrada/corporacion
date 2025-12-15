<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('facturas_liquidaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('liquidacion_id')->constrained('liquidaciones')->onDelete('cascade');
            $table->string('factura_numero'); // Campo de texto para almacenar el número de factura
            $table->decimal('monto', 10, 3);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('facturas_liquidaciones');
    }
};
