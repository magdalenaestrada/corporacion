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
        //ultimo permiso
        $this->middleware('permission:retirar lote', ['only' => ['retirar']]);
        
    }
    public function index(Request $request)
    {
        $query = Ingreso::where('estado', '!=', 'CHANCADO')->orderBy('fecha_ingreso', 'desc');

    
        // Filtros
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
    
        // Obtener ingresos y paginar
        $ingresos = $query->paginate(200);
    
        // Obtener todas las fases disponibles
        $fases = Ingreso::select('fase')->distinct()->pluck('fase');
    
        // Calcular pesos por fase
       $pesoTotal = Ingreso::where('estado', '!=', 'CHANCADO')->sum('peso_total');
        $pesoIngresados = Ingreso::where('fase', 'ingresado')->where('estado', '!=', 'CHANCADO')->sum('peso_total');
        $pesoBlending = Ingreso::where('fase', 'blending')->where('estado', '!=', 'CHANCADO')->sum('peso_total');
        $pesoDespachado = Ingreso::where('fase', 'despachado')->where('estado', '!=', 'CHANCADO')->sum('peso_total');
        $pesoRetirado = Ingreso::where('fase', 'retirado')->where('estado', '!=', 'CHANCADO')->sum('peso_total');
        // Peso en stock = Ingresado + Blending (excluyendo Despachado)
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
    
    /**
     * Show the form for creating a new resource.
     */
    
    public function create(Request $request)
    {
        $ingresos = Ingreso::all(); 
        $user = Auth::user();
        $search = $request->input('search', '');
        
        // Obtener todos los números de salida de ingresos existentes
        $nrosSalidaRegistrados = Ingreso::pluck('NroSalida')->map(function ($item) {
        return explode('/', trim($item)); // Divide cada NroSalida por '/'
        })->flatten()->unique()->toArray(); // Aplanar y obtener valores únicos

        // Obtener todos los lotes ya registrados
        $lotesRegistrados = Ingreso::pluck('lote')->unique()->toArray();
    
        // Obtener registros de Pesos con paginación, búsqueda y orden descendente, excluyendo los que ya están registrados
        $pesos = Peso::when($search, function ($query, $search) {
            return $query->where('NroSalida', 'like', "%{$search}%");
        })
        ->whereNotIn('NroSalida', $nrosSalidaRegistrados) // Excluir todos los números de salida ya registrados
        ->orderBy('NroSalida', 'desc')
        ->paginate(perPage: 800);
    
        return view('ingresos.create', compact('ingresos', 'pesos', 'search', 'user', 'lotesRegistrados'));
    }
    
   public function store(Request $request)
{
    // ============================================================
    // NORMALIZAR PESO_TOTAL: convertir "1.088.560" => "1088.560"
    // ============================================================
    if ($request->filled('peso_total')) {

        // Ejemplo recibido: "1.088.560"
        $raw = $request->peso_total;

        // Eliminar todo lo que NO sea dígito: "1088560"
        $digits = preg_replace('/\D/', '', $raw);

        // Si tiene más de 3 dígitos, los últimos 3 son decimales
        if (strlen($digits) > 3) {
            $normalized = substr($digits, 0, -3) . '.' . substr($digits, -3);
        } else {
            // Si tiene 3 dígitos o menos, es solo parte decimal
            $normalized = '0.' . str_pad($digits, 3, '0', STR_PAD_LEFT);
        }

        // Reemplazar el valor normalizado en el request
        $request->merge([
            'peso_total' => $normalized
        ]);
    }

    // ============================================================
    // VALIDACIÓN ORIGINAL
    // ============================================================
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

    // ============================================================
    // GUARDADO ORIGINAL (sin tocar)
    // ============================================================
    $ingreso = new Ingreso();
    $ingreso->codigo = $request->codigo;
    $ingreso->fecha_ingreso = $request->fecha_ingreso;
    $ingreso->estado = $request->estado;
    $ingreso->ref_lote = $request->ref_lote;
    $ingreso->identificador = $request->identificador;
    $ingreso->nom_iden = $request->nom_iden;
    $ingreso->peso_total = $request->peso_total; // YA LLEGA NORMALIZADO
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
    
    
    
    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $ingreso = Ingreso::findOrFail($id);
    return view('ingresos.show', compact('ingreso'));
}

    
        // Mostrar el formulario de edición
        public function edit($id)
        {
            // Buscar el ingreso por su id
            $ingreso = Ingreso::findOrFail($id);
    
            // Devolver la vista con el ingreso a editar
            return view('ingresos.edit', compact('ingreso'));
        }
    
        // Actualizar el registro de ingreso
        public function update(Request $request, $id)
        {
            // Validar los datos recibidos
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
    
            // Buscar el ingreso a actualizar
            $ingreso = Ingreso::findOrFail($id);
    
            // Actualizar los campos del ingreso
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
                'descripcion' =>  $request->descripcion,
            ]);
    
            // Redirigir a la lista de ingresos con un mensaje de éxito
            return redirect()->route('ingresos.index')->with('success', 'Ingreso actualizado correctamente');
        }
    



    public function destroy(string $id)
    {
        // Buscar el ingreso por su ID
        $ingreso = Ingreso::findOrFail($id);
    
        // Eliminar el ingreso
        $ingreso->delete();
    
        // Redireccionar con un mensaje
        return redirect()->route('ingresos.index')->with('success', 'Ingreso eliminado exitosamente.');
    }
    
    public function buscarDocumento(Request $request)
    {
        $documento = $request->input('documento');

        $token = env('APIS_TOKEN');

        // Configurar el cliente GuzzleHttp
        $client = new Client([
            'base_uri' => 'https://api.apis.net.pe',
            'verify' => false,
        ]);

        // Determinar si es DNI o RUC
        $apiEndpoint = strlen($documento) === 8 ? '/v2/reniec/dni' : '/v2/sunat/ruc';

        // Configurar los parámetros de la solicitud
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

        // Realizar la solicitud a la API
        $response = $client->request('GET', $apiEndpoint, $parameters);

        // Obtener los datos de respuesta como un arreglo
        $responseData = json_decode($response->getBody()->getContents(), true);

        // Devolver la respuesta o realizar otras acciones según tus necesidades
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

    // Verificar si la fase actual es INGRESADO (en mayúsculas o minúsculas, según se guarda)
    if (strtolower($ingreso->fase) !== 'ingresado') {
        return response()->json([
            'success' => false,
            'message' => 'Solo se pueden retirar ingresos que estén en fase INGRESADO.'
        ], 400); // Código 400 = Bad Request
    }

    // Cambiar la fase a RETIRADO
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
    // Filtrar ingresos cuyo estado NO sea 'CHANCADO'
    $ingresos = Ingreso::where('estado', '!=', 'CHANCADO')
        ->with(['blendings']) // Si existe la relación blendings
        ->get();

    // Calcular pesos por fase
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
        ->with(['blendings']) // solo si la relación existe
        ->get();

    // Calcular pesos por fase
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
    $query = Ingreso::where('estado', 'CHANCADO');

    // Búsqueda
    if ($request->has('search')) {
        $search = $request->get('search');
        $query->where(function ($q) use ($search) {
            $q->where('codigo', 'like', "%$search%")
              ->orWhere('identificador', 'like', "%$search%")
              ->orWhere('nom_iden', 'like', "%$search%");
        });
    }

    // Filtro por fase
    if ($request->filled('fase')) {
        $query->where('fase', $request->get('fase'));
    }
    $query->orderBy('created_at', 'desc');
    $ingresos = $query->with('user')->paginate(15);

    // Cálculos
    $pesoTotal = $ingresos->sum('peso_total');
    $pesoIngresados = $ingresos->where('fase', 'INGRESADO')->sum('peso_total');
    $pesoBlending = $ingresos->where('fase', 'BLENDING')->sum('peso_total');
    $pesoDespachado = $ingresos->where('fase', 'DESPACHADO')->sum('peso_total');
    $pesoRetirado = $ingresos->where('fase', 'RETIRADO')->sum('peso_total');
    $pesoEnStock = $pesoIngresados + $pesoBlending ;

    $fases = Ingreso::select('fase')->distinct()->pluck('fase');

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
