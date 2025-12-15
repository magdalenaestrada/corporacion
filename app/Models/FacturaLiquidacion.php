<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaLiquidacion extends Model
{
    use HasFactory;

    protected $table = 'facturas_liquidaciones'; 

    protected $fillable = [
        'liquidacion_id',
        'factura_numero',
        'monto',
    ];


    public function liquidacion() {
        return $this->belongsTo(Liquidacion::class);
    }
}
