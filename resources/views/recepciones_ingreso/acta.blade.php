<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Acta — Ticket {{ $peso->NroSalida ?? '—' }}</title>

    <style>
    :root {
      --ink:#111827; --muted:#6b7280; --line:#d1d5db;
      --head: {{ $primaryColor ?? '#0f172a' }};
      --chip:#f3f4f6;
      --bg:#f1f5f9;
    }

    body {
      font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Arial;
      background: var(--bg);
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 40px 0;
      margin: 0;
      color: var(--ink);
      font-size: 11.5px;
      line-height: 1.42;
    }

    .page {
      background: white;
      width: 210mm;
      min-height: 297mm;
      box-shadow: 0 0 8px rgba(0, 0, 0, 0.15);
      border-radius: 4px;
      padding: 20mm 18mm;
      position: relative;
    }

    .print-btn, .back-btn {
      position: fixed;
      top: 20px;
      background: #0f172a;
      color: white;
      border: none;
      border-radius: 6px;
      padding: 8px 16px;
      cursor: pointer;
      font-size: 13px;
      font-weight: 600;
      box-shadow: 0 2px 6px rgba(0,0,0,.2);
      transition: background 0.2s;
      z-index: 1000;
    }

    .print-btn:hover, .back-btn:hover { background: #1e293b; }

    .print-btn { left: 50%; transform: translateX(-50%); }
    .back-btn { left: 20px; }

    @media print {
      .print-btn, .back-btn { display: none !important; }
      body { background: white; padding: 0; }
      .page { box-shadow: none; margin: 0; border-radius: 0; width: 100%; padding: 0; }
    }

    /* Márgenes y detalles de la hoja */
    .head {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid var(--line);
      padding-bottom: 6px;
      margin-bottom: 10px;
    }
    .brand-wrap { display: flex; align-items: center; gap: 10px; }
    .brand-logo { height: 38px; object-fit: contain; }
    .brand { font-weight: 700; font-size: 14px; color: var(--head); }
    .sub { color: var(--muted); font-size: 11px; }

    .meta {
      display: flex; gap: 6px; align-items: center;
      font-size: 10.5px; color: var(--muted);
      background: var(--chip);
      padding: 5px 7px;
      border: 1px solid var(--line);
      border-radius: 6px;
    }

    .title {
      text-align: center;
      margin: 10px 0 12px 0;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: .15px;
      font-size: 13px;
    }

    .section-title {
      font-weight: 700;
      text-transform: uppercase;
      margin: 12px 0 5px 0;
      border-left: 3px solid var(--head);
      padding-left: 6px;
      font-size: 11.8px;
    }

    .box {
      border: 1px solid var(--line);
      border-radius: 8px;
      padding: 8px;
      background: #fff;
    }

    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }

    .kv { width: 100%; border-collapse: collapse; }
    .kv tr + tr td { border-top: 1px dashed var(--line); }
    .kv td { padding: 3px 5px; vertical-align: top; }
    .kv .label { width: 35%; color: #111; font-weight: 600; }
    .kv .value { width: 65%; }

    p { margin: 5px 0; text-align: justify; }
    ul { margin: 5px 0 0 18px; padding: 0; }
    .muted { color: var(--muted); }

    .obs { border: 1px dashed var(--line); border-radius: 6px; padding: 6px 8px; }

    .signs { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 14px; }
    .sign { text-align: center; padding-top: 25px; }
    .sign .line { margin-top: 35px; border-top: 1px solid #000; padding-top: 4px; font-size: 11px; font-weight: 600; }
    .mini { font-size: 10.5px; }

    .chip {
      display: inline-block;
      background: var(--chip);
      border: 1px solid var(--line);
      padding: 2px 6px;
      border-radius: 999px;
      font-size: 10px;
    }
    .back-btn { left: 20px; }
    .partes .box { padding: 7px; }
    .partes .kv td { padding: 2px 4px; font-size: 10.5px; }
    .partes .chip { font-size: 9.5px; padding: 1px 6px; }
    .partes.grid-2 { gap: 6px; }

    .watermark {
      position: absolute;
      top: 50%; left: 50%;
      transform: translate(-50%, -50%);
      opacity: 0.05;
      width: 460px;
      z-index: -1;
    }
  </style>
</head>
<body>
<button class="back-btn" onclick="window.location.href='{{ route('pesos.index') }}'">⬅️ Volver</button>
<button class="print-btn" onclick="window.print()">🖨️ Imprimir Acta</button>

<div class="page">
  @php
    $logoUrl = $logoUrl ?? asset('images/innovalogo.png');
  @endphp

  @if(!empty($logoUrl))
    <img src="{{ $logoUrl }}" class="watermark" alt="Marca de agua">
  @endif

  <div class="doc">

  {{-- ENCABEZADO --}}
  <div class="head">
    <div class="brand-wrap">
      @if(!empty($logoUrl))
        <img src="{{ $logoUrl }}" alt="Logo" class="brand-logo">
      @endif
      <div>
        <div class="brand">INNOVA CORPORATIVO S.A.</div>
        <div class="sub">RUC: 20613318021</div>
      </div>
    </div>
    <div class="meta">
      <span>Ticket</span><strong># {{ $peso->NroSalida ?? '—' }}</strong>
      <span>•</span>
      <span>Generado: {{ $recepcion->created_at->format('d/m/Y H:i') }}</span>
    </div>
  </div>

  <div class="title">ACTA DE ENTREGA Y RECEPCIÓN DE CONCENTRADO DE MINERALES</div>
@php
  use Carbon\Carbon;

  // Hora SOLO (evita el 1899-12-30)
  $horaSolo = !empty($peso->Horas) ? Carbon::parse($peso->Horas)->format('H:i') : '—';

  // Fecha SOLO (día/mes/año) desde "Fechas"
  $dtFecha = !empty($peso->Fechas) ? Carbon::parse($peso->Fechas) : null;

  $dia  = $dtFecha ? $dtFecha->format('d') : '—';
  $mes  = $dtFecha ? ucfirst($dtFecha->locale('es')->translatedFormat('F')) : '—';
  $anio = $dtFecha ? $dtFecha->format('Y') : '—';
@endphp
  {{-- Intro --}}
<div class="box" style="margin-bottom:10px;">
  <p>
    En la localidad de <b>Nasca</b>, siendo las <b>{{ $horaSolo }}</b> horas del día
    <b>{{ $dia }}</b> de
    <b>{{ $mes }}</b> del
    <b>{{ $anio }}</b>, se extiende la presente
    <b>ACTA DE ENTREGA Y RECEPCIÓN DE CONCENTRADO DE MINERALES</b>, con la finalidad de dejar constancia de la entrega,
    traslado, recepción y verificación del concentrado, de acuerdo con la normativa vigente que regula su
    comercialización y transporte.
  </p>
</div>
  {{-- I. PARTES INTERVINIENTES --}}
  <div class="section-title">I. Partes intervinientes</div>
  <div class="grid-2 partes">
    {{-- Entregante --}}
    <div class="box">
      <div class="chip" style="margin-bottom:4px;">Empresa Entregante</div>
      <table class="kv">
        <tr><td class="label">Doc. RUC</td><td class="value">{{ $recepcion->documento_ruc ?: '—' }}</td></tr>
        <tr><td class="label">RUC</td><td class="value">{{ $recepcion->nro_ruc ?: '—' }}</td></tr>
        <tr><td class="label">Representante</td><td class="value">{{ $recepcion->datos_encargado ?: '—' }}</td></tr>
        <tr><td class="label">DNI</td><td class="value">{{ $recepcion->documento_encargado ?: '—' }}</td></tr>
        <tr><td class="label">Domicilio</td><td class="value">{{ $recepcion->domicilio_encargado ?: '—' }}</td></tr>
      </table>
    </div>

    {{-- Receptora --}}
    <div class="box">
      <div class="chip" style="margin-bottom:4px;">Empresa Receptora</div>
      <table class="kv">
        <tr><td class="label">Razón social</td><td class="value">INNOVA CORPORATIVO S.A.</td></tr>
        <tr><td class="label">RUC</td><td class="value">20613318021</td></tr>
        <tr><td class="label">Representante</td><td class="value">{{ $recepcion->representante->name ?? '__________' }}</td></tr>
        <tr>
          <td class="label">Usuario (ID)</td>
          <td class="value">{{ $recepcion->representante?->email ? explode('@',$recepcion->representante->email)[0] : '__________' }}</td>
        </tr>
        <tr><td class="label">Domicilio</td><td class="value">Carretera Pampa de Chauchilla km 1, Fundo Santa Cirila, Ica - Nasca</td></tr>
      </table>
    </div>
  </div>

  {{-- II. OBJETO --}}
  
  {{-- III. CONDICIONES --}}
  <div class="section-title">II. Condiciones de entrega y transporte</div>
  <div class="box">
    <p>1. La entrega del concentrado con origen de <b>{{ $peso->origen ?: '—' }}</b> , se realizó en el punto de recepción ubicado en:
      <b>Carretera Pampa de Chauchilla km 1, Fundo Santa Cirila, Ica - Nasca.</b> - <b>{{ $peso->destino ?: '—' }}</b></p>

    <p>2. El trabajador de la empresa <b>{{ $recepcion->datos_encargado ?: '—' }}</b> con DNI
      <b>{{ $recepcion->documento_encargado ?: '—' }}</b> realizó la entrega física del concentrado.</p>

    <p>3. Documentos de traslado:</p>
      <span class="label">Guia Remitente</span> N.º <b>{{ $peso->guia ?: '—' }}.</b></p>

      <span class="label">Guia Transportista</span> N.º <b>{{ $peso->guiat ?: '—' }}</b>

    </ul>

    <p style="margin-top:6px;">4. El transporte se realizó en la unidad vehicular placa N.º
      <b>{{ $peso->Placa ?: '—' }}</b>, conducido por <b>{{ $recepcion->datos_conductor ?: '—' }}</b>
      (DNI: <b>{{ $recepcion->dni_conductor ?: '—' }}</b>).</p>

     {{--<p>5. El concentrado fue transportado en sacos/lonas sellados y rotulados, identificados con el número de lote y
      procedencia, garantizando su integridad hasta su recepción en planta.</p>--}}

   <p>5. Ticket de balanza — N.º <b>{{ $peso->NroSalida ?? '—' }}</b>;
      Bruto/Tara/Neto: <b>{{ $peso->Bruto ?? '—' }}</b>/<b>{{ $peso->Tara ?? '—' }}</b>/<b>{{ $peso->Neto ?? '—' }}</b>;
      emitido por <b>{{ $peso->Operadors ?: '—' }}
    </p>
  </div>

  {{-- DOCUMENTOS --}}
  <div class="section-title">Documentos que se adjuntan al acta</div>
  <div class="box">
    <ul>
      <li>Guías de Remisión – Remitente y Transportista.</li>
      <li>Constancia de recepción o entrega.</li>
      <li>Ticket de Balanza.</li>
      <li>Informes de Ensayo de Laboratorio y Liquidación de Compra.</li>
    </ul>
  </div>

  {{-- OBSERVACIONES --}}
  <div class="section-title">Observaciones</div>
  @php $obsText = trim($recepcion->observacion ?? ''); @endphp
  <div class="obs">{!! $obsText === '' ? 'Sin observaciones.' : nl2br(e($obsText)) !!}</div>

  {{-- PIE Y FIRMAS --}}
  <div class="box" style="margin-top:15px;">
    <p>Firmado en la ciudad de <b>Nasca</b>, a los <b>{{ $recepcion->created_at->format('d') }}</b> días del mes de
      <b>{{ ucfirst($recepcion->created_at->translatedFormat('F')) }}</b> de
      <b>{{ $recepcion->created_at->format('Y') }}</b>.</p>
 <div class="signs">
       <div class="sign">
        <div class="line">REPRESENTANTE</div>
        <div class="mini">{{ $recepcion->datos_encargado?: '—' }}</div>
        <div class="mini">{{ $recepcion->documento_encargado ?: '—' }}</div>
        
      </div>
      <div class="sign">
         <div class="line">EMPRESA RECEPTORA</div>
        <div class="mini">INNOVA CORPORATIVO S.A.</div>
        <div class="mini">RUC: 20613318021</div>
       
 </div>
 {{--<div class="signs">
    <div class="sign">
    <div class="line">EMPRESA ENTREGANTE</div>
        <div class="mini">{{ $recepcion->documento_ruc ?: '—' }}</div>
        <div class="mini">RUC: {{ $recepcion->nro_ruc ?: '—' }}</div>
        
      </div>
      <div class="sign">
        <div class="line">ENCARGADO RECEPCION</div>
        <div class="mini">{{ $recepcion->usuario->name ?? '__________' }}</div>
        <div class="mini">{{ $recepcion->usuario?->email ? explode('@',$recepcion->usuario->email)[0] : '__________' }}</div>
      </div>--}}
    </div>
  </div>

</div>
</body>
</html>
