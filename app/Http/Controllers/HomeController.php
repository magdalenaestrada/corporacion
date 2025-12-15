<?php

namespace App\Http\Controllers;
use App\Models\Liquidacion;
use App\Models\Accion;
use App\Models\Motivo;
use App\Models\Registro;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ingreso;
use App\Models\Blending;
use App\Models\Despacho;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */public function index()
{
   $hoy = Carbon::now();
    $inicioSemana = $hoy->copy()->startOfWeek();

    // =========================
    // LIQUIDACIONES + PESOS
    // =========================
    $totalLiquidaciones = Liquidacion::count();

    $cierresDiarios   = Liquidacion::whereDate('updated_at', today())
                        ->whereRaw('UPPER(estado) = ?', ['CIERRE'])->count();
    $cierresSemanales = Liquidacion::whereBetween('updated_at', [$inicioSemana, now()])
                        ->whereRaw('UPPER(estado) = ?', ['CIERRE'])->count();
    $cierresMensuales = Liquidacion::whereMonth('updated_at', now()->month)
                        ->whereRaw('UPPER(estado) = ?', ['CIERRE'])->count();

    $pesoTotal   = Liquidacion::sum('peso');
    $pesoDiario  = Liquidacion::whereDate('updated_at', today())->sum('peso');
    $pesoSemanal = Liquidacion::whereBetween('updated_at', [$inicioSemana, now()])->sum('peso');
    $pesoMensual = Liquidacion::whereMonth('updated_at', now()->month)->sum('peso');

    // Gráfico: Liquidaciones por producto
    $porProducto = Liquidacion::select('producto', DB::raw('COUNT(*) AS total'))
                    ->groupBy('producto')
                    ->orderByDesc('total')
                    ->get();

    // Podio: Liquidadores (TOP 3)
    $rankingLiquidadores = Liquidacion::select('users.name', DB::raw('COUNT(*) AS total'))
        ->join('users', 'users.id', '=', 'liquidaciones.ultimo_editor_id')
        ->whereRaw('UPPER(liquidaciones.estado) = ?', ['CIERRE'])
        ->groupBy('users.name')
        ->orderByDesc('total')
        ->take(3)
        ->get();

    // Top Clientes (solo estado CIERRE, excluye BLENDING) - case-insensitive
    $rankingClientes = Liquidacion::select('clientes.razon_social AS cliente', DB::raw('COUNT(*) AS total'))
        ->join('clientes', 'clientes.id', '=', 'liquidaciones.cliente_id')
        ->whereRaw('UPPER(clientes.razon_social) != ?', ['BLENDING'])
        ->whereRaw('UPPER(liquidaciones.estado) = ?', ['CIERRE'])
        ->groupBy('clientes.razon_social')
        ->orderByDesc('total')
        ->take(5)
        ->get();

    // =========================
    // INGRESOS
    // =========================
    $ingresosFechaCol = 'updated_at';
    $totalIngresos  = Ingreso::count();
    $ingresosMes    = Ingreso::whereMonth($ingresosFechaCol, now()->month)->count();
    $ingresosSemana = Ingreso::whereBetween($ingresosFechaCol, [$inicioSemana, now()])->count();
    $ingresosHoy    = Ingreso::whereDate($ingresosFechaCol, today())->count();

    // =========================
    // BLENDING
    // =========================
    $blendingFechaCol = 'updated_at';
    $totalBlending  = Blending::count();
    $blendingMes    = Blending::whereMonth($blendingFechaCol, now()->month)->count();
    $blendingSemana = Blending::whereBetween($blendingFechaCol, [$inicioSemana, now()])->count();
    $blendingHoy    = Blending::whereDate($blendingFechaCol, today())->count();

    // =========================
    // DESPACHOS
    // =========================
    $despachosFechaCol = 'updated_at';
    $totalDespachos  = Despacho::count();
    $despachosMes    = Despacho::whereMonth($despachosFechaCol, now()->month)->count();
    $despachosSemana = Despacho::whereBetween($despachosFechaCol, [$inicioSemana, now()])->count();
    $despachosHoy    = Despacho::whereDate($despachosFechaCol, today())->count();

    // =========================
    // ÚLTIMAS OPERACIONES (para la tabla nueva del home)
    // =========================
    $ultimasOperaciones = Liquidacion::select(
            'liquidaciones.id',
            'clientes.razon_social',
            'liquidaciones.estado',
            'liquidaciones.created_at'
        )
        ->join('clientes', 'clientes.id', '=', 'liquidaciones.cliente_id')
        ->orderByDesc('liquidaciones.created_at')
        ->limit(5)
        ->get();

    return view('home', compact(
        // Liquidaciones + Pesos
        'totalLiquidaciones','cierresDiarios','cierresSemanales','cierresMensuales',
        'pesoTotal','pesoDiario','pesoSemanal','pesoMensual',
        'porProducto','rankingLiquidadores','rankingClientes',
        // Ingresos
        'totalIngresos','ingresosMes','ingresosSemana','ingresosHoy',
        // Blending
        'totalBlending','blendingMes','blendingSemana','blendingHoy',
        // Despachos
        'totalDespachos','despachosMes','despachosSemana','despachosHoy',
        // Nuevas
        'ultimasOperaciones'
    ));
}


}