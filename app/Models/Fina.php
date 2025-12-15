<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fina extends Model
{
    use HasFactory;

    
    protected $table = 'finas';

    protected $fillable = [
        'codigoBlending',
        'total_tmh',
        'porcentaje_h2o',
        'total_tms',
        'au_promedio',
        'ag_promedio',
        'cu_promedio',
        'as_promedio',
        'as_promedio',
        'sb_promedio',
        'pb_promedio',
        'zn_promedio',
        'bi_promedio',
        'hg_promedio',
        'total_valor_lote',
        'total_liquidacion',
    ];

    public function liquidaciones()
    {
        return $this->hasMany(Liquidacion::class);
    }
}
