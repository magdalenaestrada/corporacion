<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
  //  protected $fillable = ['documento_cliente', 'datos_cliente', 'ruc_empresa', 'razon_social', 'direccion', 'telefono','producto'];
    public function liquidaciones()
    {
        return $this->hasMany(Liquidacion::class);
    }
    public function requerimientos()
    {
        return $this->hasOne(Requerimiento::class, 'cliente_id'); // 'cliente_id' es la llave foránea en la tabla 'requerimientos'
    }
    public function adelantos()
    {
        return $this->hasMany(Adelanto::class, 'cliente_id');
    }
}