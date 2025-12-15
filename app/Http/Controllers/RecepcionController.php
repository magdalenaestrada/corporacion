<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Retiro;
use App\Models\Recepcion;


class RecepcionController extends Controller
{
       public function __construct()
       { 
          $this->middleware('permission:retiros', ['only' => ['index','create','store','show','edit','update']]);
      }
    public function index()
    {
        //
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
    public function store(Request $request, $retiroId)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'bruto_recep' => 'required|numeric',
            'tara_recep' => 'required|numeric',
            'neto_recep' => 'required|numeric',
            'diferencia' => 'required|numeric',
            'codigo_lote' => 'required|string',
            'fecha_recepcion' => 'required|date',
            'salida' => 'nullable|string',
            'referencia' => 'nullable|string',
            'custodio' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        // Crear la recepción
        $retiro = Retiro::findOrFail($retiroId);
        $recepcion = new Recepcion([
            'bruto_recep' => $validated['bruto_recep'],
            'tara_recep' => $validated['tara_recep'],
            'neto_recep' => $validated['neto_recep'],
            'diferencia' => $validated['diferencia'],
            'codigo_lote' => $validated['codigo_lote'],
            'fecha_recepcion' => $validated['fecha_recepcion'],
            'salida' => $validated['salida'],
            'referencia' => $validated['referencia'],
            'custodio' => $validated['custodio'],
            'observaciones' => $validated['observaciones'],
        ]);

        // Relacionar con el retiro
        $retiro->recepcion()->save($recepcion);

        // Redirigir de nuevo con un mensaje de éxito
        return redirect()->back()->with('success', 'Recepción registrada exitosamente.');
    }
    /**
     * Display the specified resource.
     */
    //public function show(Retiro $retiro)
    //{
        // Asegúrate de que el retiro tenga una recepción asociada
       // $recepcion = $retiro->recepcion; // Relación definida en el modelo Retiro

        //return view('recepciones.show', compact('recepcion'));
    //}
    public function show($retiroId)
    {
        // Buscar el retiro con su recepción asociada
        $retiro = Retiro::with('recepcion')->find($retiroId);
    
        // Si el retiro no existe o no tiene recepción, redirigir con un error
        if (!$retiro || !$retiro->recepcion) {
            return redirect()->back()->with('error', 'Recepción no encontrada.');
        }
    
        // Enviar la recepción a la vista
        return view('recepciones.show', ['recepcion' => $retiro->recepcion]);
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
    public function update(Request $request, Recepcion $recepcion)
    {
        $request->validate([
            'bruto_recep' => 'required|numeric',
            'tara_recep' => 'required|numeric',
            'neto_recep' => 'required|numeric',
            'codigo_lote' => 'required|string|max:50',
            'fecha_recepcion' => 'required|date',
            'referencia' => 'nullable|string|max:255',
            'custodio' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string|max:500',
        ]);

        // Actualizar los datos de la recepción
        $recepcion->update($request->all());

        // Redireccionar de nuevo al detalle de la recepción con mensaje de éxito
        return redirect()->route('retiros.recepcion.show', $recepcion->id)
            ->with('success', 'Recepción actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
