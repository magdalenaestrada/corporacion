<?php

namespace App\Http\Controllers;


use App\Models\Liquidacion;
use App\Models\Cliente;
use App\Models\Muestra;
use App\Models\Resumen;
use App\Models\Ingreso;
use App\Models\FacturaLiquidacion;
use App\Models\Peso;
use App\Models\User;
use App\Models\Requerimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LiquidacionController extends Controller
{    
    public function __construct()
    { 
        $this->middleware('permission:ver liquidacion', ['only' => ['index','show','print']]);
        $this->middleware('permission:create liquidacion', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar liquidacion', ['only' => ['update','edit']]);
        $this->middleware('permission:eliminar liquidacion', ['only' => ['destroy']]);
        $this->middleware('permission:cierre liquidacion', ['only' => ['duplicate']]);
    }

        public function duplicate(Request $request, $id)
        {
            try {
                // Encuentra el registro original, incluyendo la muestra relacionada
                $original = Liquidacion::with('muestra')->findOrFail($id);
                
                // Variable para la muestra duplicada
                $duplicadaMuestra = null;
        
                // Duplica la muestra asociada si existe
                if ($original->muestra) {
                    $duplicadaMuestra = $original->muestra->replicate();
                    $duplicadaMuestra->codigo .= 'MOD'; // Agrega la extensión al código
                    $duplicadaMuestra->est = 'cierre'; // Establece el estado a provisional
                    $duplicadaMuestra->save();
                }
        
                // Duplica la liquidación y asocia con la nueva muestra duplicada
                $duplicate = $original->replicate();
                $duplicate->muestra_id = $duplicadaMuestra ? $duplicadaMuestra->id : null; // Asegura la relación
                $duplicate->estado = 'CIERRE'; // Establece el estado a cierre
                $duplicate->save();
        
                // Log para verificar IDs
                Log::info('Original Muestra ID: ', ['muestra_id' => $original->muestra_id]);
                Log::info('Duplicada Muestra: ', ['duplicada' => $duplicadaMuestra ? $duplicadaMuestra->id : 'No hay muestra duplicada']);
                Log::info('Duplicada Liquidacion ID: ', ['duplicate_id' => $duplicate->id]);
        
                // Actualiza el campo 'estado' en la tabla 'liquidaciones' solo si es necesario
                $original->update(['estado' => 'PROVISIONAL']);
        
                // Redirige de vuelta con un mensaje de éxito
                return redirect()->back()->with('success', 'Registro duplicado exitosamente y estado actualizado a provisional en liquidaciones y muestras!');
            } catch (\Exception $e) {
                // Maneja errores y redirige con un mensaje de error
                Log::error('Error duplicando registro: ' . $e->getMessage(), ['exception' => $e]);
                return redirect()->back()->with('error', 'Error al duplicar el registro: ' . $e->getMessage());
            }
        }
    
    
public function index(Request $request)
{
    $clientes = Cliente::orderBy('documento_cliente')->get();
    $muestras = Muestra::orderBy('codigo')->get();

    // Consulta principal con filtros si existen
   $query = Liquidacion::with(['muestra', 'cliente', 'user', 'lastEditor']);

    // 🔍 Búsqueda general
    if ($search = $request->input('search')) {
        $query->where(function($query) use ($search) {
            $query->whereHas('muestra', function($query) use ($search) {
                $query->where('codigo', 'like', "%{$search}%");
            })
            ->orWhereHas('cliente', function($query) use ($search) {
                $query->where('datos_cliente', 'like', "%{$search}%");
            })
            ->orWhereHas('lastEditor', fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->orWhere('peso', 'like', "%{$search}%")
            ->orWhere('producto', 'like', "%{$search}%")
            ->orWhere('comentario', 'like', "%{$search}%")
            ->orWhere('NroSalida', 'like', "%{$search}%")
            ;
        });
    }

    // 🔍 Filtro por estado de liquidación
    if ($request->estado === 'SIN CIERRE') {
        $query->whereNull('estado');
    } elseif ($request->estado) {
        $query->where('estado', $request->estado);
    }

    // ✅ Filtro por producto
    if ($request->filled('producto')) {
        $query->where('producto', $request->producto);
    }
    if ($request->filled('editor_id')) {
        $query->where('ultimo_editor_id', $request->integer('editor_id'));
    }
    // Paginar resultados visibles en tabla
    $liquidaciones = $query->orderBy('created_at', 'desc')
        ->paginate(20)
        ->appends($request->only(['search', 'estado', 'producto', 'editor', 'editor_id']));

    // 🔥 Totales globales
    $totalCierre = Liquidacion::where('estado', 'CIERRE')->count();
    $totalProvisional = Liquidacion::where('estado', 'PROVISIONAL')->count();
    $totalSinCierre = Liquidacion::where(function ($query) {
        $query->whereNotIn('estado', ['CIERRE', 'PROVISIONAL'])
              ->orWhereNull('estado')
              ->orWhere('estado', '');
    })->count();

    $conteoCierres = Liquidacion::where('estado', 'CIERRE')
        ->with('lastEditor')
        ->get()
        ->groupBy(function ($item) {
            return $item->lastEditor->name ?? 'N/A';
        })
        ->map(function ($items, $name) {
            return [
                'name' => $name,
                'count' => $items->count(),
            ];
        })
        ->sortByDesc('count')
        ->values();

    return view('liquidaciones.index', compact(
        'liquidaciones',
        'clientes',
        'muestras',
        'totalCierre',
        'totalProvisional',
        'totalSinCierre',
        'conteoCierres'
    ));
}
        
    


    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    // Obtener todas las muestras que no tienen una liquidación asociada
    $muestras = Muestra::whereNotExists(function ($query) {
        $query->select(DB::raw(1))
              ->from('liquidaciones')
              ->whereColumn('liquidaciones.muestra_id', 'muestras.id');
    })->orderBy('codigo')->get();
    
    // Obtener los resúmenes que no tienen una liquidación asociada
    $resumens = Resumen::whereNotExists(function ($query) { 
        $query->select(DB::raw(1))
              ->from('liquidaciones')
              ->whereColumn('liquidaciones.resumen_id', 'resumens.id');
    })->orderBy('id')->get();

    // Obtener los ingresos que no tienen una liquidación asociada
    $ingresos = Ingreso::whereNotIn('NroSalida', function ($query) {
        $query->select('NroSalida')
              ->from('liquidaciones')
              ->whereNotNull('NroSalida'); // Solo considerar NroSalida que ya fueron usados
    })->orderBy('NroSalida')->get();

    // Obtener los clientes que tienen al menos un requerimiento asociado
    $clientes = Cliente::whereHas('requerimientos')->orderBy('documento_cliente')->get();

    // Obtener los requerimientos ordenados por cliente_id
    $requerimientos = Requerimiento::orderBy('cliente_id')->get();

    return view('liquidaciones.create', compact('clientes', 'requerimientos', 'muestras', 'resumens', 'ingresos'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los campos recibidos en la solicitud
        $validatedData = $request->validate([
            'muestra_id' => 'required|string|max:255',
            'cliente_id' => 'required|string|max:255',
            'resumen_id' => 'nullable|string',
            'peso' => 'required|string|max:255',
            'lote' => 'required|string|max:255',
            'producto' => 'required|string|max:255',
            'cotizacion_au' => 'required|string|max:255',
            'cotizacion_ag' => 'required|string|max:255',
            'cotizacion_cu' => 'required|string|max:255',
            'tms'=> 'nullable|string',
            'tmns'=> 'nullable|string',
            'ley_au'=> 'nullable|string',
            'formula_au'=> 'nullable|string',
            'precio_au'=> 'nullable|string',
            'val_au'=> 'nullable|string',
            'ley_ag'=> 'nullable|string',
            'formula_ag'=> 'nullable|string',
            'precio_ag'=> 'nullable|string',
            'val_ag'=> 'nullable|string',
            'ley_cu'=> 'nullable|string',
            'formula_cu'=> 'nullable|string',
            'precio_cu'=> 'nullable|string',
            'val_cu'=> 'nullable|string',
            'total_valores'=> 'nullable|string',
            'formula_fi_au'=> 'nullable|string',
            'fina_au'=> 'nullable|string',
            'formula_fi_ag'=> 'nullable|string',
            'fina_ag'=> 'nullable|string',
            'formula_fi_cu'=> 'nullable|string',
            'fina_cu'=> 'nullable|string',
            'total_deducciones'=> 'nullable|string',
            'total_as'=> 'nullable|string',
            'total_sb'=> 'nullable|string',
            'total_pb'=> 'nullable|string',
            'total_bi'=> 'nullable|string',
            'total_hg'=> 'nullable|string',
            'total_s'=> 'nullable|string',
            'total_penalidades'=> 'nullable|string',
            'total_us'=> 'nullable|string',
            'valorporlote'=> 'nullable|string',
            'valor_igv'=> 'nullable|string',
            'total_porcentajeliqui'=> 'nullable|string',
            'saldo'=> 'nullable|string',
            'detraccion'=> 'nullable|string',
            'total_liquidacion'=> 'nullable|string',
            'procesoplanta'=> 'nullable|string',
            'adelantosextras'=> 'nullable|string',
            'prestamos'=> 'nullable|string',
            'otros_descuentos'=> 'nullable|string',
            'total'=> 'nullable|string',
            'transporte'=> 'nullable|string',
            'comentario'=> 'nullable|string',
            'molienda'=> 'nullable|string',
            'resultadomolienda'=> 'nullable|string',
            'resultadoestibadores'=> 'nullable|string',
            'dolar'=> 'nullable|string',
            'division'=> 'nullable|string',
            'proteccion_au2'=> 'nullable|string',
            'proteccion_ag2'=> 'nullable|string',
            'proteccion_cu2'=> 'nullable|string',
            'pagable_au2'=> 'nullable|string',
            'pagable_ag2'=> 'nullable|string',
            'pagable_cu2'=> 'nullable|string',
            'deduccion_au2'=> 'nullable|string',
            'deduccion_ag2'=> 'nullable|string',
            'deduccion_cu2'=> 'nullable|string',
            'refinamiento_au2'=> 'nullable|string',
            'refinamiento_ag2'=> 'nullable|string',
            'refinamiento_cu2'=> 'nullable|string',
            'maquila2'=> 'nullable|string',
            'analisis2'=> 'nullable|string',
            'estibadores2'=> 'nullable|string',
            'molienda2'=> 'nullable|string',
            'igv2'=> 'nullable|string',
            'penalidad_as2'=> 'nullable|string',
            'penalidad_sb2'=> 'nullable|string',
            'penalidad_pb2'=> 'nullable|string',
            'penalidad_zn2'=> 'nullable|string',
            'penalidad_bi2'=> 'nullable|string',
            'penalidad_hg2'=> 'nullable|string',
            'penalidad_s2'=> 'nullable|string',
            'penalidad_h2o2'=> 'nullable|string',
            'merma2'=> 'nullable|string',
            'NroSalida'=> 'nullable|string',
            'fechai' => 'nullable|string',
        ]);
        


        // Crear y guardar la nueva liquidación
        // Verificar si la muestra ya está registrada
        $existingLiquidacion = Liquidacion::where('muestra_id', $validatedData['muestra_id'])->exists();
        if ($existingLiquidacion) {
            return redirect()->back()->withInput()->with('error', 'La muestra ya está registrada en otra liquidación');
        }
        
        // Verificar si el resumen ya está registrado
        if (isset($validatedData['resumen_id'])) {
            $existingLiquidacion = Liquidacion::where('resumen_id', $validatedData['resumen_id'])->exists();
            if ($existingLiquidacion) {
                return redirect()->back()->withInput()->with('error', 'El resumen ya está registrado en otra liquidación');
            }
        }

        // Asignar el usuario autenticado al campo usuario_id
        $validatedData['usuario_id'] = auth()->id();
        
        // Crear y guardar la nueva liquidación
        $liquidacion = Liquidacion::create($validatedData);
        
        return redirect()->route('liquidaciones.index')->with('success', 'Liquidación creada correctamente');
    }
    
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $liquidacion = Liquidacion::with('muestra','cliente','facturas','ingreso')->findOrFail($id);
        $ingresos = Ingreso::all();
        return view('liquidaciones.show', compact('liquidacion','ingresos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
public function edit($id)
{
    // Obtener la liquidación que se va a editar
    $liquidacion = Liquidacion::with(['muestra', 'resumen', 'cliente', 'facturas'])
        ->findOrFail($id);

    $this->authorize('update', $liquidacion); // ⛔️ 403 si no cumple

    $ingresos = Ingreso::all();

    // Relaciones asociadas
    $muestra = $liquidacion->muestra ?? null;
    $resumen = $liquidacion->resumen ?? null;
    $cliente = $liquidacion->cliente ?? null;

    // 🔹 NUEVO: Obtener la descripción del ingreso relacionado
    // usando el campo NroSalida como vínculo
    $descripcionIngreso = \App\Models\Ingreso::where('NroSalida', $liquidacion->NroSalida)
        ->value('descripcion');

    // (opcional: obtener más campos)
    // $ingresoRelacionado = \App\Models\Ingreso::where('NroSalida', $liquidacion->NroSalida)->first();

    // Listas para selects
    $muestras = Muestra::when($muestra, fn($q) => $q->where('id', '<>', $muestra->id))
        ->orderBy('codigo')->get();

    $resumens = Resumen::when($resumen, fn($q) => $q->where('id', '<>', $resumen->id))
        ->orderBy('id')->get();

    $clientes = Cliente::when($cliente, fn($q) => $q->where('id', '<>', $cliente->id))
        ->orderBy('documento_cliente')->get();

    // 🔹 Pasar la descripción a la vista
    return view('liquidaciones.edit', compact(
        'liquidacion',
        'muestra',
        'resumen',
        'cliente',
        'muestras',
        'resumens',
        'clientes',
        'ingresos',
        'descripcionIngreso'
    ));
}
    
    
public function update(Request $request, string $id)
{
    //dd($request->all());
    // Validación de los campos de liquidación
    $liquidacionData = $request->validate([
        'peso' => 'nullable|string',
        'lote' => 'nullable|string',
        'producto' => 'nullable|string',
        'cotizacion_au' => 'nullable|string',
        'cotizacion_ag' => 'nullable|string',
        'cotizacion_cu' => 'nullable|string',
        'tms' => 'nullable|string',
        'tmns' => 'nullable|string',
        'ley_au' => 'nullable|string',
        'formula_au' => 'nullable|string',
        'precio_au' => 'nullable|string',
        'val_au' => 'nullable|string',
        'ley_ag' => 'nullable|string',
        'formula_ag' => 'nullable|string',
        'precio_ag' => 'nullable|string',
        'val_ag' => 'nullable|string',
        'ley_cu' => 'nullable|string',
        'formula_cu' => 'nullable|string',
        'precio_cu' => 'nullable|string',
        'val_cu' => 'nullable|string',
        'total_valores' => 'nullable|string',
        'formula_fi_au' => 'nullable|string',
        'fina_au' => 'nullable|string',
        'formula_fi_ag' => 'nullable|string',
        'fina_ag' => 'nullable|string',
        'formula_fi_cu' => 'nullable|string',
        'fina_cu' => 'nullable|string',
        'total_deducciones' => 'nullable|string',
        'total_as' => 'nullable|string',
        'total_sb' => 'nullable|string',
        'total_pb' => 'nullable|string',
        'total_bi' => 'nullable|string',
        'total_hg' => 'nullable|string',
        'total_s' => 'nullable|string',
        'total_penalidades' => 'nullable|string',
        'total_us' => 'nullable|string',
        'valorporlote' => 'nullable|string',
        'valor_igv' => 'nullable|string',
        'total_porcentajeliqui' => 'nullable|string',
        'saldo' => 'nullable|string',
        'detraccion' => 'nullable|string',
        'total_liquidacion' => 'nullable|string',
        'procesoplanta' => 'nullable|string',
        'adelantosextras' => 'nullable|string',
        'prestamos' => 'nullable|string',
        'pendientes' => 'nullable|string',
        'otros_descuentos' => 'nullable|string',
        'total' => 'nullable|string',
        'transporte' => 'nullable|string',
        'comentario' => 'nullable|string',
        'resultadomolienda' => 'nullable|string',
        'resultadoestibadores' => 'nullable|string',
        'dolar' => 'nullable|string',
        'division' => 'nullable|string',
        'proteccion_au2'=> 'nullable|string',
        'proteccion_ag2'=> 'nullable|string',
        'proteccion_cu2'=> 'nullable|string',
        'pagable_au2'=> 'nullable|string',
        'pagable_ag2'=> 'nullable|string',
        'pagable_cu2'=> 'nullable|string',
        'deduccion_au2'=> 'nullable|string',
        'deduccion_ag2'=> 'nullable|string',
        'deduccion_cu2'=> 'nullable|string',
        'refinamiento_au2'=> 'nullable|string',
        'refinamiento_ag2'=> 'nullable|string',
        'refinamiento_cu2'=> 'nullable|string',
        'maquila2'=> 'nullable|string',
        'analisis2'=> 'nullable|string',
        'estibadores2'=> 'nullable|string',
        'molienda2'=> 'nullable|string',
        'igv2'=> 'nullable|string',
        'penalidad_as2'=> 'nullable|string',
        'penalidad_sb2'=> 'nullable|string',
        'penalidad_pb2'=> 'nullable|string',
        'penalidad_zn2'=> 'nullable|string',
        'penalidad_bi2'=> 'nullable|string',
        'penalidad_hg2'=> 'nullable|string',
        'penalidad_s2'=> 'nullable|string',
        'penalidad_h2o2'=> 'nullable|string',
        'merma2'=> 'nullable|string',
        'adelantos' => 'nullable|numeric', // Validación para el campo adelantos
        'adelantosData' => 'nullable|string', // Validación para la lista de facturas
    ]);

    // Obtener la liquidación
    $liquidacion = Liquidacion::findOrFail($id);
    $this->authorize('update', $liquidacion); // ⛔️ 403 si no cumple
    // Log para verificar que se obtiene la liquidación correcta
    Log::info('Actualizando Liquidación ID: ' . $id, $liquidacionData);

    // Establecer el ID del último editor antes de actualizar
    $liquidacionData['ultimo_editor_id'] = auth()->id();

    // Actualizar la liquidación
    $liquidacion->update($liquidacionData);

    // Guardar la suma total en adelantos
    $liquidacion->adelantos = $request->adelantos;
    $liquidacion->save();

   // Log para verificar si 'adelantosData' llega correctamente
Log::info('Datos recibidos en adelantosData:', ['data' => $request->adelantosData]);

if ($request->filled('adelantosData')) {
    $adelantos = json_decode($request->adelantosData, true);

    if (!$adelantos) {
        Log::error('Error decodificando adelantosData:', ['data' => $request->adelantosData]);
        return back()->withErrors(['error' => 'Los datos de adelantos no son válidos.']);
    }

    Log::info('Adelantos procesados:', $adelantos);

    // Obtener IDs de adelantos existentes
    $idsExistentes = FacturaLiquidacion::where('liquidacion_id', $id)->pluck('id')->toArray();

    foreach ($adelantos as $adelanto) {
        if (!empty($adelanto['id'])) {
            // ✅ Si el adelanto ya tiene ID, solo lo actualizamos
            FacturaLiquidacion::where('id', $adelanto['id'])
                ->update([
                    'factura_numero' => $adelanto['referencia'],
                    'monto' => $adelanto['monto'],
                    'updated_at' => now(),
                ]);

            // Eliminamos de la lista de IDs existentes
            if (($key = array_search($adelanto['id'], $idsExistentes)) !== false) {
                unset($idsExistentes[$key]);
            }
        } else {
            // ✅ Si no tiene ID, significa que es nuevo, lo creamos
            $nuevoAdelanto = FacturaLiquidacion::create([
                'liquidacion_id' => $id,
                'factura_numero' => $adelanto['referencia'],
                'monto' => $adelanto['monto'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            Log::info('Nuevo Adelanto Creado:', $nuevoAdelanto->toArray());
        }
    }

    // 🔥 Borrar solo los adelantos que ya no están en la lista actualizada
    if (!empty($idsExistentes)) {
        FacturaLiquidacion::whereIn('id', $idsExistentes)->delete();
        Log::info('Adelantos eliminados:', $idsExistentes);
    }
}


    // Validación de los campos de muestra
    $muestraData = $request->validate([
        'codigo' => 'nullable|string',
        'au' => 'nullable|string',
        'ag' => 'nullable|string',
        'cu' => 'nullable|string',
        'as' => 'nullable|string',
        'sb' => 'nullable|string',
        'pb' => 'nullable|string',
        'zn' => 'nullable|string',
        'bi' => 'nullable|string',
        'hg' => 'nullable|string',
        's' => 'nullable|string',
        'humedad' => 'nullable|string',
        'obs' => 'nullable|string',
    ]);

    $muestra = Muestra::findOrFail($liquidacion->muestra_id);
    
    // Log para verificar la actualización de muestra
    Log::info('Actualizando Muestra ID: ' . $muestra->id, $muestraData);
    
    // Actualiza la muestra
    $muestra->update($muestraData); 

    return redirect()->route('liquidaciones.index')->with('success', 'Liquidación y adelantos actualizados correctamente');
}


    public function destroy($id)
{
    // Encuentra la liquidación por ID
    $liquidacion = Liquidacion::findOrFail($id);

    // Guarda los datos relacionados con la muestra y resumen
    $muestraId = $liquidacion->muestra_id;
    $resumenId = $liquidacion->resumen_id;
    $NroSalida = $liquidacion->NroSalida;
    // Elimina la liquidación
    $liquidacion->delete();

    // Opcional: Aquí puedes manejar la liberación de los registros relacionados,
    // como la actualización de la tabla `muestra` y `resumen`, si es necesario.

    return redirect()->route('liquidaciones.index')->with('success', 'Liquidación eliminada correctamente');
}
public function print($id)
{
    $liquidacion = Liquidacion::with(['muestra', 'cliente', 'facturas', 'ingreso'])
        ->findOrFail($id);

    return view('liquidaciones.print', compact('liquidacion'));
}

}