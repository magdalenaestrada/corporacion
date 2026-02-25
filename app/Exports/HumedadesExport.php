<?php

namespace App\Exports;

use App\Models\Humedad;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class HumedadesExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private ?string $q = null) {}

    public function collection(): Collection
    {
        $q = trim((string) $this->q);

        // Permitir buscar 90.120 => 90120 (quita puntos, comas, espacios, etc.)
        $qNum = preg_replace('/\D+/', '', $q);

        return Humedad::query()
            ->with(['mineral', 'cliente', 'pesos'])
            ->when($q !== '', function ($query) use ($q, $qNum) {
                $query->where(function ($sub) use ($q, $qNum) {

                    // Campos directos de humedad
                    $sub->where('codigo', 'like', "%{$q}%")
                        ->orWhere('humedad', 'like', "%{$q}%")
                        ->orWhere('observaciones', 'like', "%{$q}%")
                        ->orWhere('fecha_recepcion', 'like', "%{$q}%")
                        ->orWhere('fecha_emision', 'like', "%{$q}%")
                        ->orWhere('periodo_inicio', 'like', "%{$q}%")
                        ->orWhere('periodo_fin', 'like', "%{$q}%");

                    // Relación Mineral
                    $sub->orWhereHas('mineral', function ($m) use ($q) {
                        $m->where('nombre', 'like', "%{$q}%");
                    });

                    // Relación Cliente
                    // Nota: cliente_detalle está en Humedad, no en Cliente
                    $sub->orWhereHas('cliente', function ($c) use ($q) {
                        $c->where('razon_social', 'like', "%{$q}%");
                    });

                    // También permitir buscar por el "extra"
                    $sub->orWhere('cliente_detalle', 'like', "%{$q}%");

                    // Relación Pesos (tickets)
                    $sub->orWhereHas('pesos', function ($p) use ($q, $qNum) {
                        $p->where('nro_salida', 'like', "%{$q}%")
                          ->orWhere('origen', 'like', "%{$q}%");

                        // neto: permitir buscar 90.120 (o 90120)
                        if ($qNum !== '') {
                            $p->orWhere('neto', 'like', "%{$qNum}%");
                        } else {
                            $p->orWhere('neto', 'like', "%{$q}%");
                        }
                    });
                });
            })
            ->latest('id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Código',
            'Mineral',
            'Fecha recepción',
            'Periodo',
            'Fecha emisión',
            'Razón social / Extra',
            'Humedad',
            'Peso (W)',
            'Observaciones',
            'Tickets',
        ];
    }

    public function map($h): array
    {
        $pesoTotal = $h->pesos->sum(fn($p) => (int) $p->neto);

        $periodoTexto = ($h->periodo_inicio && $h->periodo_fin)
            ? \Carbon\Carbon::parse($h->periodo_inicio)->format('d/m/Y') . ' AL ' . \Carbon\Carbon::parse($h->periodo_fin)->format('d/m/Y')
            : '';

        $tickets = $h->pesos->map(function ($p) {
            return ($p->nro_salida ?? '') . ' - ' . ($p->origen ?? '');
        })->implode(' | ');

        $razonCompleta = trim(
            ($h->cliente->razon_social ?? '') .
            (!empty($h->cliente_detalle) ? ' - ' . $h->cliente_detalle : '')
        );

        return [
            $h->codigo ?? $h->id,
            $h->mineral->nombre ?? '',
            $h->fecha_recepcion ? \Carbon\Carbon::parse($h->fecha_recepcion)->format('d/m/Y') : '',
            $periodoTexto,
            $h->fecha_emision ? \Carbon\Carbon::parse($h->fecha_emision)->format('d/m/Y') : '',
            $razonCompleta,
            $h->humedad ?? '',
            // Mostrar con separador de miles con punto: 90.120
            number_format($pesoTotal, 0, ',', '.'),
            $h->observaciones ?? '',
            $tickets,
        ];
    }
}
