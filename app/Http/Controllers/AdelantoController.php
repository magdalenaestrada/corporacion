<?php

namespace App\Http\Controllers;

use App\Models\Adelanto;
use App\Models\Cliente;
use Illuminate\Http\Request;

class AdelantoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    { 
        $this->middleware('permission:usar adelantos', ['only' => ['index','show','create','store','edit','update']]);
        $this->middleware('permission:eliminar adelantos', ['only' => ['destroy']]);
    }
    public function index()
    {
        $adelantos = Adelanto::orderBy('id','desc')->paginate(20);
        $clientes = Cliente::all();

        return view('adelantos.index', compact('adelantos','clientes'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $adelantos = Adelanto::all(); 
        $clientes = Cliente::all();
        return view("adelantos.create", compact('adelantos','clientes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'nrofactura' => 'required|string|max:255',
            'proveedor' => 'nullable|string',
            'deposito' => 'required|string|max:255',
            'detraccion' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'total' => 'required|string|max:255',
            'cliente_id' => 'required|exists:clientes,id', // Validación para asegurar que cliente_id existe en la tabla clientes
        ]);

        $existingAdelanto = Adelanto::where('nrofactura', $request->input('nrofactura'))->first();
        if ($existingAdelanto) {
            return redirect()->back()->withErrors(['nrofactura' => 'La factura ya existe en la base de datos.'])->withInput();
        }
    
        // Crear una nueva instancia de Adelanto y asignar los valores
        $adelanto = new Adelanto();
        $adelanto->fecha = $request->input('fecha');
        $adelanto->nrofactura = $request->input('nrofactura');
        $adelanto->proveedor = $request->input('proveedor');
        $adelanto->deposito = $request->input('deposito');
        $adelanto->detraccion = $request->input('detraccion');
        $adelanto->descripcion = $request->input('descripcion');
        $adelanto->total = $request->input('total');
        $adelanto->cliente_id = $request->input('cliente_id');
        // Asignar otros campos del adelanto según sea necesario
        $adelanto->save();
    
        // Redireccionar a la ruta deseada con un mensaje de éxito
        return redirect()->route('adelantos.index')->with('success', 'Adelanto creado correctamente');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Adelanto $adelanto )
    {
        $clientes = Cliente::all();
        return view("adelantos.show", compact('adelanto','clientes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $adelanto = Adelanto::findOrFail($id);
        $clientes = Cliente::all();
        return view('adelantos.edit', compact('adelanto','clientes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'nrofactura' => 'required|string|max:255',
            'proveedor' => 'nullable|string',
            'deposito' => 'required|string|max:255',
            'detraccion' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'total' => 'required|string|max:255',
            'cliente_id' => 'required|exists:clientes,id', // Validación para asegurar que cliente_id existe en la tabla clientes
        ]);

        $adelanto = Adelanto::findOrFail($id);

        $adelanto->fecha = $request->input('fecha');
        $adelanto->nrofactura = $request->input('nrofactura');
        $adelanto->proveedor = $request->input('proveedor');
        $adelanto->deposito = $request->input('deposito');
        $adelanto->detraccion = $request->input('detraccion');
        $adelanto->descripcion = $request->input('descripcion');
        $adelanto->total = $request->input('total');
        $adelanto->cliente_id = $request->input('cliente_id');
        // Asignar otros campos del adelanto según sea necesario
        $adelanto->save();
        return redirect()->route('adelantos.index')->with('editar-adelanto', 'Requerimiento actualizado con éxito.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Encuentra el modelo con el ID proporcionado
            $adelanto = Adelanto::findOrFail($id);
    
            // Elimina el registro
            $adelanto->delete();
    
            return redirect()->route('adelantos.index')->with('eliminar-adelanto', 'adelanto eliminado con éxito.');
        } catch (\Exception $e) {
            // Maneja cualquier excepción que pueda ocurrir
            return redirect()->route('adelantos.index')->with('error', 'Error al eliminar el adelanto: ' . $e->getMessage());
        }
    }
}
