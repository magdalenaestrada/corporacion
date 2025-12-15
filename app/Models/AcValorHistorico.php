<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcValorHistorico extends Model
{
    use HasFactory;
    
    protected $table = 'ac_valores_historicos';

    protected $fillable = ['valor', 'ac_activo_id'];
}
