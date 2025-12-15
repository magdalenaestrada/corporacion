<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Liquidacion;
use Illuminate\Support\Str;

class LiquidacionPolicy
{
    public function update(User $user, Liquidacion $liquidacion): bool
    {
        // ✅ SUPER ADMIN siempre puede (ajustado al nombre real del rol)
        if (method_exists($user, 'hasRole') && $user->hasRole('super-admin')) {
            return true;
        }

        // ✅ Permiso extra si usas spatie
        if (method_exists($user, 'can') && $user->can('liquidaciones.edit.any')) {
            return true;
        }

        // Normalizar estado
        $estado = is_null($liquidacion->estado)
            ? null
            : Str::upper(trim((string) $liquidacion->estado));

        // CIERRE → cualquiera puede editar
        if ($estado === 'CIERRE') {
            return true;
        }

        // PROVISIONAL o NULL → solo el creador
        $esCreador = ($liquidacion->usuario_id === $user->id);
        if (is_null($estado) || $estado === '' || $estado === 'PROVISIONAL') {
            return $esCreador;
        }

        // Otros estados → no permitido
        return false;
    }
}
