<?php

namespace App\Http\Controllers;
use App\Models\AcActivo;
use App\Models\Empleado;
use App\Models\AcCategoria;
use App\Models\AcValorHistorico;
use App\Models\Log;
use Illuminate\Http\Request;

class AcActivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index()
    {
        $empleados = Empleado::all();
        $categorias = AcCategoria::all();
        $activos = AcActivo::orderBy('created_at', 'desc')->paginate(30);
        return view('acactivos.index', compact('activos', 'empleados', 'categorias'));
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
                'nombre' => 'required|max:255|string',
                'codigo_barras' => 'required|max:255|string|unique:ac_activos,codigo_barras',
           
            ]);
    
            $activo = AcActivo::create([
                'nombre' => $request->nombre,
                'imei' => $request->imei,
                'codigo_barras' => $request->codigo_barras,
                'especificaciones' => $request->especificaciones,
                'observaciones' => $request->observaciones,
                'valor' => $request->valor,
                'empleado_id' => $request->empleado_id,
                'ac_activo_estado_id' => $request->ac_activo_estado_id,
                'ac_categoria_id' => $request->ac_categoria_id,

                //Por defecto el estado del activo es inventario
                'ac_activo_estado_id' => 1
            ]);



            // Actualizar la tabla de precios históricos
            AcValorHistorico::create([
                'valor' => $request->valor ?? 0,
                'ac_activo_id' => $activo->id,
            ]);



            $data = $request->all();

            // Limit the length of each value
            foreach ($data as $key => $value) {
                if (is_string($value) && strlen($value) > 100) { // Adjust the length as needed
                    $data[$key] = substr($value, 0, 100);
                }
            }

            // Include only essential fields
            $essentialData = [
                'nombre' => $data['nombre'] ?? null,
                'valor' => $data['valor'] ?? null,
            ];





            Log::create([
                'fila_afectada' => $activo->id,
                'dato_importante' => json_encode($essentialData),
                'tipo_log_id' => 1
            ]);
               
            return redirect()->route('acactivos.index')->with('status', 'Activo creado con éxito.');
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
        $activo = AcActivo::findOrFail($id);
        return view('acactivos.show', compact('activo'));

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
