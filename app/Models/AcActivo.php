<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcActivo extends Model
{
    use HasFactory;
    protected $table = 'ac_activos';
    protected $fillable = ['nombre', 'imei', 'codigo_barras', 'especificaciones', 'observaciones', 'valor','empleado_id', 'ac_activo_estado_id', 'ac_categoria_id', 'ac_activo_estado_id'];

    public function empleado(){
        return $this->belongsTo(Empleado::class,'empleado_id');
    }

    public function estado(){
        return $this->belongsTo(AcActivoEstado::class, 'ac_activo_estado_id');
    }

    public function categoria(){
        return $this->belongsTo(AcCategoria::class, 'ac_categoria_id');
    }

    public function items(){
        return $this->hasMany(AcItem::class);
    }



}
