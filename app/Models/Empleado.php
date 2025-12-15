<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';
    protected $fillable = ['documento','nombre', 'telefono', 'sueldo', 'jefe_id', 'posicion_id', 'area_id'];

    public function area(){
        return $this->belongsTo(Area::class, 'area_id');
    }
    public function posicion(){
        return $this->belongsTo(Posicion::class, 'posicion_id');
    }

    public function jefe(){
        return $this->belongsTo(Empleado::class, 'jefe_id');
    }
}
