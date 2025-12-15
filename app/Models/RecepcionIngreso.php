<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecepcionIngreso extends Model
{
    protected $table = 'recepciones_ingreso';

    protected $fillable = [
        'nro_salida',
        'nro_ruc','documento_ruc',
        'documento_encargado','datos_encargado','domicilio_encargado',
        'dni_conductor','datos_conductor',
        'observacion','extras',
        'creado_por', // <- importante
    ];

    protected $casts = [
        'extras'     => 'array',
        'creado_por' => 'integer',
    ];

    public function creador()
    {
        return $this->belongsTo(\App\Models\User::class, 'creado_por');
    }
    public function usuario()
        {
            // columna FK = creado_por -> users.id
            return $this->belongsTo(User::class, 'creado_por');
        }
    // (Opcional) si tienes tabla pesos y quieres relacionar por nro_salida:
    // public function peso()
    // {
    //     return $this->belongsTo(\App\Models\Peso::class, 'nro_salida', 'nrosalida');
    // }
}
