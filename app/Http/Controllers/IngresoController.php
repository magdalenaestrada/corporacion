<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use App\Models\Peso;
use App\Models\Blending;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;

class IngresoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver ingreso', ['only' => ['index','show','imprimir','lotizar']]);
        $this->middleware('permission:create ingreso', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar ingreso', ['only' => ['update','edit']]);
        $this->middleware('permission:eliminar ingreso', ['only' => ['destroy']]);
        $this->middleware('permission:retirar lote', ['only' => ['retirar']]);
    }

    public function index(Request $request)
    {
        $query = Ingreso::where('estado', '!=', 'CHANCADO')->orderBy('fecha_ingreso', 'desc');

        // =========================
        // FILTROS
        // =========================
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('identificador', 'like', "%{$search}%")
                  ->orWhere('nom_iden', 'like', "%{$search}%")
                  ->orWhere('NroSalida', 'like', "%{$search}%")
                  ->orWhere('estado', 'like', "%{$search}%")
                  ->orWhere('peso_total', 'like', "%{$search}%")
                  ->orWhere('lote', 'like', "%{$search}%");
            });
        }

        if ($request->filled('fase')) {
            $query->where('fase', $request->fase);
        }

        // ✅ FILTRO POR FECHAS (fecha_ingreso)
        if ($request->filled('date_from')) {
            $query->whereDate('fecha_ingreso', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('fecha_ingreso', '<=', $request->date_to);
        }

        // =========================
        // LISTADO PAGINADO
        // =========================
        $ingresos = (clone $query)
            ->with('user')
            ->paginate(200)
            ->appends($request->only(['search','fase','date_from','date_to']));

        // =========================
        // FASES DISPONIBLES
        // (si quieres solo NO CHANCADO)
        // =========================
        $fases = Ingreso::where('estado', '!=', 'CHANCADO')->select('fase')->distinct()->pluck('fase');

        // =========================
        // TOTALES (con filtros aplicados)
        // =========================
        $pesoTotal      = (clone $query)->sum('peso_total');
        $pesoIngresados = (clone $query)->where('fase', 'INGRESADO')->sum('peso_total');
        $pesoBlending   = (clone $query)->where('fase', 'BLENDING')->sum('peso_total');
        $pesoDespachado = (clone $query)->where('fase', 'DESPACHADO')->sum('peso_total');
        $pesoRetirado   = (clone $query)->where('fase', 'RETIRADO')->sum('peso_total');

        // Peso en stock = Ingresado + Blending (según tu lógica)
        $pesoEnStock = $pesoIngresados + $pesoBlending;

        // Agrupar por fase
        $ingresosAgrupados = $ingresos->groupBy('fase');

        return view('ingresos.index', compact(
            'ingresos',
            'ingresosAgrupados',
            'fases',
            'pesoTotal',
            'pesoIngresados',
            'pesoBlending',
            'pesoDespachado',
            'pesoRetirado',
            'pesoEnStock'
        ));
    }

    public function create(Request $request)
    {
        $ingresos = Ingreso::all();
        $user = Auth::user();
        $search = $request->input('search', '');

        $nrosSalidaRegistrados = Ingreso::pluck('NroSalida')->map(function ($item) {
            return explode('/', trim($item));
        })->flatten()->unique()->toArray();

        $lotesRegistrados = Ingreso::pluck('lote')->unique()->toArray();

        $pesos = Peso::when($search, function ($query, $search) {
            return $query->where('NroSalida', 'like', "%{$search}%");
        })
        ->whereNotIn('NroSalida', $nrosSalidaRegistrados)
        ->orderBy('NroSalida', 'desc')
        ->paginate(perPage: 800);

        return view('ingresos.create', compact('ingresos', 'pesos', 'search', 'user', 'lotesRegistrados'));
    }

    public function store(Request $request)
    {
        if ($request->filled('peso_total')) {
            $raw = $request->peso_total;
            $digits = preg_replace('/\D/', '', $raw);

            if (strlen($digits) > 3) {
                $normalized = substr($digits, 0, -3) . '.' . substr($digits, -3);
            } else {
                $normalized = '0.' . str_pad($digits, 3, '0', STR_PAD_LEFT);
            }

            $request->merge([
                'peso_total' => $normalized
            ]);
        }

        $request->validate([
            'codigo' => 'required|string|max:255',
            'fecha_ingreso' => 'required|date',
            'estado' => 'required|string',
            'ref_lote' => 'nullable|string|max:255',
            'identificador' => 'required|string|max:20',
            'nom_iden' => 'nullable|string|max:255',
            'peso_total' => 'nullable|numeric',
            'NroSalida' => 'nullable|string|max:500',
            'placa' => 'nullable|string|max:500',
            'procedencia' => 'nullable|string|max:255',
            'deposito' => 'nullable|string|max:255',
            'balanza' => 'nullable|string|max:255',
            'tolva' => 'nullable|string|max:255',
            'guia_transporte' => 'nullable|string|max:500',
            'guia_remision' => 'nullable|string|max:500',
            'muestreo' => 'nullable|string|max:255',
            'preparacion' => 'nullable|string|max:255',
            'req_analisis' => 'nullable|string|max:255',
            'req_analisis1' => 'nullable|string|max:255',
            'descuento' => 'nullable|string|max:255',
            'fecha_salida' => 'nullable|string|max:255',
            'retiro' => 'nullable|string|max:255',
            'pesoexterno' => 'nullable|string|max:255',
            'lote' => 'required|integer|between:1,504',
            'descripcion' => 'nullable|string|max:255',
            'fase' => 'nullable|string|max:255',
        ]);

        $ingreso = new Ingreso();
        $ingreso->codigo = $request->codigo;
        $ingreso->fecha_ingreso = $request->fecha_ingreso;
        $ingreso->estado = $request->estado;
        $ingreso->ref_lote = $request->ref_lote;
        $ingreso->identificador = $request->identificador;
        $ingreso->nom_iden = $request->nom_iden;
        $ingreso->peso_total = $request->peso_total;
        $ingreso->NroSalida = $request->NroSalida;
        $ingreso->placa = $request->placa;
        $ingreso->procedencia = $request->procedencia;
        $ingreso->deposito = $request->deposito;
        $ingreso->balanza = $request->balanza;
        $ingreso->tolva = $request->tolva;
        $ingreso->guia_transporte = $request->guia_transporte;
        $ingreso->guia_remision = $request->guia_remision;
        $ingreso->muestreo = $request->muestreo;
        $ingreso->preparacion = $request->preparacion;
        $ingreso->req_analisis = $request->req_analisis;
        $ingreso->req_analisis1 = $request->req_analisis1;
        $ingreso->descuento = $request->descuento;
        $ingreso->fecha_salida = $request->fecha_salida;
        $ingreso->retiro = $request->retiro;
        $ingreso->pesoexterno = $request->pesoexterno;
        $ingreso->lote = $request->lote;
        $ingreso->descripcion = $request->descripcion;

        $ingreso->fase = 'INGRESADO';
        $ingreso->usuario_id = auth()->id();
        $ingreso->save();

        return redirect()->route('ingresos.index')->with('success', 'Ingreso guardado exitosamente.');
    }

    public function show($id)
    {
        $ingreso = Ingreso::findOrFail($id);
        return view('ingresos.show', compact('ingreso'));
    }

    public function edit($id)
    {
        $ingreso = Ingreso::findOrFail($id);
        return view('ingresos.edit', compact('ingreso'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|string',
            'ref_lote' => 'nullable|string',
            'identificador' => 'nullable|string',
            'nom_iden' => 'nullable|string',
            'peso_total' => 'nullable|numeric',
            'placa' => 'nullable|string',
            'procedencia' => 'nullable|string',
            'deposito' => 'nullable|string',
            'balanza' => 'nullable|string',
            'tolva' => 'nullable|string',
            'guia_transporte' => 'nullable|string',
            'guia_remision' => 'nullable|string',
            'muestreo' => 'nullable|string',
            'preparacion' => 'nullable|string',
            'req_analisis' => 'nullable|string',
            'req_analisis1' => 'nullable|string',
            'fecha_salida' => 'nullable|date',
            'retiro' => 'nullable|string',
            'NroSalida' => 'nullable|string',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $ingreso = Ingreso::findOrFail($id);

        $ingreso->update([
            'estado' => $request->estado,
            'ref_lote' => $request->ref_lote,
            'identificador' => $request->identificador,
            'nom_iden' => $request->nom_iden,
            'peso_total' => $request->peso_total,
            'placa' => $request->placa,
            'procedencia' => $request->procedencia,
            'deposito' => $request->deposito,
            'balanza' => $request->balanza,
            'tolva' => $request->tolva,
            'guia_transporte' => $request->guia_transporte,
            'guia_remision' => $request->guia_remision,
            'muestreo' => $request->muestreo,
            'preparacion' => $request->preparacion,
            'req_analisis' => $request->req_analisis,
            'req_analisis1' => $request->req_analisis1,
            'fecha_salida' => $request->fecha_salida,
            'retiro' => $request->retiro,
            'NroSalida' => $request->NroSalida,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('ingresos.index')->with('success', 'Ingreso actualizado correctamente');
    }

    public function destroy(string $id)
    {
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->delete();
        return redirect()->route('ingresos.index')->with('success', 'Ingreso eliminado exitosamente.');
    }

    public function buscarDocumento(Request $request)
    {
        $documento = $request->input('documento');
        $token = env('APIS_TOKEN');

        $client = new Client([
            'base_uri' => 'https://api.apis.net.pe',
            'verify' => false,
        ]);

        $apiEndpoint = strlen($documento) === 8 ? '/v2/reniec/dni' : '/v2/sunat/ruc';

        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Referer' => 'https://apis.net.pe/api-consulta-ruc',
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
            'query' => ['numero' => $documento],
        ];

        $response = $client->request('GET', $apiEndpoint, $parameters);
        $responseData = json_decode($response->getBody()->getContents(), true);

        return response()->json($responseData);
    }

    public function searchPesos(Request $request)
    {
        $query = $request->input('query');

        $pesos = Peso::where('NroSalida', 'LIKE', "%{$query}%")
                      ->orWhere('Neto', 'LIKE', "%{$query}%")
                      ->orWhere('Placa', 'LIKE', "%{$query}%")
                      ->get();

        return response()->json($pesos);
    }

    public function imprimir($id)
    {
        $ingreso = Ingreso::findOrFail($id);
        return view('ingresos.print', compact('ingreso'));
    }

    public function retirar($id)
    {
        $ingreso = Ingreso::findOrFail($id);

        if (strtolower($ingreso->fase) !== 'ingresado') {
            return response()->json([
                'success' => false,
                'message' => 'Solo se pueden retirar ingresos que estén en fase INGRESADO.'
            ], 400);
        }

        $ingreso->fase = 'RETIRADO';
        $ingreso->fecha_salida = Carbon::now();
        $ingreso->retiro = 'SI';
        $ingreso->lote = 'retirado';
        $ingreso->save();

        return response()->json([
            'success' => true,
            'message' => 'Ingreso retirado correctamente.'
        ]);
    }

    public function lotizar()
    {
        $ingresos = Ingreso::where('estado', '!=', 'CHANCADO')
            ->with(['blendings'])
            ->get();

        $pesoTotal = $ingresos->sum('peso_total');
        $pesoIngresados = $ingresos->where('fase', 'INGRESADO')->sum('peso_total');
        $pesoBlending = $ingresos->where('fase', 'BLENDING')->sum('peso_total');
        $pesoDespachado = $ingresos->where('fase', 'DESPACHADO')->sum('peso_total');
        $pesoEnStock = $pesoIngresados + $pesoBlending ;

        return view('ingresos.lotizacion', compact(
            'ingresos',
            'pesoTotal',
            'pesoIngresados',
            'pesoBlending',
            'pesoDespachado',
            'pesoEnStock'
        ));
    }

    public function chancado()
    {
        $ingresos = Ingreso::where('estado', 'CHANCADO')
            ->with(['blendings'])
            ->get();

        $pesoTotal = $ingresos->sum('peso_total');
        $pesoIngresados = $ingresos->where('fase', 'INGRESADO')->sum('peso_total');
        $pesoBlending = $ingresos->where('fase', 'BLENDING')->sum('peso_total');
        $pesoDespachado = $ingresos->where('fase', 'DESPACHADO')->sum('peso_total');
        $pesoEnStock = $pesoIngresados + $pesoBlending;

        return view('ingresos.chancado', compact(
            'ingresos',
            'pesoTotal',
            'pesoIngresados',
            'pesoBlending',
            'pesoDespachado',
            'pesoEnStock'
        ));
    }

    public function soloChancado(Request $request)
    {
        $base = Ingreso::query()
            ->where('estado', 'CHANCADO');

        // =========================
        // FILTROS
        // =========================
        if ($request->filled('search')) {
            $search = $request->get('search');
            $base->where(function ($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('identificador', 'like', "%{$search}%")
                  ->orWhere('nom_iden', 'like', "%{$search}%")
                  ->orWhere('NroSalida', 'like', "%{$search}%")
                  ->orWhere('lote', 'like', "%{$search}%");
            });
        }

        if ($request->filled('fase')) {
            $base->where('fase', $request->get('fase'));
        }

        // ✅ FILTRO POR FECHAS (fecha_ingreso)
        if ($request->filled('date_from')) {
            $base->whereDate('fecha_ingreso', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $base->whereDate('fecha_ingreso', '<=', $request->date_to);
        }

        // =========================
        // TOTALES (con filtros aplicados)
        // =========================
        $pesoTotal      = (clone $base)->sum('peso_total');
        $pesoIngresados = (clone $base)->where('fase', 'INGRESADO')->sum('peso_total');
        $pesoBlending   = (clone $base)->where('fase', 'BLENDING')->sum('peso_total');
        $pesoDespachado = (clone $base)->where('fase', 'DESPACHADO')->sum('peso_total');
        $pesoRetirado   = (clone $base)->where('fase', 'RETIRADO')->sum('peso_total');
        $pesoEnStock    = $pesoIngresados + $pesoBlending;

        // =========================
        // LISTADO PAGINADO
        // =========================
        $ingresos = (clone $base)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(200)
            ->appends($request->only(['search','fase','date_from','date_to']));

        $fases = Ingreso::where('estado', 'CHANCADO')->select('fase')->distinct()->pluck('fase');

        return view('ingresos.indexsolo', compact(
            'ingresos',
            'pesoTotal',
            'pesoIngresados',
            'pesoBlending',
            'pesoDespachado',
            'pesoRetirado',
            'pesoEnStock',
            'fases'
        ));
    }
}