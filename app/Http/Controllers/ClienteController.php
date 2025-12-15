<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use GuzzleHttp\Client;



class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    { 
        $this->middleware('permission:ver cliente', ['only' => ['index','show']]);
        $this->middleware('permission:create cliente', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar cliente', ['only' => ['update','edit']]);
        $this->middleware('permission:eliminar cliente', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $query = Cliente::query();
    
        // Aplicar filtro si se proporciona
        if ($request->filled('filtro')) {
            $filtro = $request->input('filtro');
            $query->where(function($q) use ($filtro) {
                $q->where('id', 'like', '%' . $filtro . '%')
                  ->orWhere('documento_cliente', 'like', '%' . $filtro . '%')
                  ->orWhere('datos_cliente', 'like', '%' . $filtro . '%')
                  ->orWhere('ruc_empresa', 'like', '%' . $filtro . '%')
                  ->orWhere('razon_social', 'like', '%' . $filtro . '%')
                  ->orWhereDate('created_at', $filtro);
            });
        }
        $query->orderByDesc('created_at');
        // Obtener los clientes paginados con sus requerimientos
        $clientes = $query->with('requerimientos')->paginate(perPage: 100); // Paginar con 10 clientes por página
    
        return view('clientes.index', compact('clientes'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener todos los clientes (¿necesario?)
        $clientes = Cliente::all(); // ¿Necesitas todos los clientes aquí?
    
        return view('clientes.create', compact('clientes'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'documento_cliente' => 'required|string|max:255',
            'datos_cliente' => 'required|string|max:255',
            'ruc_empresa' => 'nullable|string',
            'razon_social' => 'nullable|string',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string',

        ]);

        $cliente = new Cliente;
        $cliente->documento_cliente = $request->input('documento_cliente');
        $cliente->datos_cliente = $request->input('datos_cliente');
        $cliente->ruc_empresa = $request->input('ruc_empresa');
        $cliente->razon_social = $request->input('razon_social');
        $cliente->direccion = $request->input('direccion');
        $cliente->telefono = $request->input('telefono');


        
        $cliente->save();

        return redirect()->route('clientes.index')->with('success', 'Cliente registrado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string',
            //'producto' => 'nullable|string',

        ]);


        $cliente = Cliente::findOrFail($id);

        $cliente->direccion = $request->input('direccion');
        $cliente->telefono = $request->input('telefono');
        //$cliente->producto = $request->input('producto');



        
        $cliente->save();

        return redirect()->route('clientes.index')->with('success', 'Registro actualizado correctamente');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    try {
        // Encuentra el cliente con el ID proporcionado
        $cliente = Cliente::findOrFail($id);
        
        // Elimina los registros relacionados en la tabla requerimientos
        $cliente->requerimientos()->delete();
        
        // Luego elimina el cliente
        $cliente->delete();

        return redirect()->route('clientes.index')->with('eliminar-cliente', 'Cliente eliminado con éxito.');
    } catch (\Exception $e) {
        return redirect()->route('clientes.index')->with('error', 'Error al eliminar el cliente: ' . $e->getMessage());
    }
}




    public function buscarDocumento(Request $request)
    {
        $documento = $request->input('documento');

        $token = env('APIS_TOKEN');

        // Configurar el cliente GuzzleHttp
        $client = new Client([
            'base_uri' => 'https://api.apis.net.pe',
            'verify' => false,
        ]);

        // Determinar si es DNI o RUC
        $apiEndpoint = strlen($documento) === 8 ? '/v2/reniec/dni' : '/v2/sunat/ruc';

        // Configurar los parámetros de la solicitud
        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Referer' => 'https://apis.net.pe/api-consulta-ruc',
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
            'query' => ['numero' => $documento],
        ];

        // Realizar la solicitud a la API
        $response = $client->request('GET', $apiEndpoint, $parameters);

        // Obtener los datos de respuesta como un arreglo
        $responseData = json_decode($response->getBody()->getContents(), true);

        // Devolver la respuesta o realizar otras acciones según tus necesidades
        return response()->json($responseData);
    }

    public function listarClientes()
    {
        // Obtener todos los clientes ordenados por nombre_cliente
        $clientes = Cliente::orderBy('nombre_cliente')->get();

        // Retorna la vista 'clientes.index' con la colección de clientes
        return view('clientes.index', compact('clientes'));
    }
}
