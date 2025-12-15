<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despacho extends Model
{
    use HasFactory;


    protected $fillable = [
        'blending_id',
        'totalTMH',
        'masomenos',
        'fecha',
        'observacion',
        'codigo',
        'deposito',
        'destino',
    ];

    //public function blending()
   // {
   //     return $this->belongsTo(Blending::class);
   // }
    //public function retiros()
    //{
        
    //    return $this->hasMany(Retiro::class);
   // }

   public function blending()
    {
        return $this->belongsTo(Blending::class, 'blending_id');
    }

    public function retiros()
    {
        return $this->hasMany(Retiro::class, 'despacho_id');
    }
 

}
