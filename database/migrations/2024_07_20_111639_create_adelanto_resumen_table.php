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
        Schema::create('adelanto_resumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adelanto_id')->constrained('adelantos')->onDelete('cascade');
            $table->foreignId('resumen_id')->constrained('resumens')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adelanto_resumen');
    }
};
