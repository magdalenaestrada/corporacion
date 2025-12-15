<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retiro extends Model
{
    protected $table = 'retiros';
    protected $fillable = [
        'despacho_id', 'nro_salida', 'precinto', 'guia', 'bruto', 'tara', 'neto', 'tracto',
        'carreta', 'guia_transporte', 'ruc_empresa', 'razon_social', 'licencia', 'conductor'
    ];
    //public function despachos()
    //{
    //    return $this->belongsTo(Despacho::class);
   // }

   public function despacho()
    {
        return $this->belongsTo(Despacho::class, 'despacho_id');
    }


    public function recepcion()
    {
        return $this->hasOne(Recepcion::class, 'retiro_id');
    }
    public function liquidacion()
    {
        return $this->belongsTo(Liquidacion::class, 'nro_salida', 'NroSalida');
    }
}
