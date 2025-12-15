<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    use HasFactory;
    protected $table = 'ingresos';
    protected $fillable = [
        'estado',
        'ref_lote',
        'identificador',
        'nom_iden',
        'peso_total',
        'placa',
        'procedencia',
        'deposito',
        'balanza',
        'tolva',
        'guia_transporte',
        'guia_remision',
        'muestreo',
        'preparacion',
        'req_analisis',
        'req_analisis1',
        'fecha_salida',
        'retiro',
        'NroSalida',
        'descripcion',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    //public function blendings()
//{
  //  return $this->belongsToMany(Blending::class, 'blending_ingreso'); // Asegúrate de que el nombre de la tabla pivot sea correcto
//}
//public function liquidaciones()
//{
//    return $this->hasMany(Liquidacion::class, 'NroSalida', 'NroSalida');
//}

//public function despachos()
//{
   // return $this->hasMany(Despacho::class, 'NroSalida', 'NroSalida');
//}
public function liquidaciones()
    {
        return $this->hasMany(Liquidacion::class, 'NroSalida', 'NroSalida');
    }

    public function blendings()
    {
        return $this->belongsToMany(Blending::class, 'blending_ingreso', 'ingreso_id', 'blending_id');
    }

    public function despachos()
{
    return $this->hasManyThrough(
        Despacho::class,
        Blending::class,
        'id',           // Clave primaria en `blendings`
        'blending_id',  // Clave foránea en `despachos`
        'id',           // Clave en `ingresos`
        'id'            // Clave en `blendings`
    );
}
    public function retiros()
    {
        return $this->hasManyThrough(
            Retiro::class,
            Despacho::class,
            'blending_id',  // Clave en `despachos` que referencia a `blendings`
            'despacho_id',  // Clave en `retiros` que referencia a `despachos`
            'id',           // Clave en `ingresos`
            'id'            // Clave en `despachos`
        );
    }
}