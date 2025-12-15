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
        Schema::create('pesos', function (Blueprint $table) {
            $table->bigIncrements('NroSalida');

            $table->datetime('Horas')->nullable();
            $table->datetime('Fechas')->nullable();
            $table->datetime('Fechai')->nullable();
            $table->datetime('Horai')->nullable();

            $table->bigInteger('Pesoi')->nullable();
            $table->bigInteger('Pesos')->nullable();
            $table->bigInteger('Bruto')->nullable();
            $table->bigInteger('Tara')->nullable();
            $table->bigInteger('Neto')->nullable();

            $table->string('Placa')->nullable();
            $table->text('Observacion')->nullable();
            $table->string('Producto')->nullable();
            $table->string('Conductor')->nullable();
            $table->string('Transportista')->nullable();
            $table->string('RazonSocial')->nullable();
            $table->string('Operadori')->nullable(); 

            $table->tinyInteger('Destarado')->nullable();

            $table->string('Operadors')->nullable(); 
            $table->string('carreta')->nullable();
            $table->string('guia')->nullable();
            $table->string('guiat')->nullable();
            $table->string('pedido')->nullable();
            $table->string('entrega')->nullable();
            $table->string('um')->nullable();

            $table->bigInteger('pesoguia')->nullable();

            $table->string('rucr')->nullable();
            $table->string('ruct')->nullable();
            $table->string('destino')->nullable();
            $table->string('origen')->nullable();
            $table->string('brevete')->nullable();
            $table->string('pbmax')->nullable();
            $table->string('tipo')->nullable();
            $table->string('centro')->nullable();
            $table->string('nia')->nullable();
            $table->string('bodega')->nullable();
            $table->string('ip')->nullable();

            $table->tinyInteger('anular')->nullable();
            $table->tinyInteger('eje')->nullable();
            $table->string('pesaje')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesos');
    }
};
