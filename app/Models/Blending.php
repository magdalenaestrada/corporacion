<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blending extends Model
{
    use HasFactory;

    protected $fillable = ['cod', 'lista', 'pesoblending', 'notas', 'user_id'];

    public function ingresos()
    {
        return $this->belongsToMany(Ingreso::class, 'blending_ingreso', 'blending_id', 'ingreso_id');
    }

    public function despachos()
    {
        return $this->hasMany(Despacho::class, 'blending_id');
    }

    public function despacho()
    {
        return $this->hasOne(Despacho::class, 'blending_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
