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
        Schema::create('muestras', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('au')->nullable();
            $table->string('ag')->nullable();
            $table->string('cu')->nullable();
            $table->string('as')->nullable();
            $table->string('sb')->nullable();
            $table->string('pb')->nullable();
            $table->string('zn')->nullable();
            $table->string('bi')->nullable();
            $table->string('hg')->nullable();
            $table->string('s')->nullable();
            $table->string('humedad')->nullable();
            $table->string('obs')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('muestras');
    }
};
