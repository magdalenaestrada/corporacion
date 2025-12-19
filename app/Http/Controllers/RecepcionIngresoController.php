<?php

namespace App\Http\Controllers;

use App\Models\User; // arriba si aún no lo tienes
use App\Models\RecepcionIngreso;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Peso;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;

class RecepcionIngresoController extends Controller
{
    private array $REP_IDS = [23, 24, 32, 34, 38];

    public function __construct()
    {
        $this->middleware('permission:ver recepciones')->only(['index', 'show', 'actaHtml', 'actaPdf']);
        $this->middleware('permission:crear recepciones')->only(['create', 'store']);
        $this->middleware('permission:editar recepciones')->only(['edit', 'update']);
        $this->middleware('permission:eliminar recepciones')->only(['destroy']);
    }

    public function actaHtml(string $nro_salida)
    {
        $recepcion = RecepcionIngreso::with(['creador', 'representante'])
            ->where('nro_salida', $nro_salida)
            ->firstOrFail();

        $peso = Peso::where('NroSalida', $nro_salida)->first();

        $candidatos = glob(public_path('images/innovalogo.{png,jpg,jpeg,gif,webp}'), GLOB_BRACE);
        $logoWeb = !empty($candidatos) ? asset('images/' . basename($candidatos[0])) : null;

        $primaryColor = '#0E7490';

        return view('recepciones_ingreso.acta', [
            'recepcion'    => $recepcion,
            'peso'         => $peso,
            'logoUrl'      => $logoWeb,
            'primaryColor' => $primaryColor,

            // SOLO el seleccionado
            'rep'          => $recepcion->representante,
        ]);
    }

    public function actaPdf(string $nro_salida)
    {
        $recepcion = RecepcionIngreso::with(['creador', 'representante'])
            ->where('nro_salida', $nro_salida)
            ->firstOrFail();

        $peso = Peso::where('NroSalida', $nro_salida)->first();

        $candidatos = glob(public_path('images/innovalogo.{png,jpg,jpeg,gif,webp}'), GLOB_BRACE);
        $logoFs = !empty($candidatos) ? $candidatos[0] : null;

        $primaryColor = '#0E7490';

        $pdf = Pdf::loadView('recepciones_ingreso.acta', [
            'recepcion'    => $recepcion,
            'peso'         => $peso,
            'logoUrl'      => $logoFs,
            'primaryColor' => $primaryColor,

            // SOLO el seleccionado
            'rep'          => $recepcion->representante,
        ])->setPaper('a4');

        return $pdf->stream('ACTA_' . $nro_salida . '.pdf');
    }
    public function index()
    {
        //
    }

    public function create()
    {
        $prefill = [
            'nro_salida' => request('nro_salida'),
        ];

        return view('recepciones_ingreso.create', compact('prefill'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nro_salida'          => 'required|string|max:50|unique:recepciones_ingreso,nro_salida',
            'nro_ruc'             => 'nullable|string|max:20',
            'documento_ruc'       => 'nullable|string|max:50',
            'documento_encargado' => 'nullable|string|max:50',
            'datos_encargado'     => 'nullable|string|max:255',
            'domicilio_encargado' => 'nullable|string|max:255',
            'dni_conductor'       => 'nullable|string|max:20',
            'datos_conductor'     => 'nullable|string|max:255',
            'observacion'         => 'nullable|string',
            'extras'              => 'nullable|array',

            // CLAVE: lo que eliges en create
            'representante_user_id' => ['required', 'integer', Rule::in($this->REP_IDS)],
        ]);

        foreach (['nro_ruc', 'documento_ruc', 'documento_encargado', 'dni_conductor'] as $k) {
            if (isset($data[$k])) $data[$k] = trim($data[$k]);
        }
        foreach (['datos_encargado', 'datos_conductor', 'domicilio_encargado'] as $k) {
            if (isset($data[$k])) $data[$k] = mb_strtoupper(trim($data[$k]));
        }

        $item = new RecepcionIngreso($data);
        $item->creado_por = auth()->id();
        $item->save();

        return redirect()
            ->route('recepciones-ingreso.acta.html', $item->nro_salida) // abre directo el acta con el representante elegido
            ->with('success', 'Recepción creada correctamente. Abriendo acta…');
    }

    public function show(RecepcionIngreso $recepcionIngreso)
    {
        //
    }

    public function edit(RecepcionIngreso $recepciones_ingreso)
    {
        // Traer data de Peso para mostrar en la cabecera (solo lectura)
        $peso = Peso::where('NroSalida', $recepciones_ingreso->nro_salida)->first();

        $pesoInfo = $peso ? [
            'fechas'   => $peso->Fechas ?? null,
            'horas'    => $peso->Horas ?? null,
            'bruto'    => $peso->Bruto ?? null,
            'tara'     => $peso->Tara ?? null,
            'neto'     => $peso->Neto ?? null,
            'producto' => $peso->Producto ?? null,
            'placa'    => $peso->Placa ?? null,
            'carreta'  => $peso->Carreta ?? null,
            'destino'  => $peso->destino ?? null,
            'origen'   => $peso->origen ?? null,
            'guia'     => $peso->guia ?? null,
            'guiat'    => $peso->guiat ?? null,
        ] : null;

        // Lista de representantes permitidos (para el select)
        $representantes = User::query()
            ->whereIn('id', $this->REP_IDS)
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return view('recepciones_ingreso.edit', [
            'item'            => $recepciones_ingreso,
            'pesoInfo'        => $pesoInfo,
            'prefill'         => [],
            'representantes'  => $representantes,
        ]);
    }


    public function update(Request $request, RecepcionIngreso $recepciones_ingreso)
    {
        $data = $request->validate([
            'nro_salida' => [
                'required',
                'string',
                'max:50',
                Rule::unique('recepciones_ingreso', 'nro_salida')->ignore($recepciones_ingreso->id),
            ],
            'nro_ruc'             => 'nullable|string|max:20',
            'documento_ruc'       => 'nullable|string|max:50',
            'documento_encargado' => 'nullable|string|max:50',
            'datos_encargado'     => 'nullable|string|max:255',
            'domicilio_encargado' => 'nullable|string|max:255',
            'dni_conductor'       => 'nullable|string|max:20',
            'datos_conductor'     => 'nullable|string|max:255',
            'observacion'         => 'nullable|string',
            'extras'              => 'nullable|array',

            // CLAVE
            'representante_user_id' => ['required', 'integer', Rule::in($this->REP_IDS)],
        ]);

        foreach (['nro_ruc', 'documento_ruc', 'documento_encargado', 'dni_conductor'] as $k) {
            if (isset($data[$k])) $data[$k] = trim($data[$k]);
        }
        foreach (['datos_encargado', 'datos_conductor', 'domicilio_encargado'] as $k) {
            if (isset($data[$k])) $data[$k] = mb_strtoupper(trim($data[$k]));
        }

        $recepciones_ingreso->fill($data)->save();

        if ($request->input('redirect') === 'print') {
            return redirect()
                ->route('recepciones-ingreso.acta.html', $recepciones_ingreso->nro_salida)
                ->with('success', 'Recepción actualizada. Abriendo acta…');
        }

        return redirect()
            ->route('recepciones-ingreso.show', $recepciones_ingreso->id)
            ->with('success', 'Recepción actualizada correctamente.');
    }

    public function destroy(RecepcionIngreso $recepciones_ingreso)
    {
        $nroSalida = $recepciones_ingreso->nro_salida;
        $recepciones_ingreso->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'ok' => true,
                'nro_salida' => $nroSalida,
            ]);
        }

        return redirect()
            ->route('pesos.index')
            ->with('success', "Recepción {$nroSalida} eliminada.");
    }

    public function buscarDocumento(Request $request)
    {
        $documento = $request->input('documento');

        $token = env('APIS_TOKEN');

        $client = new Client([
            'base_uri' => 'https://api.apis.net.pe',
            'verify'   => false,
        ]);

        $apiEndpoint = strlen($documento) === 8 ? '/v2/reniec/dni' : '/v2/sunat/ruc';

        $parameters = [
            'http_errors'     => false,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Referer'       => 'https://apis.net.pe/api-consulta-ruc',
                'User-Agent'    => 'laravel/guzzle',
                'Accept'        => 'application/json',
            ],
            'query' => ['numero' => $documento],
        ];

        $response = $client->request('GET', $apiEndpoint, $parameters);
        $responseData = json_decode($response->getBody()->getContents(), true);

        return response()->json($responseData);
    }
}
