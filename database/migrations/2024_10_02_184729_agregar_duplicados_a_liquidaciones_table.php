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
            $table->string('proteccion_au2')->nullable();
            $table->string('proteccion_ag2')->nullable();
            $table->string('proteccion_cu2')->nullable();
            $table->string('pagable_au2')->nullable();
            $table->string('pagable_ag2')->nullable();
            $table->string('pagable_cu2')->nullable();
            $table->string('deduccion_au2')->nullable();
            $table->string('deduccion_ag2')->nullable();
            $table->string('deduccion_cu2')->nullable();
            $table->string('refinamiento_au2')->nullable();
            $table->string('refinamiento_ag2')->nullable();
            $table->string('refinamiento_cu2')->nullable();
            $table->string('maquila2')->nullable();
            $table->string('analisis2')->nullable();
            $table->string('estibadores2')->nullable();
            $table->string('molienda2')->nullable();
            $table->string('igv2')->nullable();
            $table->string('penalidad_as2')->nullable();
            $table->string('penalidad_sb2')->nullable();
            $table->string('penalidad_pb2')->nullable();
            $table->string('penalidad_zn2')->nullable();
            $table->string('penalidad_bi2')->nullable();
            $table->string('penalidad_hg2')->nullable();
            $table->string('penalidad_s2')->nullable();
            $table->string('penalidad_h2o2')->nullable();
            $table->string('merma2')->nullable();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('liquidaciones', function (Blueprint $table) {
            $table->dropColumn('proteccion_au2');
            $table->dropColumn('proteccion_ag2');
            $table->dropColumn('proteccion_cu2');
            $table->dropColumn('pagable_au2');
            $table->dropColumn('pagable_ag2');
            $table->dropColumn('pagable_cu2');
            $table->dropColumn('deduccion_au2');
            $table->dropColumn('deduccion_ag2');
            $table->dropColumn('deduccion_cu2');
            $table->dropColumn('refinamiento_au2');
            $table->dropColumn('refinamiento_ag2');
            $table->dropColumn('refinamiento_cu2');
            $table->dropColumn('maquila2');
            $table->dropColumn('analisis2');
            $table->dropColumn('estibadores2');
            $table->dropColumn('molienda2');
            $table->dropColumn('igv2');
            $table->dropColumn('penalidad_as2');
            $table->dropColumn('penalidad_sb2');
            $table->dropColumn('penalidad_pb2');
            $table->dropColumn('penalidad_zn2');
            $table->dropColumn('penalidad_bi2');
            $table->dropColumn('penalidad_hg2');
            $table->dropColumn('penalidad_s2');
            $table->dropColumn('penalidad_h2o2');
            $table->dropColumn('merma2');
        });
    }
};
