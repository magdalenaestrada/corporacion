<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Liquidacion;
use App\Models\Fina;
class FinaController extends Controller
{
    public function __construct()
    { 
       $this->middleware('permission:ver fina', ['only' => ['index','create','procesadas']]);
    }
    
   public function index()
   {
       // Obtener todas las liquidaciones junto con las muestras asociadas
       $liquidaciones = Liquidacion::with('muestra')
           ->whereDoesntHave('fina')  // Excluir las liquidaciones que ya tienen una fina asociada
           ->orderBy('created_at', 'desc')
           ->get();
   
       // Pasar los datos a la vista
       return view('finas.index', compact('liquidaciones'));
   }
public function procesadas()
{
    $finas = Fina::with(['liquidaciones:id,fina_id,NroSalida']) // ajusta fina_id si tu FK se llama distinto
        ->orderByDesc('id')
        ->paginate(perPage: 200);

    // Construir tickets por fina
    $finas->getCollection()->transform(function ($fina) {
        $tickets = $fina->liquidaciones
            ->pluck('NroSalida')
            ->filter()
            ->flatMap(function ($value) {
                return preg_split('/[\/,\s]+/', $value);
            })
            ->filter()
            ->unique()
            ->values()
            ->all();

        // creamos una propiedad “virtual” para la vista
        $fina->tickets_list = $tickets;

        return $fina;
    });

    return view('finas.procesadas', compact('finas'));
}

    public function create(Request $request)
{
    // Validar que las liquidaciones seleccionadas existan
    $liquidacionesIds = $request->input('liquidaciones');

    if (!$liquidacionesIds || count($liquidacionesIds) === 0) {
        return redirect()->back()->withErrors(['message' => 'Debes seleccionar al menos una liquidación para blendear.']);
    }

    // Recuperar los registros completos de las liquidaciones seleccionadas
    $liquidaciones = Liquidacion::whereIn('id', $liquidacionesIds)->get();

    // Pasar los registros a la vista
    return view('finas.create', ['liquidaciones' => $liquidaciones]);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigoBlending' => 'required|string',
            'liquidaciones' => 'required|array',
            'liquidaciones.*' => 'exists:liquidaciones,id'
        ]);

        $totalTMH = 0;
        $totalH2O = 0;
        $totalTMS = 0;
        $sumaProductoTMSAu = 0;
        $sumaProductoTMSAg = 0;
        $sumaProductoTMSCu = 0;
        $sumaProductoTMSAs = 0;
        $sumaProductoTMSSb = 0;
        $sumaProductoTMSPb = 0;
        $sumaProductoTMSZn = 0;
        $sumaProductoTMSBi = 0;
        $sumaProductoTMSHg = 0;
        $totalValorLote = 0;
        $totalLiquidacion = 0;

        $liquidaciones = Liquidacion::whereIn('id', $request->liquidaciones)->get();

        foreach ($liquidaciones as $liquidacion) {
            $totalTMH += $liquidacion->peso;
            $totalTMS += $liquidacion->tms;
            $totalValorLote += $liquidacion->valorporlote;
            $totalLiquidacion += $liquidacion->total;

            if ($liquidacion->muestra) {
                $sumaProductoTMSAu += $liquidacion->tms * $liquidacion->muestra->au;
                $sumaProductoTMSAg += $liquidacion->tms * $liquidacion->muestra->ag;
                $sumaProductoTMSCu += $liquidacion->tms * $liquidacion->muestra->cu;
                $sumaProductoTMSAs += $liquidacion->tms * $liquidacion->muestra->as;
                $sumaProductoTMSSb += $liquidacion->tms * $liquidacion->muestra->sb;
                $sumaProductoTMSPb += $liquidacion->tms * $liquidacion->muestra->pb;
                $sumaProductoTMSZn += $liquidacion->tms * $liquidacion->muestra->zn;
                $sumaProductoTMSBi += $liquidacion->tms * $liquidacion->muestra->bi;
                $sumaProductoTMSHg += $liquidacion->tms * $liquidacion->muestra->hg;
            }
        }

        $porcentajeH2O = $totalTMH > 0 ? (($totalTMH - $totalTMS) / $totalTMH) * 100 : 0;
        $promedioPonderadoAu = $totalTMS > 0 ? $sumaProductoTMSAu / $totalTMS : 0;
        $promedioPonderadoAg = $totalTMS > 0 ? $sumaProductoTMSAg / $totalTMS : 0;
        $promedioPonderadoCu = $totalTMS > 0 ? $sumaProductoTMSCu / $totalTMS : 0;
        $promedioPonderadoAs = $totalTMS > 0 ? $sumaProductoTMSAs / $totalTMS : 0;
        $promedioPonderadoSb = $totalTMS > 0 ? $sumaProductoTMSSb / $totalTMS : 0;
        $promedioPonderadoPb = $totalTMS > 0 ? $sumaProductoTMSPb / $totalTMS : 0;
        $promedioPonderadoZn = $totalTMS > 0 ? $sumaProductoTMSZn / $totalTMS : 0;
        $promedioPonderadoBi = $totalTMS > 0 ? $sumaProductoTMSBi / $totalTMS : 0;
        $promedioPonderadoHg = $totalTMS > 0 ? $sumaProductoTMSHg / $totalTMS : 0;

        $fina = Fina::create([
            'codigoBlending' => $request->codigoBlending,
            'total_tmh' => $totalTMH,
            'porcentaje_h2o' => $porcentajeH2O,
            'total_tms' => $totalTMS,
            'au_promedio' => $promedioPonderadoAu,
            'ag_promedio' => $promedioPonderadoAg,
            'cu_promedio' => $promedioPonderadoCu,
            'as_promedio' => $promedioPonderadoAs,
            'sb_promedio' => $promedioPonderadoSb,
            'pb_promedio' => $promedioPonderadoPb,
            'zn_promedio' => $promedioPonderadoZn,
            'bi_promedio' => $promedioPonderadoBi,
            'hg_promedio' => $promedioPonderadoHg,
            'total_valor_lote' => $totalValorLote,
            'total_liquidacion' => $totalLiquidacion,
        ]);

        Liquidacion::whereIn('id', $request->liquidaciones)->update(['fina_id' => $fina->id]);

        return redirect()->route('procesadas')->with('success', 'Blending creado exitosamente.');
    }
    
    
    /**
     * Display the specified resource.
     */
        public function show($id)
    {
        $fina = Fina::with('liquidaciones.muestra')->findOrFail($id); // Carga las muestras asociadas
        return view('finas.show', compact('fina'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fina $fina)
    {
        return view('finas.edit', compact('fina'));
    }

    public function update(Request $request, Fina $fina)
    {
        $request->validate([
            'codigoBlending' => 'required|string|max:255',
        ]);

        $fina->codigoBlending = $request->input('codigoBlending');
        $fina->save();

        return redirect()
            ->route('finas.show', $fina->id)
            ->with('success', 'Fina actualizada correctamente.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $fina = Fina::findOrFail($id);
        
        // Eliminar la fina
        $fina->delete();
    
        // Redirigir con un mensaje de éxito
        return redirect()->route('procesadas')->with('success', 'Fina eliminada y liquidación liberada.');
    }
    public function print($id)
{
    // Buscar la fina por ID
    $fina = Fina::with('liquidaciones.cliente', 'liquidaciones.muestra')->findOrFail($id);

    // Retornar la vista de impresión
    return view('finas.print', compact('fina')); // Asegúrate de que 'print' es el nombre correcto
}

}