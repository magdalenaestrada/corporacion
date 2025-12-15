<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recepcion extends Model
{
    use HasFactory;
    protected $table = 'recepciones';

    protected $fillable = [
        'retiro_id', 'bruto_recep', 'tara_recep', 'neto_recep', 'diferencia',
        'codigo_lote', 'fecha_recepcion', 'salida', 'referencia', 'custodio', 'observaciones'
    ];

    // Relación con Retiro

    public function retiro()
{
    return $this->belongsTo(Retiro::class, 'retiro_id'); // Asegura que 'retiro_id' es la clave foránea correcta
}
}
