<?php

namespace App\Http\Controllers;

use App\Exports\BlendingExport;
use App\Exports\DespachosExport;
use App\Exports\IngresosExport;
use App\Exports\LiquidacionesExport;
use App\Models\Blending;
use App\Models\Despacho;
use App\Models\Ingreso;
use App\Models\Liquidacion;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver liq', ['only' => ['resumen', 'liq', 'blendings', ]]);
        $this->middleware('permission:ver loza', ['only' => ['resumen', 'loza', 'despachos']]);
    }

    public function index()
    {
        return view('reportes.index');
    }

    /** Página del reporte de liquidaciones */
    public function liq()
    {
        $liquidaciones = Liquidacion::with([
                'cliente',
                'requerimientos',
                'muestra',
                'creator',
                'lastEditor',
                'ingreso',
                'ingreso.blendings',
            ])
            ->orderByDesc('created_at')
            ->get();

        return view('reportes.liq', compact('liquidaciones'));
    }

    /** Página del reporte de ingresos */
    public function loza()
    {
        $ingresos = Ingreso::orderByDesc('created_at')->get();

        $pesoTotal      = $ingresos->sum('peso_total');
        $pesoIngresados = $ingresos->filter(fn ($i) => strtolower(trim($i->fase)) === 'ingresado')->sum('peso_total');
        $pesoBlending   = $ingresos->filter(fn ($i) => strtolower(trim($i->fase)) === 'blending')->sum('peso_total');
        $pesoDespachado = $ingresos->filter(fn ($i) => strtolower(trim($i->fase)) === 'despachado')->sum('peso_total');
        $pesoRetirado   = $ingresos->filter(fn ($i) => strtolower(trim($i->fase)) === 'retirado')->sum('peso_total');

        // Stock = ingresado + blending
        $pesoEnStock = $pesoIngresados + $pesoBlending;

        return view('reportes.loza', compact(
            'ingresos',
            'pesoTotal',
            'pesoIngresados',
            'pesoBlending',
            'pesoDespachado',
            'pesoRetirado',
            'pesoEnStock'
        ));
    }

    /** Página del reporte de blendings */
    public function blendings()
    {
        $blendings = Blending::with([
                'ingresos' => fn ($q) => $q->with('user'),
                'user', // creador
            ])
            ->orderByDesc('created_at')
            ->get();

        $pesoTotalBlending = $blendings->sum('pesoblending');
        $totalRegistros    = $blendings->count();

        return view('reportes.blendings', compact('blendings', 'pesoTotalBlending', 'totalRegistros'));
    }

    /** Exportar Blendings (usa " to " como separador de flatpickr en esa vista) */
    public function exportarBlendingExcel(Request $request)
    {
        $query = Blending::with(['user', 'ingresos']);

        if ($request->filled('lista')) {
            $query->where('lista', $request->input('lista'));
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        if ($request->filled('fecha')) {
            $fechas = explode(' to ', $request->input('fecha'));
            if (count($fechas) === 2) {
                $query->whereBetween('created_at', [$fechas[0], $fechas[1]]);
            }
        }

        if ($request->filled('busqueda')) {
            $search = strtolower($request->input('busqueda'));
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(cod) LIKE ?', ["%$search%"])
                  ->orWhereRaw('LOWER(lista) LIKE ?', ["%$search%"])
                  ->orWhereRaw('LOWER(notas) LIKE ?', ["%$search%"]);
            });
        }

        $blendings = $query->get();

        return Excel::download(new BlendingExport($blendings), 'blendings_filtrados.xlsx');
    }

    /** Exportar Liquidaciones (usa request completo para tu export personalizado) */
    public function exportarExcel(Request $request)
    {
        return Excel::download(new LiquidacionesExport($request), 'reporte_liquidaciones.xlsx');
    }

    /** Exportar Ingresos (en esa vista usas separador " to ") */
    public function exportarIngresosExcel(Request $request)
    {
        $query = Ingreso::with('user');

        if ($request->filled('fase')) {
            $query->where('fase', $request->input('fase'));
        }

        if ($request->filled('fecha')) {
            $fechas = explode(' to ', $request->input('fecha'));
            if (count($fechas) === 2) {
                $query->whereBetween('fecha_ingreso', [$fechas[0], $fechas[1]]);
            }
        }

        if ($request->filled('busqueda')) {
            $busqueda = strtolower($request->input('busqueda'));
            $query->where(function ($q) use ($busqueda) {
                $q->whereRaw('LOWER(codigo) LIKE ?', ["%$busqueda%"])
                  ->orWhereRaw('LOWER(identificador) LIKE ?', ["%$busqueda%"])
                  ->orWhereRaw('LOWER(nom_iden) LIKE ?', ["%$busqueda%"]);
            });
        }

        $ingresos = $query->get();

        return Excel::download(new IngresosExport($ingresos), 'ingresos_filtrados.xlsx');
    }

    /** Página del reporte de despachos */
    public function despachos()
    {
        $despachos = Despacho::with('retiros', 'blending')
            ->orderByDesc('created_at')
            ->get();

        $totalDespachos      = $despachos->count();
        $pesoTotalDespachos  = $despachos->sum('peso_despachado');
        $totalTMH            = $despachos->sum('tmh'); // si tu TMH es calculado, mantén este nombre de columna

        return view('reportes.despachos', compact('despachos', 'totalDespachos', 'pesoTotalDespachos', 'totalTMH'));
    }

    /** Exportar Despachos (en esa vista usas separador " a ") */
    public function exportarDespachosExcel(Request $request)
    {
        $query = Despacho::with('retiros');

        if ($request->filled('busqueda')) {
            $busqueda = strtolower($request->busqueda);
            $query->where(function ($q) use ($busqueda) {
                $q->whereRaw('LOWER(destino) LIKE ?', ["%$busqueda%"])
                  ->orWhereRaw('LOWER(observacion) LIKE ?', ["%$busqueda%"]);
            });
        }

        if ($request->filled('fecha')) {
            $fechas = explode(' a ', $request->input('fecha')); // coincide con tu flatpickr en Despachos
            if (count($fechas) === 2) {
                $query->whereBetween('fecha', [$fechas[0], $fechas[1]]);
            }
        }

        $despachos = $query->get();

        return Excel::download(new DespachosExport($despachos), 'despachos_filtrados.xlsx');
    }

    /** Reporte de Flujos (tabla grande con relaciones) */
    public function flujos()
    {
        $liquidaciones = Liquidacion::with([
                'cliente',
                'muestra',
                'ingreso.blendings.despacho.retiros',
            ])
            ->orderByDesc('created_at')
            ->get();

        $ingresosSinLiquidacion = Ingreso::whereDoesntHave('liquidaciones')
            ->with(['blendings.despacho.retiros'])
            ->orderByDesc('created_at')
            ->get();

        $blendings = Blending::all();

        return view('reportes.flujos', compact('liquidaciones', 'ingresosSinLiquidacion', 'blendings'));
    }

    /** JSON para Dashboard */public function resumen(Request $request)
{
    try {
        $desde = $request->query('desde');
        $hasta = $request->query('hasta');

        // Clonar queries base y filtrar si hay rango
        $ingBase   = Ingreso::query();
        $blendBase = Blending::query();
        $despBase  = Despacho::query();

        if ($desde && $hasta) {
            // Ingresos por fecha de ingreso (día a día)
            $ingBase->whereBetween('fecha_ingreso', [$desde, $hasta]);

            // Blendings por creado_en
            $blendBase->whereBetween('created_at', ["{$desde} 00:00:00", "{$hasta} 23:59:59"]);

            // Despachos por fecha (tu tabla ya tiene 'fecha')
            $despBase->whereBetween('fecha', [$desde, $hasta]);
        }

        // —— Métricas de Ingresos ——
        // TMH por fase
        $tmhPorFase = (clone $ingBase)
            ->selectRaw("LOWER(COALESCE(fase,'')) as fase, COALESCE(SUM(peso_total),0) as tmh")
            ->groupBy('fase')
            ->pluck('tmh','fase');

        // TMH por "tipo de producto": usamos 'descripcion'
        $tmhPorProducto = (clone $ingBase)
            ->selectRaw("LOWER(COALESCE(descripcion,'')) as producto, COALESCE(SUM(peso_total),0) as tmh")
            ->groupBy('producto')
            ->pluck('tmh','producto');

        // Stock “rápido”: ingresado + blending (de Ingresos)
        $tmhIngresado = (float) ($tmhPorFase['ingresado'] ?? 0);
        $tmhBlendingFase = (float) ($tmhPorFase['blending'] ?? 0);
        $tmhStock = round($tmhIngresado + $tmhBlendingFase, 3);

        // —— Métricas de Blendings ——
        // TMH por lista (oro/plata/cobre) usando pesoblending (columna real)
        $blendTMHPorLista = (clone $blendBase)
            ->selectRaw("LOWER(COALESCE(lista,'')) as lista, COALESCE(SUM(pesoblending),0) as tmh")
            ->groupBy('lista')
            ->pluck('tmh','lista');

        // —— Métricas de Despachos ——
        // Top destinos por TMH: lo hacemos en PHP sumando retiros.neto
        $despParaAgrupar = (clone $despBase)
            ->with(['retiros:id,despacho_id,neto'])
            ->get(['id','destino']); // solo lo necesario

        $destinosTop = $despParaAgrupar
            ->groupBy(fn($d) => $d->destino ?: '-')
            ->map(function ($grupo, $destino) {
                // Sumar TMH por retiros (si no hay retiros, intenta usar accessor tmh si existe)
                $tmh = $grupo->reduce(function ($carry, $d) {
                    $sumaRetiros = $d->retiros ? (float) $d->retiros->sum('neto') : 0.0;
                    $fallback = property_exists($d, 'tmh') ? (float) ($d->tmh ?? 0) : 0.0;
                    return $carry + ($sumaRetiros > 0 ? $sumaRetiros : $fallback);
                }, 0.0);
                return ['destino' => $destino, 'tmh' => round($tmh, 3)];
            })
            ->values()
            ->sortByDesc('tmh')
            ->take(5)
            ->values();

        // —— Totales simples (conteos) ——
        $totalIngresos  = (clone $ingBase)->count();
        $totalBlendings = (clone $blendBase)->count();
        $totalDespachos = (clone $despBase)->count();

        return response()->json([
            // Conteos para las tarjetas
            'total_ingresos'  => $totalIngresos,
            'total_blendings' => $totalBlendings,
            'total_despachos' => $totalDespachos,

            // Extras para tu UI
            'tmh_stock'                  => $tmhStock,             // ingresado + blending (fase)
            'ingresos_tmh_por_fase'      => $tmhPorFase,           // {fase: tmh}
            'ingresos_tmh_por_producto'  => $tmhPorProducto,       // {descripcion: tmh}
            'blendings_tmh_por_lista'    => $blendTMHPorLista,     // {oro/plata/cobre: tmh}
            'destinos_top'               => $destinosTop,          // [{destino, tmh}]
        ], 200);
    } catch (\Throwable $e) {
        // Devuelve detalle para depurar en el front si aún saliera algo inesperado
        return response()->json([
            'ok' => false,
            'error' => 'summary_failed',
            'message' => $e->getMessage(),
            // 'trace' => $e->getTrace(), // si necesitas más detalle temporalmente
        ], 500);
    }
}




    // CRUD vacíos por si los necesitas luego
    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
