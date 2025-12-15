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
        Schema::create('recepciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('retiro_id')->constrained()->onDelete('cascade'); // Relacionado con el retiro
            $table->decimal('bruto_recep', 10, 3)->nullable();
            $table->decimal('tara_recep', 10, 3) ->nullable();
            $table->decimal('neto_recep', 10, 3) ->nullable();
            $table->decimal('diferencia', 10, 3) ->nullable();
            $table->string('codigo_lote') ->nullable();
            $table->date('fecha_recepcion') ->nullable();
            $table->string('salida') ->nullable();
            $table->string('referencia') ->nullable();
            $table->string('custodio') ->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recepciones');
    }
};
