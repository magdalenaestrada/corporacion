<?php

namespace App\Http\Controllers;
use App\Models\Despacho;
use App\Models\Blending;
use App\Models\Retiro;
use App\Models\Peso;
use App\Models\Ingreso;
use App\Models\RetiroDespacho;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DespachoController extends Controller
{

    public function __construct()
    { 
        $this->middleware('permission:ver despacho', ['only' => ['index','show']]);
        $this->middleware('permission:crear despacho', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar despacho', ['only' => ['update','edit']]);
        $this->middleware('permission:eliminar despacho', ['only' => ['destroy']]);
    }
    public function index()
    {
        $despachos = Despacho::with(['retiros.recepcion'])
            ->orderBy('created_at', 'desc') // Ordena de más reciente a más antiguo
            ->get();
    
        return view('despachos.index', compact('despachos'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create($blendingId)
{
    // Verificar si el blendingId existe y obtener los datos necesarios
    $blending = Blending::with('ingresos')->findOrFail($blendingId); // Obtener el blending con los ingresos relacionados

    // Obtener los NroSalida que ya están en la tabla 'retiros'
    $retiros = Retiro::select('nro_salida')->get(); // Obtener todos los nro_salida que están registrados en la tabla retiros

    // Obtener los datos de NroSalida, Bruto, Neto y Tara, excluyendo los que ya están en la tabla 'retiros'
    $NroSalida = Peso::select('NroSalida', 'Bruto', 'Neto', 'Tara')
                     ->whereNotIn('NroSalida', $retiros->pluck('nro_salida'))
                     ->orderBy('NroSalida', 'desc')
                     ->get();

    // Pasar los datos a la vista
    return view('despachos.create', compact('blending', 'NroSalida'));
}

    // Almacenar un nuevo despacho
    public function store(Request $request)
    {
        // Validar los datos del despacho
        $request->validate([
            'totalTMH' => 'nullable',
            'masomenos' => 'nullable|string',
            'fecha' => 'nullable|date',
            'observacion' => 'nullable|string',
            'deposito' => 'nullable|string',
            'carreta' => 'nullable|string',
            'retiros_data' => 'required|json', // Campo JSON con los datos de los retiros
        ]);
    
        // Validar si el blending_id está presente en el request
        if (!$request->has('blending_id')) {
            return redirect()->route('despachos.index')->with('error', 'El blending ID es obligatorio.');
        }
    
      // Validación y creación del despacho...
$despacho = Despacho::create([
    'blending_id' => $request->blending_id,
    'totalTMH' => $request->totalTMH,
    'masomenos' => $request->masomenos,
    'fecha' => $request->fecha,
    'observacion' => $request->observacion,
    'deposito' => $request->deposito,
    'destino' => $request->destino,
]);

// Cambiar estado del blending
$blending = Blending::findOrFail($request->blending_id);
$blending->estado = 'inactivo';
$blending->save();

// Obtener ingresos asociados
$ingresos = Ingreso::whereIn('id', function ($query) use ($request) {
    $query->select('ingreso_id')
        ->from('blending_ingreso')
        ->where('blending_id', $request->blending_id);
})->where('fase', 'BLENDING')->get();

// Decodificar retiros
$retiros = json_decode($request->retiros_data, true);

if (!is_array($retiros) || count($retiros) === 0) {
    return redirect()->route('despachos.index')->with('error', 'Los datos de los retiros no son válidos o están vacíos.');
}

// Iniciar transacción
DB::beginTransaction();
try {
    // Guardar los retiros
    foreach ($retiros as $retiroData) {
        $validatedData = validator($retiroData, [
            'NroSalida' => 'required|string',
            'precinto' => 'required|string',
            'guia' => 'required|string',
            'bruto' => 'required|string',
            'tara' => 'required|string',
            'neto' => 'required|string',
            'tracto' => 'required|string',
            'carreta' => 'required|string',
            'guia_transporte' => 'nullable|string',
            'ruc_empresa' => 'nullable|string',
            'razon_social' => 'nullable|string',
            'licencia' => 'nullable|string',
            'conductor' => 'nullable|string',
        ]);

        if ($validatedData->fails()) {
            DB::rollBack();
            return redirect()->route('despachos.index')->with('error', 'Datos inválidos en un retiro.');
        }

        Retiro::create([
            'despacho_id' => $despacho->id,
            'nro_salida' => $retiroData['NroSalida'],
            'precinto' => $retiroData['precinto'],
            'guia' => $retiroData['guia'],
            'bruto' => $retiroData['bruto'],
            'tara' => $retiroData['tara'],
            'neto' => $retiroData['neto'],
            'tracto' => $retiroData['tracto'],
            'carreta' => $retiroData['carreta'],
            'guia_transporte' => $retiroData['guia_transporte'] ?? null,
            'ruc_empresa' => $retiroData['ruc_empresa'] ?? null,
            'razon_social' => $retiroData['razon_social'] ?? null,
            'licencia' => $retiroData['licencia'] ?? null,
            'conductor' => $retiroData['conductor'] ?? null,
        ]);
    }

    // Actualizar todos los ingresos
    foreach ($ingresos as $ingreso) {
        $ingreso->fase = 'DESPACHADO';
        $ingreso->lote = 'liberado'; // Suponiendo que sea un campo string
        $ingreso->save();
    }

    DB::commit();
    return redirect()->route('despachos.index')->with('success', 'Despacho y retiros guardados correctamente.');
} catch (\Exception $e) {
    DB::rollBack();
    Log::error('Error al guardar despacho: ' . $e->getMessage());
    return redirect()->route('despachos.index')->with('error', 'Error al guardar: ' . $e->getMessage());
}
}

public function show($id) {
    $despacho = Despacho::with('retiros')->findOrFail($id);
    $blending = $despacho->blending;  // Si 'blending' es una relación en Despacho
    
    return view('despachos.show', compact('despacho', 'blending'));
}

public function edit($id)
{
    $despacho = Despacho::findOrFail($id);
    $blending = $despacho->blending;
    return view('despachos.edit', compact('despacho','blending'));
}
public function update(Request $request, $id)
{
    // Validar los campos que se van a actualizar
    $request->validate([
        'fecha' => 'required|date_format:d/m/Y', // Aseguramos que la fecha esté en el formato correcto
        'deposito' => 'required|string|max:255',
        'destino' => 'required|string|max:255',
        'observacion' => 'nullable|string|max:255', // Observación es opcional
    ]);

    // Buscar el despacho por su ID
    $despacho = Despacho::findOrFail($id);

    // Convertir la fecha de formato d/m/Y a Y-m-d para almacenarla en la base de datos
    $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha)->format('Y-m-d');

    // Actualizar los campos del despacho
    $despacho->update([
        'fecha' => $fecha,
        'deposito' => $request->deposito,
        'destino' => $request->destino,
        'observacion' => $request->observacion,
    ]);

    // Redirigir al usuario con un mensaje de éxito
    return redirect()->route('despachos.index')->with('success', 'Despacho actualizado correctamente');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $despacho = Despacho::findOrFail($id);

    // Recuperar el blending relacionado
    $blending = $despacho->blending;

    // Eliminar los retiros asociados al despacho (esto libera los NroSalida)
    Retiro::where('despacho_id', $despacho->id)->delete();

    // Eliminar el despacho
    $despacho->delete();

    // Reactivar el blending cambiando su estado
    if ($blending) {
        $blending->estado = 'activo'; // Permitir nuevamente la asignación de despacho
        $blending->save();
    }

    return redirect()->route('despachos.index')->with('success', 'Despacho eliminado, retiros eliminados y blending reactivado.');
}

    

    public function showRetiros($despachoId)
{
    $despacho = Despacho::findOrFail($despachoId);
    $retiros = $despacho->retiros; // Obtén los retiros asociados a este despacho

    return view('despachos.retiros', compact('despacho', 'retiros'));
}
}
