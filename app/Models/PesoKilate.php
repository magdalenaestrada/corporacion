<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesoKilate extends Model
{
    protected $table = 'pesos_kilate';

    protected $primaryKey = 'NroSalida';
    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = false;
}
