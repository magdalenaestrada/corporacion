<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class DespachosExport implements FromArray, WithHeadings, WithMapping, WithStyles
{
    protected $despachos;
    protected $rows = [];
    protected $resumen = [];

    public function __construct($despachos)
    {
        $this->despachos = $despachos;
    }

    public function array(): array
    {
        $totalDespachos = 0;
        $pesoTotal = 0;

        foreach ($this->despachos as $despacho) {
            $this->rows[] = [
                'Despacho',
                $despacho->id,
                $despacho->blending->cod,
                $despacho->totalTMH,
                $despacho->masomenos,
                $despacho->fecha,
                $despacho->destino,
                $despacho->deposito,
                $despacho->observacion,
                '', '', '', '', '', '', '', '', '', '', '', ''
            ];
        
            foreach ($despacho->retiros as $retiro) {
                $this->rows[] = [
                    '→ Retiro',
                    '', '', '', '', '', '', '', '',
                    $retiro->nro_salida,
                    $retiro->precinto,
                    $retiro->guia,
                    $retiro->bruto,
                    $retiro->tara,
                    $retiro->neto,
                    $retiro->tracto,
                    $retiro->carreta,
                    $retiro->guia_transporte,
                    $retiro->ruc_empresa,
                    $retiro->razon_social,
                    $retiro->licencia,
                    $retiro->conductor
                ];
            }
        }

        $this->resumen[] = array_merge(["Total Despachos: $totalDespachos"], array_fill(0, 21, ''));
        $this->resumen[] = array_merge(["Peso Total TMH: " . number_format($pesoTotal, 3)], array_fill(0, 21, ''));

        return array_merge($this->resumen, [$this->headings()], $this->rows);
    }

    public function headings(): array
    {
        return [
            'Tipo',
            'ID Despacho',
            'Blending',
            'TMH',
            'Masomenos',
            'Fecha',
            'Destino',
            'Deposito',
            'Observacion',
            'Nro Salida',
            'Precinto',
            'Guía',
            'Bruto',
            'Tara',
            'Neto',
            'Tracto',
            'Carreta',
            'Guía Transporte',
            'RUC Empresa',
            'Razón Social',
            'Licencia',
            'Conductor'
        ];
    }

    public function map($row): array
    {
        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        $resumenRows = count($this->resumen); // 2
        $headerRow = $resumenRows + 1;
        $dataStartRow = $headerRow + 1;
        $dataEndRow = $dataStartRow + count($this->rows) - 1;

        // Resumen
        $sheet->mergeCells("A1:V1");
        $sheet->mergeCells("A2:V2");
        
        $sheet->getStyle("A{$headerRow}:V{$headerRow}")->applyFromArray([ // encabezado
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4a5568']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);
        
        $sheet->getStyle("A{$dataStartRow}:V{$dataEndRow}")->applyFromArray([ // datos
            'alignment' => ['vertical' => 'center', 'horizontal' => 'center'],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        // Datos
        $sheet->getStyle("A{$dataStartRow}:P{$dataEndRow}")->applyFromArray([
            'alignment' => ['vertical' => 'center', 'horizontal' => 'center'],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        // Colorear filas por tipo
        for ($i = $dataStartRow; $i <= $dataEndRow; $i++) {
            $tipo = $sheet->getCell("A{$i}")->getValue();
        
            if ($tipo === 'Despacho') {
                $sheet->getStyle("A{$i}:V{$i}")->getFill()
                      ->setFillType(Fill::FILL_SOLID)
                      ->getStartColor()->setRGB('e6f7ff'); // azul claro
            } elseif ($tipo === '→ Retiro') {
                $sheet->getStyle("A{$i}:V{$i}")->getFill()
                      ->setFillType(Fill::FILL_SOLID)
                      ->getStartColor()->setRGB('fffde7'); // amarillo suave
            }
        }
        
        foreach (range('A', 'V') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->freezePane("A4");

        return [];
    }
}
