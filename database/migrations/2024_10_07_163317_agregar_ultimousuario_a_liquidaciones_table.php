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
            $table->unsignedBigInteger('ultimo_editor_id')->nullable()->after('usuario_id'); // Cambia la posición según tu preferencia
            // Si usas claves foráneas, puedes agregar esto:
            $table->foreign('ultimo_editor_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('liquidaciones', function (Blueprint $table) {
            $table->dropForeign(['ultimo_editor_id']); // Si es que añadiste la clave foránea
            $table->dropColumn('ultimo_editor_id');
        });
    }
};
