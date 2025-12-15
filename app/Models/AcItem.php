<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcItem extends Model
{
    use HasFactory;

    protected $table = 'ac_items';

    protected $fillable = ['nombre', 'observacion', 'ac_activo_id'];
}
