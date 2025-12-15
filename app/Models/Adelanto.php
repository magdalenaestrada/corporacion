<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adelanto extends Model
{
    use HasFactory;
    protected $table = 'adelantos';
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    public function resumens()
    {
        return $this->belongsToMany(Resumen::class, 'adelanto_resumen');
    }
    
}
