<?php

namespace App\Http\Controllers;

use App\Models\Requerimiento;
use Illuminate\Http\Request;
use App\Models\Cliente;

class RequerimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    { 
        $this->middleware('permission:ver requerimiento', ['only' => ['index','show']]);
        $this->middleware('permission:crear requerimiento', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar requerimiento', ['only' => ['edit', 'update']]);
    }
     public function index(Request $request)
     {
        // Obtener el valor de búsqueda del formulario
        $searchQuery = $request->input('query');

        // Si hay un valor de búsqueda, realizar la búsqueda en la tabla de Requerimientos
        if ($searchQuery) {
            $requerimientos = Requerimiento::whereHas('cliente', function($query) use ($searchQuery) {
                $query->where('razon_social', 'LIKE', "%$searchQuery%")
                    ->orWhere('datos_cliente', 'LIKE', "%$searchQuery%")
                    ->orWhere('documento_cliente', 'LIKE', "%$searchQuery%")
                    ->orWhere('ruc_empresa', 'LIKE', "%$searchQuery%");
            })->orderBy('created_at', 'desc')->paginate(20);
        } else {
            // Si no hay valor de búsqueda, simplemente obtener todos los requerimientos ordenados por fecha de creación
            $requerimientos = Requerimiento::orderBy("created_at","desc")->paginate(20);
        }

        // Devolver la vista con los resultados de búsqueda o todos los requerimientos
        return view("requerimientos.index", compact("requerimientos"));
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $requerimientos = Requerimiento::all();
        $clientes = Cliente::all(); // Obtener todos los clientes
        $clientesEnlazados = Requerimiento::pluck('cliente_id')->all();
        
        // Filtrar los clientes disponibles
        $clientesDisponibles = $clientes->reject(function ($cliente) use ($clientesEnlazados) {
            return in_array($cliente->id, $clientesEnlazados);
        });
        
        return view("requerimientos.create", compact("requerimientos", "clientesDisponibles", "clientes"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'cliente_id' => 'required|string|max:255',
            'proteccion_au' => 'required|string|max:255',
            'proteccion_ag' => 'required|string|max:255',
            'proteccion_cu' => 'nullable|string|max:255',
            'deduccion_au' => 'nullable|string|max:255',  
            'deduccion_ag' => 'nullable|string|max:255',
            'deduccion_cu' => 'nullable|string|max:255',
            'refinamiento_au' => 'nullable|string|max:255',      
            'refinamiento_ag' => 'nullable|string|max:255',
            'refinamiento_cu' => 'nullable|string|max:255',
            'maquila' => 'nullable|string|max:255',
            'analisis' => 'nullable|string|max:255',
            'estibadores'=> 'nullable|string|max:255',
            'igv'=> 'nullable|string|max:255',
            'penalidad_as'=> 'nullable|string|max:255',
            'penalidad_sb'=> 'nullable|string|max:255',
            'penalidad_pb'=> 'nullable|string|max:255',
            'penalidad_zn'=> 'nullable|string|max:255',
            'penalidad_bi'=> 'nullable|string|max:255',
            'penalidad_hg'=> 'nullable|string|max:255',
            'penalidad_s'=> 'nullable|string|max:255',
            'penalidad_h2o'=> 'nullable|string|max:255',
            'merma'=> 'nullable|string|max:255',
            'pagable_au'=> 'nullable|string|max:255',
            'pagable_ag'=> 'nullable|string|max:255',
            'pagable_cu'=> 'nullable|string|max:255',
            'molienda'=> 'nullable|string|max:255',


        ]);
    $request->validate([
    'cliente_id' => 'nullable|string', // Permitir que el campo sea nulo o vacío
    // Otras reglas de validación para otros campos
]);
        // Crear una nueva instancia de Muestra y asignar los valores
        $requerimiento = new Requerimiento();
        $requerimiento->cliente_id = $request->input('cliente_id');

        $requerimiento->proteccion_au = $request->input('proteccion_au');
        $requerimiento->proteccion_ag = $request->input('proteccion_ag');
        $requerimiento->proteccion_cu = $request->input('proteccion_cu');

        $requerimiento->deduccion_au = $request->input('deduccion_au');
        $requerimiento->deduccion_ag = $request->input('deduccion_ag');
        $requerimiento->deduccion_cu = $request->input('deduccion_cu');

        $requerimiento->refinamiento_au = $request->input('refinamiento_au');
        $requerimiento->refinamiento_ag = $request->input('refinamiento_ag');
        $requerimiento->refinamiento_cu = $request->input('refinamiento_cu');

        $requerimiento->maquila = $request->input('maquila');
        $requerimiento->analisis = $request->input('analisis');
        $requerimiento->estibadores = $request->input('estibadores');
        $requerimiento->molienda = $request->input('molienda');
        $requerimiento->igv = $request->input('igv');

        $requerimiento->penalidad_as = $request->input('penalidad_as');
        $requerimiento->penalidad_sb = $request->input('penalidad_sb');
        $requerimiento->penalidad_pb = $request->input('penalidad_pb');
        $requerimiento->penalidad_zn = $request->input('penalidad_zn');
        $requerimiento->penalidad_bi = $request->input('penalidad_bi');
        $requerimiento->penalidad_hg = $request->input('penalidad_hg');
        $requerimiento->penalidad_s = $request->input('penalidad_s');
        $requerimiento->penalidad_h2o = $request->input('penalidad_h2o');

        $requerimiento->merma = $request->input('merma');

        $requerimiento->pagable_au = $request->input('pagable_au');
        $requerimiento->pagable_ag = $request->input('pagable_ag');
        $requerimiento->pagable_cu = $request->input('pagable_cu');

        
        $requerimiento->save();

        return redirect()->route('requerimientos.index')->with('success','Condicion del cliente creada correctamente');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Requerimiento $requerimiento)
    {
        $clientes = Cliente::all();
        return view('requerimientos.show',compact('requerimiento', 'clientes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $requerimiento = Requerimiento::findOrFail($id);
        return view('requerimientos.edit', compact('requerimiento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         // Validamos la solicitud
         $request->validate([
          //  'cliente_id' => 'nullable|string',
            'proteccion_au' => 'nullable|string',
            'proteccion_ag' => 'nullable|string',
            'proteccion_cu' => 'nullable|string',
            'deduccion_au' => 'nullable|string',
            'deduccion_ag' => 'nullable|string',
            'deduccion_cu' => 'nullable|string',
            'refinamiento_au' => 'nullable|string',
            'refinamiento_ag' => 'nullable|string',
            'refinamiento_cu' => 'nullable|string',
            'maquila' => 'nullable|string',
            'analisis' => 'nullable|string',
            'estibadores' => 'nullable|string',
            'igv' => 'nullable|string' ,
            'penalidad_as'=> 'nullable|string' ,
            'penalidad_sb'=> 'nullable|string' ,
            'penalidad_pb'=> 'nullable|string' ,
            'penalidad_zn'=> 'nullable|string' ,
            'penalidad_bi'=> 'nullable|string' ,
            'penalidad_hg'=> 'nullable|string' ,
            'penalidad_s'=> 'nullable|string' ,
            'penalidad_h2o'=> 'nullable|string' ,
            'merma'=> 'nullable|string' ,
            'pagable_au'=> 'nullable|string' ,
            'pagable_ag'=> 'nullable|string' ,
            'pagable_cu'=> 'nullable|string' ,
            'molienda'=> 'nullable|string' ,
        ]);

        // Obtenemos la muestra que se va a actualizar
        $requerimiento = Requerimiento::findOrFail($id); // Asumiendo que tu modelo se llama Muestra

        // Actualizamos los campos del modelo con los nuevos valores
         
      //  $requerimiento->cliente_id = $request->input('cliente_id');

        $requerimiento->proteccion_au = $request->input('proteccion_au');
        $requerimiento->proteccion_ag = $request->input('proteccion_ag');
        $requerimiento->proteccion_cu = $request->input('proteccion_cu');

        $requerimiento->deduccion_au = $request->input('deduccion_au');
        $requerimiento->deduccion_ag = $request->input('deduccion_ag');
        $requerimiento->deduccion_cu = $request->input('deduccion_cu');

        $requerimiento->refinamiento_au = $request->input('refinamiento_au');
        $requerimiento->refinamiento_ag = $request->input('refinamiento_ag');
        $requerimiento->refinamiento_cu = $request->input('refinamiento_cu');

        $requerimiento->maquila = $request->input('maquila');
        $requerimiento->analisis = $request->input('analisis');
        $requerimiento->estibadores = $request->input('estibadores');
        $requerimiento->molienda = $request->input('molienda');
        $requerimiento->igv = $request->input('igv');

        $requerimiento->penalidad_as = $request->input('penalidad_as');
        $requerimiento->penalidad_sb = $request->input('penalidad_sb');
        $requerimiento->penalidad_pb = $request->input('penalidad_pb');
        $requerimiento->penalidad_zn = $request->input('penalidad_zn');
        $requerimiento->penalidad_bi = $request->input('penalidad_bi');
        $requerimiento->penalidad_hg = $request->input('penalidad_hg');
        $requerimiento->penalidad_s = $request->input('penalidad_s');
        $requerimiento->penalidad_h2o = $request->input('penalidad_h2o');

        $requerimiento->merma = $request->input('merma');

        $requerimiento->pagable_au = $request->input('pagable_au');
        $requerimiento->pagable_ag = $request->input('pagable_ag');
        $requerimiento->pagable_cu = $request->input('pagable_cu');


        // Guardamos los cambios
        $requerimiento->save();
        return redirect()->route('requerimientos.index')->with('editar-requerimiento', 'Requerimiento actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Encuentra el modelo con el ID proporcionado
            $requerimiento = Requerimiento::findOrFail($id);
    
            // Elimina el registro
            $requerimiento->delete();
    
            return redirect()->route('requerimientos.index')->with('eliminar-requerimiento', 'Requerimiento eliminado con éxito.');
        } catch (\Exception $e) {
            // Maneja cualquier excepción que pueda ocurrir
            return redirect()->route('requerimientos.index')->with('error', 'Error al eliminar el requerimiento: ' . $e->getMessage());
        }
    }
}
