<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liquidacion extends Model
{
    use HasFactory;
    protected $table = 'liquidaciones';
    protected $fillable = [
        'muestra_id', 'cliente_id', 'resumen_id', 'peso', 'lote', 'producto', 
        'cotizacion_au', 'cotizacion_ag', 'cotizacion_cu', 'tms', 'tmns',
        'ley_au', 'formula_au', 'precio_au', 'val_au', 'ley_ag', 'formula_ag', 
        'precio_ag', 'val_ag', 'ley_cu', 'formula_cu', 'precio_cu', 'val_cu', 
        'total_valores', 'formula_fi_au', 'fina_au', 'formula_fi_ag', 'fina_ag', 
        'formula_fi_cu', 'fina_cu', 'total_deducciones', 'total_as', 'total_sb', 
        'total_pb', 'total_bi', 'total_hg', 'total_s', 'total_penalidades', 
        'total_us', 'valorporlote', 'valor_igv', 'total_porcentajeliqui', 'saldo', 
        'detraccion', 'total_liquidacion', 'total','procesoplanta','adelantosextras','prestamos',
        'otros_descuentos','usuario_id','transporte','comentario','division','estado','resultadoestibadores','resultadomolienda','dolar','proteccion_au2',
        'proteccion_ag2',
        'proteccion_cu2',
        'pagable_au2',
        'pagable_ag2',
        'pagable_cu2',
        'deduccion_au2',
        'deduccion_ag2',
        'deduccion_cu2',
        'refinamiento_au2',
        'refinamiento_ag2',
        'refinamiento_cu2',
        'maquila2',
        'analisis2',
        'estibadores2',
        'molienda2',
        'igv2',
        'penalidad_as2',
        'penalidad_sb2',
        'penalidad_pb2',
        'penalidad_zn2',
        'penalidad_bi2',
        'penalidad_hg2',
        'penalidad_s2',
        'penalidad_h2o2',
        'merma2',
        'ultimo_editor_id',
        'NroSalida',
        'fina_id',
        'fechai',
        'pendientes',
        
    ];
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function requerimientos()
    {
        return $this->hasMany(Requerimiento::class, 'cliente_id', 'id');
    }
    
    public function muestra()
    {
        return $this->belongsTo(Muestra::class, 'muestra_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
     public function resumen()
    {
        return $this->belongsTo(Resumen::class, 'resumen_id');
    }
    public function updated_by_user()
    {
        return $this->belongsTo(User::class, 'updated_by'); // Asegúrate de tener la relación correcta
    }
    // En el modelo Liquidacion
    public function creator()
    {
        return $this->belongsTo(User::class, 'usuario_id'); // Creador
    }
        public function lastEditor()
{
    return $this->belongsTo(User::class, 'ultimo_editor_id'); // Último editor
}
public function fina()
{
    return $this->belongsTo(Fina::class);
}
public function facturas() {
    return $this->hasMany(FacturaLiquidacion::class, 'liquidacion_id');
}
public function retiro()
{
    return $this->hasOne(Retiro::class, 'nro_salida', 'NroSalida');
}
public function ingreso()
{
    return $this->belongsTo(Ingreso::class, 'NroSalida', 'NroSalida');
}

}
