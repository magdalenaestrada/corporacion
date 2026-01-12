<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosMineralSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            'CONCENTRADO',
            'BLENDING',
            'POLVEADO',
            'MOLIDO',
            'FALCON',
            'CHANCADO',
            'LLAMPO',
            'RELAVE',
            'MARTILLADO',
            'GRANEL',
            'SOBRANTE',
        ];

        foreach ($estados as $estado) {
            DB::table('estados_mineral')->updateOrInsert(
                ['nombre' => $estado],
                ['activo' => true, 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
