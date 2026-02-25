<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HumedadPeso extends Model
{
    protected $table = 'humedad_pesos'; // tu tabla pivot

    protected $fillable = [
        'humedad_id',
        'origen',
        'nro_salida',
        'neto',
    ];

    public function humedad()
    {
        return $this->belongsTo(Humedad::class, 'humedad_id');
    }
}
