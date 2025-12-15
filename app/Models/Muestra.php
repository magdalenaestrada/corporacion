<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Muestra extends Model
{
    protected $table = 'muestras';
    protected $fillable = [
        'codigo',
        'au',
        'ag',
        'cu',
        'as',
        'sb',
        'pb',
        'zn',
        'bi',
        'hg',
        's',
        'humedad',
        'obs',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function liquidaciones()
    {
        return $this->belongsToMany(Liquidacion::class,  'muestra_id');
    }
}