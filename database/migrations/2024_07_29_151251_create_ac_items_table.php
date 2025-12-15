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
        Schema::create('ac_items', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('observacion');
            $table->unsignedBigInteger('ac_activo_id');
            $table->foreign('ac_activo_id')->references('id')->on('ac_activos')->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ac_items');
    }
};
