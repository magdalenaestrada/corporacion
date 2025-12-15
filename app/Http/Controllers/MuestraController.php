<?php

namespace App\Http\Controllers;

use App\Models\Muestra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class MuestraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    { 
        $this->middleware('permission:ver muestra', ['only' => ['index','show','print']]);
        $this->middleware('permission:crear muestra', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar muestra', ['only' => ['update','edit']]);
        $this->middleware('permission:eliminar muestra', ['only' => ['destroy']]);
    }
    public function index(Request $request)
{
    $muestrasQuery = Muestra::query();

    // Aplicar el filtro por código si está presente en la solicitud
    if ($request->has('codigo')) {
        $muestrasQuery->where('codigo', $request->codigo);
    }

    // Ordenar las muestras de la más reciente a la más antigua
    $muestrasQuery->orderBy('created_at', 'desc');

    // Obtener las muestras con la relación 'user' cargada
    $muestras = $muestrasQuery->with('user')->paginate(20);
    
    // Retornar la vista con las muestras paginadas
    return view('muestras.index', compact('muestras'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $muestras = Muestra::all(); 
        return view("muestras.create", compact("muestras","user"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'codigo' => 'required|string|max:255|unique:muestras,codigo', // Añadimos unique rule para validar la unicidad en la tabla 'muestras'
            'au' => 'required|string|max:255',
            'ag' => 'required|string|max:255',
            'cu' => 'required|string|max:255',  
            'as' => 'nullable|string|max:255',
            'sb' => 'nullable|string|max:255',
            'pb' => 'nullable|string|max:255',      
            'zn' => 'nullable|string|max:255',
            'bi' => 'nullable|string|max:255',
            'hg' => 'nullable|string|max:255',
            's' => 'nullable|string|max:255',
            'humedad'=> 'nullable|string|max:255',
            'obs'=> 'nullable|string|max:255',
        ]);
        $existingMuestra = Muestra::where('codigo', $request->input('codigo'))->first();
        if ($existingMuestra) {
            return redirect()->back()->withErrors(['codigo' => 'El código ya existe en la base de datos.'])->withInput();
        }
        // Crear una nueva instancia de Muestra y asignar los valores
        $muestra = new Muestra();
        $muestra->codigo = $request->input('codigo');
        $muestra->au = $request->input('au');
        $muestra->ag = $request->input('ag');
        $muestra->cu = $request->input('cu');
        $muestra->as = $request->input('as');
        $muestra->sb = $request->input('sb');
        $muestra->pb = $request->input('pb');
        $muestra->zn = $request->input('zn');
        $muestra->bi = $request->input('bi');
        $muestra->hg = $request->input('hg');
        $muestra->s = $request->input('s');
        $muestra->humedad = $request->input('humedad');
        $muestra->obs = $request->input('obs');
        
        // Asignar el ID del usuario autenticado al campo usuario_id
        $muestra->usuario_id = auth()->id();
    
        // Guardar la muestra en la base de datos
        $muestra->save();
    
        // Redirigir a la ruta de index de muestras con un mensaje de éxito
        return redirect()->route('muestras.index')->with('success', 'Muestra de laboratorio creada correctamente');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(muestra $muestra)
    {
        return view('muestras.show',compact('muestra'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $muestra = Muestra::findOrFail($id);
        return view('muestras.edit', compact('muestra'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    // Validamos la solicitud
    $request->validate([
        'codigo' => [
            'required', // El código es obligatorio
            'string',
            'max:255',
            Rule::unique('muestras', 'codigo')->ignore($id), // Ignora el registro actual para evitar error de unicidad
        ],
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

    // Obtenemos la muestra que se va a actualizar
    $muestra = Muestra::findOrFail($id);

    // Actualizamos los campos del modelo con los nuevos valores
    $muestra->codigo = $request->input('codigo');
    $muestra->au = $request->input('au');
    $muestra->ag = $request->input('ag');
    $muestra->cu = $request->input('cu');
    $muestra->as = $request->input('as');
    $muestra->sb = $request->input('sb');
    $muestra->pb = $request->input('pb');
    $muestra->zn = $request->input('zn');
    $muestra->bi = $request->input('bi');
    $muestra->hg = $request->input('hg');
    $muestra->s = $request->input('s');
    $muestra->humedad = $request->input('humedad');
    $muestra->obs = $request->input('obs');

    // Asignar el usuario actual al campo usuario_id
    $muestra->usuario_id = Auth::id();

    // Guardamos los cambios
    $muestra->save();

    return redirect()->route('muestras.index')->with('editar-muestra', 'Muestra actualizada con éxito.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Encuentra la liquidación por ID
            $muestra = Muestra::findOrFail($id);
            // Elimina la liquidación
            $muestra->delete();
    
            return redirect()->route('muestras.index')->with('success', 'Muestra eliminada correctamente');
        } catch (\Illuminate\Database\QueryException $e) {
            // Manejar la excepción de integridad referencial
            return redirect()->route('muestras.index')->with('error', 'Esta muestra está asociada a liquidaciones y no se puede eliminar.');
        }
    }
    
}
