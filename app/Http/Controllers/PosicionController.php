<?php

namespace App\Http\Controllers;
use App\Models\Posicion;
use App\Models\Log;

use Illuminate\Http\Request;

class PosicionController extends Controller
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
        $posiciones = Posicion::orderBy('created_at', 'desc')->paginate(30);
        return view('posiciones.index', compact('posiciones'));

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
                'nombre' => 'required|max:255|string|unique:posiciones,nombre'
            ]);
    
            $posicion = Posicion::create([
                'nombre' => $request->nombre,
            ]);

            Log::create([
                'fila_afectada' => $posicion->id,
                'dato_importante' => json_encode($request->all()),
                'tipo_log_id' => 5
            ]);
    
    
            return redirect()->route('posiciones.index')->with('status', 'Posición creada con éxito.');
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
