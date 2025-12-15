<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resumen extends Model
    {
        protected $fillable = [
            'fecha_resumen', 'cliente_id', 'factura', 'total',
        ];
    
        public function adelantos()
        {
            return $this->belongsToMany(Adelanto::class, 'adelanto_resumen');
        }
        public function cliente()
        {
            return $this->belongsTo(Cliente::class, 'cliente_id');
        }
        public function liquidaciones()
    {
        return $this->belongsToMany(Liquidacion::class,  'resumen_id');
    }
        public function user()
        {
            return $this->belongsTo(User::class, 'usuario_id');
        }
        
    }
