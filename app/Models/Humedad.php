<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Humedad extends Model
{
    use HasFactory;

    protected $table = 'humedad';

    protected $fillable = [
        'codigo',
        'estado_mineral_id',
        'cliente_id',
        'fecha_recepcion',
        'fecha_emision',
        'periodo_inicio',
        'periodo_fin',
        'humedad',
        'observaciones',
    ];

    // ✅ IMPORTANTE: para que las fechas sean Carbon y puedas usar ->format('Y-m-d')
    protected $casts = [
        'fecha_recepcion' => 'date',
        'fecha_emision'   => 'date',
        'periodo_inicio'  => 'date',
        'periodo_fin'     => 'date',
        'humedad'         => 'decimal:2',
    ];

    public function mineral()
    {
        return $this->belongsTo(EstadoMineral::class, 'estado_mineral_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Relación a la tabla detalle (humedad_peso) donde guardas nro_salida + origen
    public function pesos()
    {
        return $this->hasMany(HumedadPeso::class, 'humedad_id');
    }
}
