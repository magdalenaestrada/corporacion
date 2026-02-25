<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peso extends Model
{
    protected $table = 'pesos';

    // ✅ CLAVE PRIMARIA REAL
    protected $primaryKey = 'NroSalida';
    public $incrementing = true;
    protected $keyType = 'int';

    // ❌ tu tabla no tiene timestamps
    public $timestamps = false;

    protected $fillable = [
        'Horas',
        'Fechas',
        'Fechai',
        'Horai',
        'Pesoi',
        'Pesos',
        'Bruto',
        'Tara',
        'Neto',
        'Placa',
        'Observacion',
        'Producto',
        'Conductor',
        'Transportista',
        'RazonSocial',
        'Operadori',
        'Destarado',
        'Operadors',
        'carreta',
        'guia',
        'guiat',
        'pedido',
        'entrega',
        'um',
        'pesoguia',
        'rucr',
        'ruct',
        'destino',
        'origen',
        'brevete',
        'pbmax',
        'tipo',
        'centro',
        'nia',
        'bodega',
        'ip',
        'anular',
        'eje',
        'pesaje'
    ];
}
