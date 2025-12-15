<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('liquidaciones', function (Blueprint $table) {
            $table->decimal('adelantos', 10, 3)->nullable();  // Para valores monetarios, 10 dígitos con 2 decimales
            $table->string('fechai')->nullable();  // Para almacenar solo la fecha
        });
    }

    public function down()
    {
        Schema::table('liquidaciones', function (Blueprint $table) {
            $table->dropColumn('adelantos');
            $table->dropColumn('fechai');
        });
    }
};

