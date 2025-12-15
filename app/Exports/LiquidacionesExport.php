<?php

namespace App\Exports;

use App\Models\Liquidacion;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;

class LiquidacionesExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $r = $this->request;

        $query = Liquidacion::with(['muestra', 'cliente', 'creator', 'lastEditor', 'ingreso.blendings'])
        ->orderByDesc('created_at');

        switch ($r->relacion) {
            case 'soloCierres':
                $query->where('estado', 'CIERRE');
                break;

            case 'provisionalesConCierre':
                $query->where('estado', 'PROVISIONAL')->whereHas('ingreso', function ($q) {
                    $q->whereHas('blendings');
                });
                break;

            case 'provisionalesSinCierre':
                $query->where('estado', 'PROVISIONAL');
                break;

            case 'cierresYProvisionales':
                $query->where(function ($q) {
                    $q->where('estado', 'CIERRE')
                      ->orWhere('estado', 'PROVISIONAL');
                });
                break;

            case 'cierresYSinCierre':
                $nroConCierre = Liquidacion::where('estado', 'CIERRE')
                    ->pluck('NroSalida')
                    ->filter()
                    ->unique()
                    ->toArray();

                $query->where(function ($q) use ($nroConCierre) {
                    $q->where('estado', 'CIERRE')
                      ->orWhere(function ($sub) use ($nroConCierre) {
                          $sub->where(function ($s) {
                              $s->whereNull('estado')
                                ->orWhere('estado', 'PROVISIONAL');
                          })->whereNotIn('NroSalida', $nroConCierre);
                      });
                });
                break;
        }

        if ($r->filled('codBlending')) {
            $query->whereHas('ingreso.blendings', function ($q) use ($r) {
                $q->whereRaw('LOWER(cod) LIKE ?', ['%' . strtolower($r->codBlending) . '%']);
            });
        }

        if ($r->filled('blendingSelect')) {
            $query->whereHas('ingreso.blendings', function ($q) use ($r) {
                $q->whereRaw('LOWER(cod) LIKE ?', ['%' . strtolower($r->blendingSelect) . '%']);
            });
        }

        if ($r->filled('nroSalida')) {
            $query->whereRaw('LOWER("NroSalida") LIKE ?', ['%' . strtolower($r->nroSalida) . '%']);
        }

        if ($r->filled('busqueda')) {
            $busqueda = strtolower($r->busqueda);
            $query->where(function ($q) use ($busqueda) {
                $q->whereRaw('LOWER(lote) LIKE ?', ["%$busqueda%"])
                  ->orWhereHas('cliente', fn($q) => $q->whereRaw('LOWER(datos_cliente) LIKE ?', ["%$busqueda%"]));
            });
        }

       if ($r->filled('rangoFechas')) {
    $fechas = explode(' a ', trim($r->rangoFechas));

    // Caso 3: "YYYY-MM" (mes completo) — opcional si decides enviar así
    if (count($fechas) === 1 && preg_match('/^\d{4}-\d{2}$/', $fechas[0])) {
        $ini = Carbon::createFromFormat('Y-m', $fechas[0])->startOfMonth();
        $fin = Carbon::createFromFormat('Y-m', $fechas[0])->endOfMonth();
        $query->whereBetween('created_at', [$ini, $fin]);
    }
    // Caso 1: una fecha -> día completo
    elseif (count($fechas) === 1 && preg_match('/^\d{4}-\d{2}-\d{2}$/', $fechas[0])) {
        $ini = Carbon::parse($fechas[0])->startOfDay();
        $fin = Carbon::parse($fechas[0])->endOfDay();
        $query->whereBetween('created_at', [$ini, $fin]);
    }
    // Caso 2: dos fechas -> rango [inicio 00:00:00, fin 23:59:59]
    elseif (count($fechas) === 2) {
        $ini = Carbon::parse($fechas[0])->startOfDay();
        $fin = Carbon::parse($fechas[1])->endOfDay();
        $query->whereBetween('created_at', [$ini, $fin]);
    }
}

        return $query->get()->map(function ($l) {
    // Evita "Attempt to read property..." cuando ingreso o blendings no existen
    $codBlending = $l->ingreso?->blendings?->first()?->cod ?? '-';
    $fase        = $l->ingreso?->fase ?? '-';

    return [
        $l->created_at,
        $l->id,
        $l->cliente->datos_cliente ?? '-',
        $l->lote,
        $l->NroSalida,
        $l->producto,
        $l->muestra->codigo ?? '-',
        $l->creator->name ?? '-',
        $l->lastEditor->name ?? '-',
        $l->estado ?? '-',
        $l->peso,
        $l->muestra->humedad ?? 0,
        $l->tms,
        $l->merma2,
        $l->tmns,
        $l->muestra->cu ?? 0,
        $l->muestra->ag ?? 0,
        $l->muestra->au ?? 0,
        $l->cotizacion_cu,
        $l->cotizacion_ag,
        $l->cotizacion_au,
        $l->ley_cu,
        $l->pagable_cu2,
        $l->deduccion_cu2,
        $l->formula_cu,
        $l->precio_cu,
        $l->val_cu,
        $l->ley_ag,
        $l->pagable_ag2,
        $l->deduccion_ag2,
        $l->formula_ag,
        $l->precio_ag,
        $l->val_ag,
        $l->ley_au,
        $l->pagable_au2,
        $l->deduccion_au2,
        $l->formula_au,
        $l->precio_au,
        $l->val_au,
        $l->total_valores,
        $l->fina_cu,
        $l->fina_ag,
        $l->fina_au,
        $l->maquila2,
        $l->division,
        $l->resultadoestibadores,
        $l->resultadomolienda,
        $l->transporte,
        $l->total_deducciones,
        $l->total_as,
        $l->total_sb,
        $l->total_bi,
        $l->total_pb,
        $l->total_hg,
        $l->total_s,
        $l->total_penalidades,
        $l->total_us,
        $l->valorporlote,
        $l->valor_igv,
        $l->total_porcentajeliqui,
        $l->adelantos,
        $l->saldo,
        $l->detraccion,
        $l->total_liquidacion,
        $l->procesoplanta,
        $l->adelantosextras,
        $l->prestamos,
        $l->otrosdescuentos,
        $l->total,
        $codBlending, // antes: $l->ingreso->blendings->first()->cod ?? '-'
        $fase         // antes: $l->ingreso->fase ?? '-'
    ];
});
     
    }

    public function headings(): array
    {
        return [
            'FECHA', 'ID', 'CLIENTE', 'LOTE', 'NRO TICKET', 'PRODUCTO', 'MUESTRA', 'CREADOR', 'CIERRE', 'ESTADO',
            'TMH', 'HUMEDAD', 'TMS', 'MERMA', 'TMNS',
            'CU', 'AG', 'AU',
            'COT. CU', 'COT. AG', 'COT. AU',
            'LEY. CU', 'PAG. CU', 'DED. CU', 'FORM. CU', 'PRECIO. CU', 'US$/TM CU',
            'LEY. AG', 'PAG. AG', 'DED. AG', 'FORM. AG', 'PRECIO. AG', 'US$/TM AG',
            'LEY. AU', 'PAG. AU', 'DED. AU', 'FORM. AU', 'PRECIO. AU', 'US$/TM AU', 'TOTAL PAGABLE / TM',
            'REF. CU', 'REF. AG', 'REF. AU', 'MAQUILA', 'ANALISIS', 'ESTIBADORES', 'MOLIENDA', 'TRANSPORTE', 'TOTAL DEDUCCION',
            'As', 'Sb', 'Bi', 'Pb+Zn', 'Hg', 'H2O', 'TOTAL PENALIDADES',
            'Total US$/TM', 'Valor Lote US$', 'IGV', 'Total Liquidacion %', 'ADELANTO', 'BASE IMPONIBLE', 'DETRACCION', 'TOTAL LIQ.',
            'PROCESO PLANTA', 'ADELANTOS EXTRAS', 'PRESTAMOS', 'OTROS DESCUENTOS',
            'TOTAL', 'COD BLENDING', 'FASE'
        ];
    }

    public function styles($sheet)
    {
        $lastColumn = 'BS';

        $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '003366'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        $sheet->getStyle("A2:{$lastColumn}" . $sheet->getHighestRow())->applyFromArray([
            'font' => [
                'size' => 10,
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D3D3D3'],
                ],
            ],
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                for ($row = 2; $row <= $highestRow; $row++) {
                    $estado = strtolower((string)$sheet->getCell("J$row")->getValue());
                    $color = null;

                    if ($estado === 'cierre') {
                        $color = 'D4EDDA'; // verde claro
                    } elseif ($estado === 'provisional') {
                        $color = 'FFF3CD'; // amarillo claro
                    } elseif ($estado === '-' || $estado === '') {
                        $color = 'FFCCCC'; // rojo claro
                    }

                    if ($color) {
                        $sheet->getStyle("A$row:BS$row")->getFill()->applyFromArray([
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => $color],
                        ]);
                    }
                }
            }
        ];
    }
}
