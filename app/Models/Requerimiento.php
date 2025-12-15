<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requerimiento extends Model
{
    use HasFactory;
    protected $table = 'requerimientos';

    public function cliente()
    {
        return $this->belongsTo(Cliente::class); // Relación inversa
    }
        public function liquidaciones()
    {
        return $this->hasMany(Liquidacion::class);
    }
}
