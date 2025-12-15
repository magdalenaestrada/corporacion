<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $table = 'log';
    protected $fillable = ['fila_afectada', 'dato_importante','tipo_log_id'];
}
