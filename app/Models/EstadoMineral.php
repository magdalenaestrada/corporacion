<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoMineral extends Model
{
    protected $table = 'estados_mineral';

    protected $fillable = [
        'nombre',
        'activo',
    ];
}