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
        Schema::table('liquidaciones', function (Blueprint $table) {
            $table->string('estado')->nullable();
            $table->string('transporte')->nullable();
            $table->string('comentario')->nullable();
            $table->string('dolar')->nullable();
            $table->string('resultadoestibadores')->nullable(); 
            $table->string('resultadomolienda')->nullable();
            $table->string('division')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('liquidaciones', function (Blueprint $table) {
            $table->dropColumn('estado');
            $table->dropColumn('transporte');
            $table->dropColumn('comentario');
            $table->dropColumn(columns: 'dolar');
            $table->dropColumn(columns: 'resultadoestibadores');
            $table->dropColumn('resultadomolienda');
            $table->dropColumn('division');
        });
    }
};
