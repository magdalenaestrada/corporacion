<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcCategoria;
use App\Models\Log;

class AcCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    { 
        $this->middleware('permission:ver balanza');
    }
    public function index()
    {
        $categorias_select = AcCategoria::orderBy('created_at', 'desc')->paginate(30);
        $categorias = AcCategoria::with('categoria_padre', 'categorias_hijas')->whereNull('categoria_padre_id')->orderBy('created_at', 'asc')->paginate();
        return view('accategorias.index', compact('categorias', 'categorias_select'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{

            $request->validate([
                'nombre' => 'required|max:255|string|unique:empleados,nombre',
                'codigo' => 'required|max:255|string|unique:empleados,nombre',
            ]);
    
            $categoria = AcCategoria::create([
                'nombre' => $request->nombre,
                'codigo' => $request->codigo,
                'categoria_padre_id' => $request->categoria_padre_id,
               
            ]);

            Log::create([
                'fila_afectada' => $categoria->id,
                'dato_importante' => json_encode($request->all()),
                'tipo_log_id' => 2
            ]);
    
    
            return redirect()->route('accategorias.index')->with('status', 'Categoría creada con éxito.');
            }
            catch(QueryException $e){
                if ($e->getCode() == '23000'){
                    return redirect()->back->withInput()->with('error', 'Ya existe un registro con este valor.');
                }else{
                    return redirect()->back()->with('error', 'Error desconocido');
                }
    
    
            } catch (\Exception $e)  {
    
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    
    
            }    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
