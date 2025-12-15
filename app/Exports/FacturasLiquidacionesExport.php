<?php

namespace App\Exports;

use App\Models\FacturaLiquidacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FacturasLiquidacionesExport implements FromCollection, WithHeadings
{
    /**
     * Retorna los datos de las facturas a exportar.
     */
    public function collection()
    {
        return FacturaLiquidacion::with('liquidacion.cliente')->get()->map(function ($factura) {
            return [
                'ID' => $factura->id,
                'Liquidación ID' => $factura->liquidacion_id,
                'RUC' => optional($factura->liquidacion->cliente)->documento_cliente ?? 'Sin Cliente',
                'Cliente' => optional($factura->liquidacion->cliente)->datos_cliente ?? 'N/A',
                'Número de Factura' => $factura->factura_numero,
                'Monto' => number_format($factura->monto, 2),
                'Creado' => $factura->created_at,
                'Actualizado' => $factura->updated_at,
            ];
        });
    }

    /**
     * Definir los encabezados de la hoja de Excel.
     */
    public function headings(): array
    {
        return [
            'ID',
            'Liquidación ID',
            'RUC',
            'Cliente',
            'Número de Factura',
            'Monto',
            'Creado',
            'Actualizado'
        ];
    }
}
