<?php

namespace App\Http\Controllers;
use App\Models\Blending;
use App\Models\Ingreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BlendingController extends Controller
{
    /**
     * Display a listing of the resource.
        */
        public function __construct()
        { 
            $this->middleware('permission:ver blending peso', ['only' => ['index','show']]);
            $this->middleware('permission:crear blending peso', ['only' => ['create', 'store']]);
            $this->middleware('permission:editar blending peso', ['only' => ['update','edit']]);
            $this->middleware('permission:eliminar blending peso', ['only' => ['destroy']]);
        }

        public function index(Request $request)
        {
            // Iniciar la consulta con orden por código descendente e incluir relaciones necesarias
            $blendingsQuery = Blending::with(['ingresos', 'user'])->orderBy('cod', 'desc');
            $ingresosQuery = Ingreso::orderBy('codigo', 'desc');
        
            // Verifica si existe un término de búsqueda
            if ($request->filled('search')) {
                $search = trim($request->get('search'));
            
                $blendingsQuery->where(function ($q) use ($search) {
                    $q->where('cod', 'like', "%{$search}%")
                        ->orWhere('lista', 'like', "%{$search}%")
                        ->orWhere('pesoblending', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('ingresos', function ($query) use ($search) {
                            // búsqueda exacta considerando separadores con posibles espacios alrededor
                            $query->where('NroSalida', 'like', "%{$search}%")
                                  ->orWhereRaw("REPLACE(NroSalida, ' ', '') LIKE ?", ["%{$search}%"]);
                        });
                });
            
                // Si también necesitas buscar ingresos directamente:
                $ingresosQuery->where(function ($q) use ($search) {
                    $q->where('codigo', 'like', "%{$search}%")
                        ->orWhere('identificador', 'like', "%{$search}%")
                        ->orWhere('nom_iden', 'like', "%{$search}%")
                        ->orWhere('NroSalida', 'like', "%{$search}%")
                        ->orWhereRaw("REPLACE(NroSalida, ' ', '') LIKE ?", ["%{$search}%"]);
                });
            }
        
            // Obtener resultados con paginación
            $blendings = $blendingsQuery->paginate(50);
            $ingresos = $ingresosQuery->paginate(50);
        
            // Verifica si hay algún blending con estado 'inactivo'
            $despachoVisible = !$blendings->contains('estado', 'inactivo');
        
            // Retornar la vista con los datos
            return view('blendings.index', compact('blendings', 'ingresos', 'despachoVisible'));
        }

        
        
    
        public function create()
        {
            // Obtener los ingresos que no están en un blending
            $ingresos = Ingreso::whereNotIn('id', function ($query) {
                $query->select('ingreso_id')
                    ->from('blending_ingreso') // Tabla intermedia
                    ->distinct();
            })
            // Excluir ingresos retirados
            ->where('lote', '!=', 'retirado')
            // Asegurar que ubicacion sea numérica (opcional, pero recomendado)
            ->whereRaw('lote REGEXP "^[0-9]+$"')
            ->orderBy('created_at', 'desc')
            ->get();
        
            // Obtener los lotes únicos para mostrar
            $lotesRegistrados = Ingreso::pluck('lote')->unique()->toArray();
        
            return view('blendings.create', compact('ingresos', 'lotesRegistrados'));
        }        
        
        public function store(Request $request)
            {
                $request->validate([
                    'lista' => 'required',
                    'cod' => 'nullable|string',
                    'notas' => 'nullable|string',
                    'ingresos' => 'required|array',
                    'ingresos.*' => 'exists:ingresos,id',
                    'lote' => 'required|integer', // Añade la validación para el lote
                    'pesoblending' =>  'nullable|string',
                ]);
            
                try {
                    DB::beginTransaction();
            
                    $ingresos = Ingreso::whereIn('id', $request->ingresos)->get();
                    
                    $blending = Blending::create([
                        'cod' => $request->cod,
                        'lista' => $request->lista,
                        'notas' => $request->notas,
                        'pesoblending' => $ingresos->sum('peso_total'), 
                        'user_id' => auth()->id(),
                        'detalles' => json_encode($ingresos), 
                    ]);
            
                    // Actualiza la fase a BLENDING y establece el lote
                    Ingreso::whereIn('id', $request->ingresos)->update(['fase' => 'BLENDING', 'lote' => $request->lote]); // Asigna el lote aquí
                    $blending->ingresos()->attach($ingresos->pluck('id'));
            
                    DB::commit();
                    return redirect()->route('blendings.index')->with('success', 'Blending creado con éxito.');
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Error creating blending: ' . $e->getMessage()); // Log the error
                    return redirect()->back()->withErrors(['error' => 'Ocurrió un error al crear el blending.']);
                }
            }
            

        

    public function show($id)
        {
            $blending = Blending::with('ingresos')->findOrFail($id); // Cargar el blending con los ingresos asociados
            return view('blendings.show', compact('blending'));
        }

        public function edit($id)
        {
            // Obtener el blending que se está editando, incluyendo los ingresos asociados
            $blending = Blending::with('ingresos')->findOrFail($id);
        
            // Obtener los IDs de los ingresos que ya están en un blending
            $ingresosUsados = Blending::with('ingresos')->get()->flatMap(function ($blending) {
                return $blending->ingresos->pluck('id');
            })->toArray();
        
            // Obtener los ingresos que no están en un blending
            $ingresos = Ingreso::whereNotIn('id', $ingresosUsados)->get();
        
            // Obtener los lotes registrados desde los ingresos no utilizados
            $lotesRegistrados = $ingresos->pluck('lote')->unique()->toArray();
        
            return view('blendings.edit', compact('blending', 'ingresos', 'lotesRegistrados'));
        }
        

    public function update(Request $request, $id)
    {
        // Validar los datos    
        $request->validate([
            'lista' => 'required|string|max:255',
            'cod' => 'required|string|max:100',
            'notas' => 'nullable|string',
        ]);

        // Encontrar el blending y actualizarlo
        $blending = Blending::findOrFail($id);
        $blending->lista = $request->lista; // Asignar nuevo valor
        $blending->notas = $request->notas; // Asignar nuevo valor
        $blending->save(); // Guardar cambios

        // Redirigir a la lista con un mensaje de éxito
        return redirect()->route('blendings.index')->with('success', 'Blending actualizado correctamente.');
    }   

public function destroy(string $id)
{
    // Carga primero para validar estado sin abrir transacción
    $blending = Blending::with('ingresos')->findOrFail($id);

    // 🔒 Regla: no permitir eliminar si está inactivo
    if ($blending->estado === 'inactivo') {
        return redirect()
            ->route('blendings.index')
            ->with('error', 'No se puede eliminar un blending INACTIVO.');
    }

    try {
        DB::transaction(function () use ($blending) {
            $ingresos = $blending->ingresos; // colección de modelos Ingreso

            // Lotes ya ocupados globalmente
            $lotesOcupados = Ingreso::whereNotNull('lote')
                ->pluck('lote')
                ->map(fn($v) => (int)$v)
                ->toArray();

            // Genera un pool amplio para evitar quedarte corto (200 mínimo)
            $cantidadNecesaria = max(0, $ingresos->count());
            $maxPool = max(200, count($lotesOcupados) + $cantidadNecesaria + 10);
            $pool = range(1, $maxPool);

            // Lotes disponibles
            $lotesDisponibles = array_values(array_diff($pool, $lotesOcupados));

            // Reasigna fase y lotes (si no alcanza, pon null en los restantes)
            foreach ($ingresos as $index => $ingreso) {
                $ingreso->fase = 'INGRESADO';
                $ingreso->lote = $lotesDisponibles[$index] ?? null; // no bloquea si no hay más
                $ingreso->save();
            }

            // Rompe la relación en el pivot SOLO de este blending
            // Si tienes relación belongsToMany definida, podrías usar: $blending->ingresos()->detach();
            DB::table('blending_ingreso')
                ->where('blending_id', $blending->id)
                ->delete();

            // Elimina el blending (soft/hard según tu modelo)
            $blending->delete();
        });

        return redirect()
            ->route('blendings.index')
            ->with('success', 'Blending eliminado. Ingresos actualizados (fase = INGRESADO) y lotes reasignados si habían disponibles.');
    } catch (\Throwable $e) {
        return redirect()
            ->back()
            ->withErrors(['error' => 'No se pudo eliminar: ' . $e->getMessage()]);
    }
}

    }

