<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlendingIngreso extends Model
{
    protected $table = 'blending_ingreso'; // Solo si el nombre no sigue la convención de Laravel

    protected $fillable = [
        'blending_id',
        'ingreso_id',
    ];
}
