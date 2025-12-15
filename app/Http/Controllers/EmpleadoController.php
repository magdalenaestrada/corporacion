<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Posicion;
use App\Models\Area;
use App\Models\Log;
use Illuminate\Database\QueryException;


class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    { 
        $this->middleware('permission:ver balanza');
    }
    public function index(){

    
        $empleados = Empleado::orderBy('created_at', 'desc')->paginate(30);
        $posiciones = Posicion::all();
        $areas = Area::all();

        return view('empleados.index', compact('empleados', 'posiciones', 'areas'));

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
                'documento' => 'required|max:50|string|unique:empleados,documento'
            ]);
    
            $empleado = Empleado::create([
                'nombre' => $request->nombre,
                'documento' => $request->documento,
                'jefe_id' => $request->jefe_id,
                'posicion_id' => $request->posicion_id,
                'area_id' => $request->area_id,
            ]);

            Log::create([
                'fila_afectada' => $empleado->id,
                'dato_importante' => json_encode($request->all()),
                'tipo_log_id' => 4
            ]);
    
    
            return redirect()->route('empleados.index')->with('status', 'Empleado creado con éxito.');
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
