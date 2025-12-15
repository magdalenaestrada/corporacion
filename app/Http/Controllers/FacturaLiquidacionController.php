<?php

namespace App\Http\Controllers;

use App\Models\FacturaLiquidacion;
use Illuminate\Http\Request;
use App\Exports\FacturasLiquidacionesExport;
use Maatwebsite\Excel\Facades\Excel;
class FacturaLiquidacionController extends Controller
{
    public function __construct()
    { 
        $this->middleware('permission:ver facturaliquidacion', ['only' => ['index','export']]);
    }
    public function index()
{
    // Obtener todas las facturas ordenadas por fecha de creación (de más reciente a más antiguo)
    $facturasLiquidaciones = FacturaLiquidacion::with('liquidacion.cliente')
        ->orderBy('created_at', 'desc')
        ->get();
    
    // Retornar la vista con los datos
    return view('facturas.index', compact('facturasLiquidaciones'));
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
        //
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
    public function export()
    {
        return Excel::download(new FacturasLiquidacionesExport, 'facturas_liquidaciones.xlsx');
    }
}
