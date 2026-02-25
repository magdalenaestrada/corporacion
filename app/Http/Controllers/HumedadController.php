<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Humedad;
use App\Models\HumedadPeso;

use App\Models\EstadoMineral;
use App\Models\Cliente;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Peso;
use App\Models\PesoKilate;

class HumedadController extends Controller
{
    public function __construct()
    { 
        $this->middleware('permission:ver humedad', ['only' => ['index','show']]);
        $this->middleware('permission:create humedad', ['only' => ['create', 'store','export']]);
        $this->middleware('permission:editar humedad', ['only' => ['update','edit']]);
        $this->middleware('permission:eliminar humedad', ['only' => ['destroy']]);
    }
    /**
     * Genera código: H + año(2 dígitos) + 5 dígitos
     * Ejemplo: H2600063
     *
     * Regla: para el año 26 empieza en 00063 (H2600063).
     * Para otros años, si no existe nada aún, empieza en 00001.
     */
    private function generarCodigo(): string
    {
        $yy = now()->format('y');          // "26"
        $prefix = 'H' . $yy;               // "H26"

        // Inicio especial para 2026 (yy=26): 00073
        $startSeq = ($yy === '26') ? 73 : 1;

        // Bloqueo para evitar duplicidad en concurrencia
        $last = Humedad::where('codigo', 'like', $prefix . '%')
            ->orderByDesc('codigo')
            ->lockForUpdate()
            ->first();

        if (!$last || empty($last->codigo)) {
            $next = $startSeq;
        } else {
            // Extrae últimos 5 dígitos
            $lastSeq = (int) substr($last->codigo, -5);
            $next = max($lastSeq + 1, $startSeq);
        }

        return $prefix . str_pad((string)$next, 5, '0', STR_PAD_LEFT);
    }

    /**
     * INFORME
     */
    public function informe($id)
    {
        $humedad = Humedad::with(['mineral', 'cliente', 'pesos'])
            ->findOrFail($id);

        $alfaTickets   = $humedad->pesos->where('origen', 'A');
        $kilateTickets = $humedad->pesos->where('origen', 'K');

        // W = suma netos
        $pesoTotal = $humedad->pesos->sum('neto');

        return view('humedad.informe', compact(
            'humedad',
            'alfaTickets',
            'kilateTickets',
            'pesoTotal'
        ));
    }

    /**
     * AJAX: Buscar tickets en BD completa y excluir los ya usados.
     * Opcional: humedad_id para EDIT y permitir los ya asignados a esa humedad.
     */
    public function buscarPesos(Request $request)
    {
        $origen    = $request->get('origen'); // A | K
        $q         = trim((string) $request->get('q', ''));
        $page      = (int) $request->get('page', 1);
        $humedadId = $request->get('humedad_id'); // opcional (para EDIT)

        $usadosQuery = HumedadPeso::where('origen', $origen);
        if (!empty($humedadId)) {
            $usadosQuery->where('humedad_id', '!=', $humedadId);
        }
        $usados = $usadosQuery->pluck('nro_salida')->toArray();

        $query = ($origen === 'A') ? Peso::query() : PesoKilate::query();

        if (!empty($usados)) {
            $query->whereNotIn('NroSalida', $usados);
        }

        if ($q !== '') {
            $query->where('NroSalida', 'like', "%{$q}%");
        }

        $pesos = $query
            ->select('NroSalida', 'Neto')
            ->orderByDesc('NroSalida')
            ->paginate(50, ['*'], 'page', $page);

        return response()->json([
            'data' => $pesos->items(),
            'links' => [
                'current_page' => $pesos->currentPage(),
                'last_page'    => $pesos->lastPage(),
                'prev_page_url'=> $pesos->previousPageUrl(),
                'next_page_url'=> $pesos->nextPageUrl(),
            ],
        ]);
    }

public function index(Request $request)
{
    $q = trim((string) $request->get('q', ''));

    // "90.120" -> "90120" (quita puntos, comas, espacios, etc.)
    $qNum = preg_replace('/\D+/', '', $q);

    $humedades = Humedad::query()
        ->with(['mineral', 'cliente', 'pesos'])
        ->when($q !== '', function ($query) use ($q, $qNum) {
            $query->where(function ($sub) use ($q, $qNum) {

                // Campos directos de humedad + cliente_detalle
                $sub->where('codigo', 'like', "%{$q}%")
                    ->orWhere('humedad', 'like', "%{$q}%")
                    ->orWhere('observaciones', 'like', "%{$q}%")
                    ->orWhere('fecha_recepcion', 'like', "%{$q}%")
                    ->orWhere('fecha_emision', 'like', "%{$q}%")
                    ->orWhere('periodo_inicio', 'like', "%{$q}%")
                    ->orWhere('periodo_fin', 'like', "%{$q}%")
                    ->orWhere('cliente_detalle', 'like', "%{$q}%"); // ✅ NUEVO

                // Relación Mineral
                $sub->orWhereHas('mineral', function ($m) use ($q) {
                    $m->where('nombre', 'like', "%{$q}%");
                });

                // Relación Cliente
                $sub->orWhereHas('cliente', function ($c) use ($q) {
                    $c->where('razon_social', 'like', "%{$q}%");
                });

                // Relación Pesos (tickets)
                $sub->orWhereHas('pesos', function ($p) use ($q, $qNum) {
                    $p->where('nro_salida', 'like', "%{$q}%")
                      ->orWhere('origen', 'like', "%{$q}%");

                    // neto: permitir buscar 90.120
                    if ($qNum !== '') {
                        $p->orWhere('neto', 'like', "%{$qNum}%");
                    } else {
                        $p->orWhere('neto', 'like', "%{$q}%");
                    }
                });
            });
        })
        ->latest('id')
        ->paginate(15)
        ->appends(['q' => $q]); // mantiene el query en paginación

    return view('humedad.index', compact('humedades'));
}

public function create()
    {
        $minerales = EstadoMineral::where('activo', 1)
            ->orderBy('nombre')
            ->get();

        $clientes = Cliente::orderBy('razon_social')->get();

        // Excluir tickets ya usados
        $usadosA = HumedadPeso::where('origen', 'A')->pluck('nro_salida')->toArray();
        $usadosK = HumedadPeso::where('origen', 'K')->pluck('nro_salida')->toArray();

        $pesosAlfa = Peso::select('NroSalida', 'Neto')
            ->when(!empty($usadosA), fn($q) => $q->whereNotIn('NroSalida', $usadosA))
            ->orderByDesc('NroSalida')
            ->paginate(50, ['*'], 'alfa');

        $pesosKilate = PesoKilate::select('NroSalida', 'Neto')
            ->when(!empty($usadosK), fn($q) => $q->whereNotIn('NroSalida', $usadosK))
            ->orderByDesc('NroSalida')
            ->paginate(50, ['*'], 'kilate');

        return view('humedad.create', compact('minerales', 'clientes', 'pesosAlfa', 'pesosKilate'));
    }
   public function store(Request $request)
{
    $request->validate([
        'estado_mineral_id' => ['required', 'integer', 'exists:estados_mineral,id'],
        'cliente_id'        => ['required', 'integer', 'exists:clientes,id'],

        'cliente_detalle'   => ['nullable', 'string', 'max:50'],

        'fecha_recepcion'   => ['nullable', 'date'],
        'fecha_emision'     => ['nullable', 'date'],

        'periodo_inicio'    => ['nullable', 'date'],
        'periodo_fin'       => ['nullable', 'date', 'after_or_equal:periodo_inicio'],

        'humedad'           => ['nullable', 'numeric', 'min:0', 'max:100'],
        'observaciones'     => ['nullable', 'string', 'max:500'],

        'pesos_alfa'        => ['nullable', 'array'],
        'pesos_alfa.*'      => ['integer'],

        'pesos_kilate'      => ['nullable', 'array'],
        'pesos_kilate.*'    => ['integer'],
    ]);

    $alfaIds   = (array) $request->input('pesos_alfa', []);
    $kilateIds = (array) $request->input('pesos_kilate', []);

    // ✅ VALIDACIÓN: mínimo 1 ticket (A o K)
    if (count($alfaIds) === 0 && count($kilateIds) === 0) {
        return back()
            ->withErrors(['pesos' => 'Debes seleccionar al menos 1 ticket (ALFA o KILATE) para guardar.'])
            ->withInput();
    }

    return DB::transaction(function () use ($request, $alfaIds, $kilateIds) {

        // ✅ Anti-duplicidad (bloqueo)
        if (!empty($alfaIds)) {
            $yaUsadosA = HumedadPeso::where('origen', 'A')
                ->whereIn('nro_salida', $alfaIds)
                ->lockForUpdate()
                ->exists();

            if ($yaUsadosA) {
                return back()->withErrors(['pesos_alfa' => 'Uno o más tickets ALFA ya fueron registrados.'])->withInput();
            }
        }

        if (!empty($kilateIds)) {
            $yaUsadosK = HumedadPeso::where('origen', 'K')
                ->whereIn('nro_salida', $kilateIds)
                ->lockForUpdate()
                ->exists();

            if ($yaUsadosK) {
                return back()->withErrors(['pesos_kilate' => 'Uno o más tickets KILATE ya fueron registrados.'])->withInput();
            }
        }

        // ✅ Generar código consecutivo seguro (H26xxxxx)
        $codigo = $this->generarCodigo();

        // ✅ Normalizar detalle
        $detalle = $request->cliente_detalle ? strtoupper(trim($request->cliente_detalle)) : null;

        $humedad = Humedad::create([
            'codigo'            => $codigo,
            'estado_mineral_id' => $request->estado_mineral_id,
            'cliente_id'        => $request->cliente_id,
            'cliente_detalle'   => $detalle,
            'fecha_recepcion'   => $request->fecha_recepcion,
            'fecha_emision'     => $request->fecha_emision,
            'periodo_inicio'    => $request->periodo_inicio,
            'periodo_fin'       => $request->periodo_fin,
            'humedad'           => $request->humedad,
            'observaciones'     => $request->observaciones,
        ]);

        // Guardar ALFA (A)
        if (!empty($alfaIds)) {
            $alfa = Peso::whereIn('NroSalida', $alfaIds)->get(['NroSalida', 'Neto']);
            foreach ($alfa as $p) {
                HumedadPeso::create([
                    'humedad_id' => $humedad->id,
                    'origen'     => 'A',
                    'nro_salida' => $p->NroSalida,
                    'neto'       => $p->Neto,
                ]);
            }
        }

        // Guardar KILATE (K)
        if (!empty($kilateIds)) {
            $kilate = PesoKilate::whereIn('NroSalida', $kilateIds)->get(['NroSalida', 'Neto']);
            foreach ($kilate as $p) {
                HumedadPeso::create([
                    'humedad_id' => $humedad->id,
                    'origen'     => 'K',
                    'nro_salida' => $p->NroSalida,
                    'neto'       => $p->Neto,
                ]);
            }
        }

        return redirect()->route('humedad.index')
            ->with('success', "Humedad registrada correctamente. Código: {$codigo}");
    });
}



    public function show($id)
    {
        $humedad = Humedad::with(['mineral', 'cliente', 'pesos'])
            ->findOrFail($id);

        $alfaIds   = $humedad->pesos->where('origen', 'A')->pluck('nro_salida')->values();
        $kilateIds = $humedad->pesos->where('origen', 'K')->pluck('nro_salida')->values();

        $alfaTickets = $alfaIds->isEmpty()
            ? collect()
            : Peso::whereIn('NroSalida', $alfaIds)->get(['NroSalida', 'Neto']);

        $kilateTickets = $kilateIds->isEmpty()
            ? collect()
            : PesoKilate::whereIn('NroSalida', $kilateIds)->get(['NroSalida', 'Neto']);

        return view('humedad.show', compact('humedad', 'alfaTickets', 'kilateTickets'));
    }

    public function edit($id)
    {
        $humedad = Humedad::with(['pesos'])->findOrFail($id);

        $minerales = EstadoMineral::where('activo', 1)
            ->orderBy('nombre')
            ->get();

        $clientes = Cliente::orderBy('razon_social')->get();

        // En EDIT: excluir usados de otras humedades, pero permitir los de esta humedad
        $usadosA = HumedadPeso::where('origen', 'A')
            ->where('humedad_id', '!=', $humedad->id)
            ->pluck('nro_salida')->toArray();

        $usadosK = HumedadPeso::where('origen', 'K')
            ->where('humedad_id', '!=', $humedad->id)
            ->pluck('nro_salida')->toArray();

        $pesosAlfa = Peso::select('NroSalida', 'Neto')
            ->when(!empty($usadosA), fn($q) => $q->whereNotIn('NroSalida', $usadosA))
            ->orderByDesc('NroSalida')
            ->paginate(50, ['*'], 'alfa');

        $pesosKilate = PesoKilate::select('NroSalida', 'Neto')
            ->when(!empty($usadosK), fn($q) => $q->whereNotIn('NroSalida', $usadosK))
            ->orderByDesc('NroSalida')
            ->paginate(50, ['*'], 'kilate');

        $selectedAlfa   = $humedad->pesos->where('origen', 'A')->pluck('nro_salida')->map(fn($v)=>(string)$v)->toArray();
        $selectedKilate = $humedad->pesos->where('origen', 'K')->pluck('nro_salida')->map(fn($v)=>(string)$v)->toArray();

        $mapAlfa   = $humedad->pesos->where('origen','A')->pluck('neto','nro_salida')->toArray();
        $mapKilate = $humedad->pesos->where('origen','K')->pluck('neto','nro_salida')->toArray();

        return view('humedad.edit', compact(
            'humedad',
            'minerales',
            'clientes',
            'pesosAlfa',
            'pesosKilate',
            'selectedAlfa',
            'selectedKilate',
            'mapAlfa',
            'mapKilate'
        ));
    }

public function update(Request $request, $id)
{
    $humedad = Humedad::with('pesos')->findOrFail($id);

    $data = $request->validate([
        'estado_mineral_id' => ['required','integer','exists:estados_mineral,id'],
        'cliente_id'        => ['required','integer','exists:clientes,id'],
        'cliente_detalle'   => ['nullable','string','max:50'],

        'fecha_recepcion'   => ['nullable','date'],
        'fecha_emision'     => ['nullable','date'],
        'periodo_inicio'    => ['nullable','date'],
        'periodo_fin'       => ['nullable','date','after_or_equal:periodo_inicio'],
        'humedad'           => ['nullable','numeric','min:0','max:100'],
        'observaciones'     => ['nullable','string','max:500'],

        // ✅ tickets
        'pesos_alfa'        => ['nullable','array'],
        'pesos_alfa.*'      => ['integer'],
        'pesos_kilate'      => ['nullable','array'],
        'pesos_kilate.*'    => ['integer'],
    ]);

    $data['cliente_detalle'] = !empty($data['cliente_detalle'])
        ? strtoupper(trim($data['cliente_detalle']))
        : null;

    $alfaIds   = (array) $request->input('pesos_alfa', []);
    $kilateIds = (array) $request->input('pesos_kilate', []);

    // ✅ mínimo 1 ticket (opcional, pero recomendado)
    if (count($alfaIds) === 0 && count($kilateIds) === 0) {
        return back()->withErrors(['pesos' => 'Debes seleccionar al menos 1 ticket (ALFA o KILATE).'])->withInput();
    }

    return DB::transaction(function () use ($humedad, $data, $alfaIds, $kilateIds) {

        // ✅ Anti-duplicidad: no permitir tickets que estén en otra humedad
        if (!empty($alfaIds)) {
            $yaUsadosA = HumedadPeso::where('origen', 'A')
                ->whereIn('nro_salida', $alfaIds)
                ->where('humedad_id', '!=', $humedad->id)
                ->lockForUpdate()
                ->exists();

            if ($yaUsadosA) {
                return back()->withErrors(['pesos_alfa' => 'Uno o más tickets ALFA ya fueron registrados en otra Humedad.'])->withInput();
            }
        }

        if (!empty($kilateIds)) {
            $yaUsadosK = HumedadPeso::where('origen', 'K')
                ->whereIn('nro_salida', $kilateIds)
                ->where('humedad_id', '!=', $humedad->id)
                ->lockForUpdate()
                ->exists();

            if ($yaUsadosK) {
                return back()->withErrors(['pesos_kilate' => 'Uno o más tickets KILATE ya fueron registrados en otra Humedad.'])->withInput();
            }
        }

        // 1) actualiza cabecera
        $humedad->update($data);

        // 2) sincroniza pivot (borra los que quitaron y agrega los nuevos)
        HumedadPeso::where('humedad_id', $humedad->id)->delete();

        // volver a insertar ALFA
        if (!empty($alfaIds)) {
            $alfa = Peso::whereIn('NroSalida', $alfaIds)->get(['NroSalida','Neto']);
            foreach ($alfa as $p) {
                HumedadPeso::create([
                    'humedad_id' => $humedad->id,
                    'origen'     => 'A',
                    'nro_salida' => $p->NroSalida,
                    'neto'       => $p->Neto,
                ]);
            }
        }

        // volver a insertar KILATE
        if (!empty($kilateIds)) {
            $kilate = PesoKilate::whereIn('NroSalida', $kilateIds)->get(['NroSalida','Neto']);
            foreach ($kilate as $p) {
                HumedadPeso::create([
                    'humedad_id' => $humedad->id,
                    'origen'     => 'K',
                    'nro_salida' => $p->NroSalida,
                    'neto'       => $p->Neto,
                ]);
            }
        }

        return redirect()
            ->route('humedad.index')
            ->with('info', 'Humedad actualizada correctamente.');
    });
}

    public function destroy($id)
    {
        $humedad = Humedad::findOrFail($id);

        // Si tu FK pivot NO tiene cascade, descomenta:
        // HumedadPeso::where('humedad_id', $humedad->id)->delete();

        $humedad->delete();

        return redirect()->route('humedad.index')
            ->with('success', 'Humedad eliminada.');
    }

    public function export(Request $request)
{
    return Excel::download(new \App\Exports\HumedadesExport($request->get('q')), 'humedades.xlsx');
}
}
