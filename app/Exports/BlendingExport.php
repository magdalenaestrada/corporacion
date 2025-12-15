<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class BlendingExport implements FromArray, WithHeadings, WithMapping, WithStyles
{
    protected $blendings;
    protected $rows = [];
    protected $resumen = [];

    public function __construct($blendings)
    {
        $this->blendings = $blendings;
    }

    public function array(): array
    {
        $totalBlendings = 0;
        $pesoTotal = 0;

        foreach ($this->blendings as $blending) {
            // Si el campo tiene comas, las eliminamos para la suma
            $peso = floatval(str_replace(',', '', $blending->pesoblending));
            $this->rows[] = [
                'Blending',
                $blending->id,
                $blending->cod,
                $blending->lista,
                $blending->notas,
                $blending->estado,
                $blending->user->name ?? 'N/A',
                $blending->created_at,
                number_format($peso, 3),
                '', '', '', '', '', ''
            ];

            $totalBlendings++;
            $pesoTotal += $peso;

            foreach ($blending->ingresos as $ingreso) {
                $this->rows[] = [
                    '→ Ingreso',
                    '', '', '', '', '', '', '', '',
                    $ingreso->NroSalida,
                    $ingreso->identificador,
                    $ingreso->nom_iden,
                    $ingreso->ref_lote,
                    $ingreso->procedencia,
                    number_format($ingreso->peso_total, 3),
                ];
            }
        }

        // Aseguramos que el resumen tenga 15 columnas (para 15 encabezados)
        $this->resumen[] = array_merge(["Total de blendings: $totalBlendings"], array_fill(0, 14, ''));
        $this->resumen[] = array_merge(["Peso Total Filtrado: " . number_format($pesoTotal, 3)], array_fill(0, 14, ''));

        return array_merge($this->resumen, [$this->headings()], $this->rows);
    }

    public function headings(): array
    {
        return [
            'Tipo',
            'ID',
            'Código',
            'Lista',
            'Notas',
            'Estado',
            'Usuario',
            'Fecha Creación',
            'Peso Blending',
            'Ticket',
            'RUC',
            'Razón Social',
            'Lote',
            'Procedencia',
            'Peso Ingreso'
        ];
    }

    public function map($row): array
    {
        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        $resumenRows = count($this->resumen); // 2
        $headerRow = $resumenRows + 1;        // 3
        $dataStartRow = $headerRow + 1;       // 4
        $dataEndRow = $dataStartRow + count($this->rows) - 1;

        // Estilo resumen (filas 1 y 2)
        $sheet->mergeCells("A1:O1");
        $sheet->mergeCells("A2:O2");
        $sheet->getStyle("A1:A2")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => 'center'],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1e3a8a']
            ]
        ]);

        // Encabezado (fila 3)
        $sheet->getStyle("A{$headerRow}:O{$headerRow}")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4a5568']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        // Estilo general para celdas de datos
        $sheet->getStyle("A{$dataStartRow}:O{$dataEndRow}")->applyFromArray([
            'font' => ['bold' => false, 'color' => ['rgb' => '000000']],
            'alignment' => ['vertical' => 'center', 'horizontal' => 'center'],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);

        // Colorear filas según tipo, lista y estado
        for ($i = $dataStartRow; $i <= $dataEndRow; $i++) {
            $tipo   = $sheet->getCell("A{$i}")->getValue();
            $lista  = strtolower($sheet->getCell("D{$i}")->getValue());
            $estado = strtolower($sheet->getCell("F{$i}")->getValue());

            // Tipo: Blending vs Ingreso
            if ($tipo === 'Blending') {
                $sheet->getStyle("A{$i}:O{$i}")
                      ->getFill()->setFillType(Fill::FILL_SOLID)
                      ->getStartColor()->setRGB('dbeafe'); // Azul suave
            } elseif ($tipo === '→ Ingreso') {
                $sheet->getStyle("A{$i}:O{$i}")
                      ->getFill()->setFillType(Fill::FILL_SOLID)
                      ->getStartColor()->setRGB('e0f7fa'); // Celeste suave
            }

            // Lista: oro, plata, cobre
            if ($lista === 'oro') {
                $sheet->getStyle("D{$i}")->getFill()->setFillType(Fill::FILL_SOLID)
                      ->getStartColor()->setRGB('fffacc'); // Amarillo claro
            } elseif ($lista === 'plata') {
                $sheet->getStyle("D{$i}")->getFill()->setFillType(Fill::FILL_SOLID)
                      ->getStartColor()->setRGB('d0f0ff'); // Celeste
            } elseif ($lista === 'cobre') {
                $sheet->getStyle("D{$i}")->getFill()->setFillType(Fill::FILL_SOLID)
                      ->getStartColor()->setRGB('d4f4d1'); // Verde claro
            }

            // Estado: activo/inactivo
            if ($estado === 'activo') {
                $sheet->getStyle("F{$i}")->getFont()->getColor()->setRGB('28a745'); // Verde
            } elseif ($estado === 'inactivo') {
                $sheet->getStyle("F{$i}")->getFont()->getColor()->setRGB('dc3545'); // Rojo
            }
        }

        // Ajustar ancho de columnas automáticamente
        foreach (range('A', 'O') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Congelar encabezado (filas resumen + encabezado)
        $sheet->freezePane("A4");

        return [];
    }
}
