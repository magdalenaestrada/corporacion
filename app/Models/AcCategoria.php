<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcCategoria extends Model
{
    use HasFactory;

    protected $table = 'ac_categorias';
    protected $fillable = ['nombre', 'codigo','categoria_padre_id'];

    public function categoria_padre(){
        return $this->belongsTo(AcCategoria::class, 'categoria_padre_id');
    }

    public function categorias_hijas(){
        return $this->hasMany(AcCategoria::class, 'categoria_padre_id');
    }
}
