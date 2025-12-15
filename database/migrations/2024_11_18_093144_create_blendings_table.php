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
        Schema::create('blendings', function (Blueprint $table) {
            $table->id();
            $table->string('cod')->nullable();
            $table->string('lista')->nullable();
            $table->decimal('pesoblending', 10, places: 3)->nullable(); // Asegúrate de que sea decimal para pesos
            $table->foreignId('user_id')->constrained()->nullable(); // Si tienes un modelo de usuario
            $table->text('notas')->nullable(); // Para observaciones
            $table->enum('estado', ['activo', 'inactivo'])->default('activo'); // Si necesitas un estado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blendings');
    }
};
