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
        $table->decimal('pendientes', 10, 2)->nullable()->after('otros_descuentos');
    });
}

public function down(): void
{
    Schema::table('liquidaciones', function (Blueprint $table) {
        $table->dropColumn('pendientes');
    });
}
};
