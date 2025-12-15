<?php

namespace App\Exports;

use App\Models\Ingreso;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Events\AfterSheet;

class IngresosExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
{
    protected $ingresos;
    protected $pesoTotal;

    public function __construct($ingresos)
    {
        $this->ingresos = $ingresos;
        $this->pesoTotal = $ingresos->sum('peso_total');
    }

    public function collection(): Collection
    {
        return $this->ingresos;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Código',
            'Fecha Ingreso',
            'Identificador',
            'Nombre Ident.',
            'Ref. Lote',
            'Peso Total',
            'Estado',
            'NroSalida',
            'Procedencia',
            'Deposito',
            'Balanza',
            'Placa',
            'Tolva',
            'Guía Transporte',
            'Guía Remisión',
            'Muestreo',
            'Preparación',
            'Req. Nasca',
            'Req. Perú',
            'Descuento',
            'Fecha Salida',
            'Retiro',
            'Peso Externo',
            'Lote',
            'Descripción',
            'Fase',
            'Usuario',
            'Creado',
            'Actualizado'
        ];
    }

    public function map($ingreso): array
    {
        return [
            $ingreso->id,
            $ingreso->codigo,
            $ingreso->fecha_ingreso,
            $ingreso->identificador,
            $ingreso->nom_iden,
            $ingreso->ref_lote,
            $ingreso->peso_total,
            $ingreso->estado,
            $ingreso->NroSalida,
            $ingreso->procedencia,
            $ingreso->deposito,
            $ingreso->balanza,
            $ingreso->placa,
            $ingreso->tolva,
            $ingreso->guia_transporte,
            $ingreso->guia_remision,
            $ingreso->muestreo,
            $ingreso->preparacion,
            $ingreso->req_analisis,
            $ingreso->req_analisis1,
            $ingreso->descuento,
            $ingreso->fecha_salida,
            $ingreso->retiro,
            $ingreso->pesoexterno,
            $ingreso->lote,
            $ingreso->descripcion,
            $ingreso->fase,
            $ingreso->user->name ?? 'Desconocido',
            $ingreso->created_at,
            $ingreso->updated_at,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // encabezado
        $sheet->getStyle('A3:AD3')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4a5568']],
            'alignment' => ['horizontal' => 'center'],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Mover encabezados a fila 3, y escribir resumen en 1 y 2
                $sheet->insertNewRowBefore(1, 2);
                $sheet->mergeCells('A1:AD1');
                $sheet->mergeCells('A2:AD2');
                $sheet->setCellValue('A1', 'Total de registros: ' . count($this->ingresos));
                $sheet->setCellValue('A2', 'Peso total filtrado: ' . number_format($this->pesoTotal, 3));

                $sheet->getStyle('A1:A2')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 13],
                    'alignment' => ['horizontal' => 'center'],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'dbeafe']],
                ]);

                $start = 4;
                $end = $start + count($this->ingresos) - 1;

                // Bordes y centrado de datos
                $sheet->getStyle("A{$start}:AD{$end}")->applyFromArray([
                    'font' => [
                        'color' => ['rgb' => '000000'],
                        'bold' => false // ← aquí quitamos la negrita
                    ],
                    'alignment' => ['horizontal' => 'center'],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);

                // Colorear según fase
                for ($i = $start; $i <= $end; $i++) {
                    $fase = strtolower($sheet->getCell("AA{$i}")->getValue());

                    $color = match($fase) {
                        'ingresado'  => 'c3e6cb',
                        'blending'   => 'fff3cd',
                        'despachado' => 'f8d7da',
                        'retirado'   => 'dee2e6',
                        default      => null,
                    };

                    if ($color) {
                        $sheet->getStyle("A{$i}:AD{$i}")->getFill()
                              ->setFillType(Fill::FILL_SOLID)
                              ->getStartColor()->setRGB($color);
                    }
                }

                // Auto ancho columnas
                foreach (range('A', 'AD') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
