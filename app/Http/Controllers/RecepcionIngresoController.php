<?php

namespace App\Http\Controllers;

use App\Models\RecepcionIngreso;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Peso;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
class RecepcionIngresoController extends Controller
{
    
public function actaHtml(string $nro_salida)
{
    $recepcion = \App\Models\RecepcionIngreso::with('usuario')
        ->where('nro_salida', $nro_salida)->firstOrFail();
    $peso = \App\Models\Peso::where('NroSalida', $nro_salida)->first();

    // Detecta automáticamente la extensión del archivo alfalogo.*
    $candidatos = glob(public_path('images/innovalogo.{png,jpg,jpeg,gif,webp}'), GLOB_BRACE);
    $logoWeb = null;
    if (!empty($candidatos)) {
        $basename = basename($candidatos[0]); // p.ej. alfalogo.png
        $logoWeb  = asset('images/'.$basename); // URL para navegador (vista HTML)
    }

    $primaryColor = '#0E7490'; // cambia a tu color corporativo

    return view('recepciones_ingreso.acta', [
        'recepcion'     => $recepcion,
        'peso'          => $peso,
        'logoUrl'       => $logoWeb,     // para <img src="..."> en HTML
        'primaryColor'  => $primaryColor,
    ]);
}

public function actaPdf(string $nro_salida)
{
    $recepcion = \App\Models\RecepcionIngreso::with('usuario')
        ->where('nro_salida', $nro_salida)->firstOrFail();
    $peso = \App\Models\Peso::where('NroSalida', $nro_salida)->first();

    // Detecta automáticamente la extensión del archivo alfalogo.*
    $candidatos = glob(public_path('images/innovalogo.{png,jpg,jpeg,gif,webp}'), GLOB_BRACE);
    $logoFs = null;
    if (!empty($candidatos)) {
        $logoFs = $candidatos[0]; // ruta absoluta en disco para DomPDF
    }

    $primaryColor = '#0E7490';

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
        'recepciones_ingreso.acta',
        [
            'recepcion'     => $recepcion,
            'peso'          => $peso,
            'logoUrl'       => $logoFs,     // para DomPDF debe ser ruta de archivo local
            'primaryColor'  => $primaryColor,
        ]
    )->setPaper('a4');

    return $pdf->stream('ACTA_'.$nro_salida.'.pdf');
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
        ]);

        foreach (['nro_ruc','documento_ruc','documento_encargado','dni_conductor'] as $k) {
            if (isset($data[$k])) $data[$k] = trim($data[$k]);
        }
        foreach (['datos_encargado','datos_conductor','domicilio_encargado'] as $k) {
            if (isset($data[$k])) $data[$k] = mb_strtoupper(trim($data[$k]));
        }

        $item = new RecepcionIngreso($data);
        $item->creado_por = auth()->id(); // nullable
        $item->save();

        return redirect()
            ->route('pesos.index', $item)
            ->with('success', 'Recepción creada correctamente.');
    }

    public function show(RecepcionIngreso $recepcionIngreso)
    {
        //
    }

    public function edit(RecepcionIngreso $recepciones_ingreso)
{
    $pesoInfo = null;
    $prefill = [];

    // antes: view('recepciones-ingreso.edit', ...)
    return view('recepciones_ingreso.edit', [
        'item'      => $recepciones_ingreso,
        'pesoInfo'  => $pesoInfo,
        'prefill'   => $prefill,
    ]);
}


    public function update(Request $request, RecepcionIngreso $recepciones_ingreso)
{
    $data = $request->validate([
        'nro_salida' => [
            'required','string','max:50',
            Rule::unique('recepciones_ingreso','nro_salida')->ignore($recepciones_ingreso->id),
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
    ]);

    foreach (['nro_ruc','documento_ruc','documento_encargado','dni_conductor'] as $k) {
        if (isset($data[$k])) $data[$k] = trim($data[$k]);
    }
    foreach (['datos_encargado','datos_conductor','domicilio_encargado'] as $k) {
        if (isset($data[$k])) $data[$k] = mb_strtoupper(trim($data[$k]));
    }

    $recepciones_ingreso->fill($data)->save();

    // Si presionaste "Guardar e imprimir"
    if ($request->input('redirect') === 'print') {
        return redirect()
            ->route('recepciones-ingreso.acta.html', $recepciones_ingreso->nro_salida)
            ->with('success', 'Recepción actualizada. Abriendo acta…');
    }

    // Redirección estándar al show del resource
    return redirect()
        ->route('recepciones-ingreso.show', $recepciones_ingreso->id)
        ->with('success', 'Recepción actualizada correctamente.');
}

    public function destroy(RecepcionIngreso $recepcionIngreso)
    {
        //
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
