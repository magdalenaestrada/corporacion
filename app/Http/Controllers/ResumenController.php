<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Resumen;
use App\Models\Adelanto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ResumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    { 
        $this->middleware('permission:usar resumen adelanto', ['only' => ['index','show','create','store']]);
    }
     public function index()
     {
         // Cargar los resumens ordenados por fecha de creación, con paginación
         $resumens = Resumen::with('user')  // Cargar la relación 'user'
                             ->orderBy('created_at', 'desc')
                             ->paginate(20);
                             
         
         return view('resumens.index', compact('resumens'));
     }

   
    
    public function create()
{
    $user = Auth::user();
    
    // Obtener clientes que tienen adelantos asociados
    $clientes = Cliente::whereHas('adelantos')->get();

    // Obtener adelantos disponibles que no están asociados a ningún resumen
    $adelantosDisponibles = Adelanto::whereDoesntHave('resumens')->get();

    return view('resumens.create', compact('clientes', 'adelantosDisponibles','user'));
}
public function store(Request $request)
{
    // Validar los datos del formulario (opcional)
    $request->validate([
        'fecha_resumen' => 'required|date',
        'seleccion_cliente' => 'required|exists:clientes,id',
        'adelantos' => 'required|array',
        'adelantos.*' => 'exists:adelantos,id',
        'suma_total' => 'required|numeric',
    ]);

    try {
        // Crear un nuevo resumen de adelantos
        $resumen = new Resumen();
        $resumen->fecha_resumen = $request->input('fecha_resumen');
        $resumen->cliente_id = $request->input('seleccion_cliente');
        $resumen->factura = ''; // Puedes ajustar este campo según tu lógica de negocio
        $resumen->total = $request->input('suma_total');

        // Asignar el usuario actual al resumen
        $resumen->usuario_id = auth()->id();

        $resumen->save();

        // Adjuntar los adelantos seleccionados al resumen
        $resumen->adelantos()->attach($request->input('adelantos'));

        // Redireccionar con mensaje de éxito
        return redirect()->route('resumens.index')->with('success', 'Resumen de adelantos guardado correctamente.');
    } catch (\Exception $e) {
        // Manejar cualquier error
        return redirect()->back()->withInput()->withErrors(['error' => 'Error al guardar el resumen de adelantos: ' . $e->getMessage()]);
    }
}
    public function show($id)
{
    // Obtener el resumen por su ID junto con los adelantos asociados
    $resumen = Resumen::with('adelantos.cliente')->findOrFail($id);

    // Calcular la suma total de los adelantos seleccionados
    $sumaTotal = 0;
    foreach ($resumen->adelantos as $adelanto) {
        $sumaTotal += $adelanto->total;
    }

    // Pasar los datos a la vista 'ver' y mostrarla
    return view('resumens.show', compact('resumen', 'sumaTotal'));
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
