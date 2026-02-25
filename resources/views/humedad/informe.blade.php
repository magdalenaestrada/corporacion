<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Informe de Ensayo</title>

  <style>
    /* =========================
       CONFIGURACIÓN A4
    ========================== */
    @page { size: A4; margin: 18mm 16mm; }

    body{
      font-family: Arial, Helvetica, sans-serif;
      font-size: 11px;
      color:#000;
      margin:0;
      padding:0;
      background:#f2f2f2; /* solo vista previa */
    }

    /* Vista previa centrada */
    .preview-wrap{
      display:flex;
      justify-content:center;
      padding:16px 0;
    }

    /* Hoja A4 */
    .sheet{
      position: relative;
      width: 210mm;
      min-height: 297mm;
      background:#fff;

      /* ✅ En pantalla: padding normal */
      padding: 18mm 16mm;

      box-shadow: 0 0 8px rgba(0,0,0,.15);
      box-sizing:border-box;
      overflow:hidden;
    }

    @media print{
      body{ background:#fff; }
      .preview-wrap{ padding:0; }
      .sheet{
        width:auto;
        min-height:auto;
        box-shadow:none;

        /* ✅ En impresión: deja espacio arriba para papel membretado */
        padding: 30mm 16mm 18mm 16mm;
      }

      .no-print{ display:none !important; }

      /* ✅ Ocultar cabecera y marca de agua SOLO al imprimir */
      .only-screen{ display:none !important; }
    }

    /* =========================
       MARCA DE AGUA (SOLO PANTALLA)
    ========================== */
    .watermark{
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 0;
      pointer-events: none;
    }

    .watermark img{
      width: 420px;
      max-width: 80%;
      opacity: 0.08;
    }

    /* =========================
       CONTENIDO ENCIMA
    ========================== */
    .content{
      position: relative;
      z-index: 2;
    }

    /* =========================
       BOTÓN IMPRIMIR
    ========================== */
    .no-print{
      display:flex;
      justify-content:flex-end;
      margin-bottom:10px;
    }

    .btn-print{
      border:1px solid #999;
      background:#fff;
      padding:6px 10px;
      cursor:pointer;
      font-size:11px;
      border-radius:4px;
    }

    /* =========================
       HEADER (SOLO PANTALLA)
    ========================== */
    .brand-wrap{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:12px;
      padding:10px;
      border:1px solid #d6d6d6;
      border-left:6px solid #7b0f1a;
      border-radius:8px;
      background:#fafafa;
      margin-bottom:12px;
    }

    .brand-left{
      display:flex;
      align-items:center;
      gap:12px;
    }

    .logo-box{
      width:58px;
      height:58px;
      display:flex;
      align-items:center;
      justify-content:center;
      flex:0 0 58px;
    }

    .brand-logo{
      max-width:58px;
      max-height:58px;
      object-fit:contain;
    }

    .brand{
      font-size:14px;
      font-weight:700;
      color:#7b0f1a;
      text-transform:uppercase;
    }

    .sub{
      font-size:10px;
      color:#333;
    }

    .brand-right{
      text-align:right;
      font-size:10px;
      line-height:1.2;
    }

    /* =========================
       TEXTO Y TABLAS
    ========================== */
    .title{
      text-align:center;
      font-weight:bold;
      text-transform:uppercase;
      margin:10px 0 14px 0;
      font-size:13px;
    }

    .section{ margin-top:8px; }
    .section-title{
      font-weight:bold;
      text-transform:uppercase;
      margin-bottom:4px;
      color:#7b0f1a;
    }

    .line{ display:flex; margin:2px 0; }
    .label{
      width:230px;
      font-weight:bold;
      text-transform:uppercase;
    }
    .value{
      flex:1;
      text-transform:uppercase;
    }

    table{
      border-collapse:collapse;
      width:100%;
      margin-top:6px;
    }

    th,td{
      border:1px solid #000;
      padding:4px 6px;
      vertical-align:middle;
    }

    th{
      font-weight:bold;
      text-transform:uppercase;
      text-align:center;
      background:#f8f8f8;
    }

    .center{ text-align:center; }
    .bold{ font-weight:bold; }
    .no-break{ page-break-inside:avoid; }
  </style>
</head>

<body>
<div class="preview-wrap">
  <div class="sheet">

    <!-- ✅ SOLO PANTALLA: marca de agua (en impresión se oculta por .only-screen) -->
    <div class="watermark only-screen">
      <img src="{{ asset('images/innovalogo.png') }}" alt="Marca de agua">
    </div>

    <div class="content">

      <div class="no-print">
        <button class="btn-print" onclick="window.print()">Imprimir</button>
      </div>

      <!-- ✅ SOLO PANTALLA: cabecera (en impresión se oculta por .only-screen) -->
      <div class="brand-wrap only-screen">
        <div class="brand-left">
          <div class="logo-box">
            <img src="{{ asset('images/innovalogo.png') }}" class="brand-logo">
          </div>
          <div>
            <div class="brand">INNOVA CORPORATIVO S.A.</div>
            <div class="sub">RUC: 20613318021</div>
          </div>
        </div>
        <div class="brand-right">
          <strong>INFORME DE ENSAYO</strong><br>
          N.° {{ $humedad->id }}
        </div>
      </div>

      <div class="title">
        INFORME DE ENSAYO N.° {{ $humedad->codigo ?? $humedad->id }}
      </div>

      <!-- 1. DATOS -->
      <div class="section">
        <div class="section-title">1. DATOS</div><br>
        <div class="line">
          <div class="label">1.1. CLIENTE</div>
          <div class="value">
            : {{ $humedad->cliente->razon_social ?? '' }}
            {{ !empty($humedad->cliente_detalle) ? ' - '.$humedad->cliente_detalle : '' }}
          </div>
        </div>
      </div>

      <!-- 2. DATOS DE LA MUESTRA -->
      <div class="section">
        <div class="section-title">2. DATOS DE LA MUESTRA</div><br>

        <div class="line"><div class="label">2.1. MINERAL</div><div class="value">: {{ $humedad->mineral->nombre ?? '' }}</div></div>
        <div class="line"><div class="label">2.2. MUESTRADO POR</div><div class="value">: INNOVA CORPORATIVO</div></div>
        <div class="line"><div class="label">2.3. FECHA DE RECEPCIÓN</div><div class="value">: {{ optional($humedad->fecha_recepcion)->format('d-m-Y') }}</div></div>
        <div class="line"><div class="label">2.4. PERIODO DE ENSAYO</div><div class="value">: {{ optional($humedad->periodo_inicio)->format('d-m-Y') }} AL {{ optional($humedad->periodo_fin)->format('d-m-Y') }}</div></div>
        <div class="line"><div class="label">2.5. FECHA DE EMISIÓN</div><div class="value">: {{ optional($humedad->fecha_emision)->format('d-m-Y') }}</div></div>
        <div class="line"><div class="label">2.6. FECHA Y HORA DEL MUESTREO</div><div class="value">: MOMENTO PRECISO DE LA RECEPCIÓN DE LA MUESTRA</div></div>
      </div>

      <!-- 3. ENSAYO -->
      <div class="section no-break">
        <div class="section-title">3. ENSAYO SOLICITADO: METODOLOGÍA APLICADA</div><br>

        <table style="width:75%; margin:0 auto;">
          <tr><th>ENSAYO</th><th>MÉTODO</th></tr>
          <tr>
            <td class="center bold">HUMEDAD</td>
            <td>
              MÉTODO DE SECADO HASTA MASA CONSTANTE POR TERMOGRAVIMETRÍA,
              MÉTODO VALIDADO CON NTP-ISO 10251.
            </td>
          </tr>
        </table>

        <div class="section-title" style="margin-top:10px;">3.1. DATOS DEL MÉTODO</div>

        <table style="width:50%; margin:0 auto; text-align:center;">
          <tr><th>PARÁMETRO</th><th>UNIDAD</th><th>LMC</th></tr>
          <tr><td class="bold">HUMEDAD</td><td>%</td><td>0.01</td></tr>
        </table>
      </div>

      <!-- 4. RESULTADO -->
      <div class="section no-break">
        <div class="section-title">4. RESULTADO</div>

        <table style="width:85%; margin:0 auto;">
          <tr>
            <td rowspan="2" class="center bold">IDENTIFICACIÓN DE LA MUESTRA</td>
            <td class="center bold">ELEMENTO</td>
          </tr>
          <tr><td class="center bold">H2O %</td></tr>
          <tr>
            <td class="center bold">
              {{ $humedad->cliente->razon_social ?? '' }}
              {{ !empty($humedad->cliente_detalle) ? ' - '.$humedad->cliente_detalle : '' }}<br>
              <span style="font-weight:normal;">
                W = {{ number_format($pesoTotal ?? 0, 0, '.', ',') }}
              </span>
            </td>
            <td class="center bold" style="font-size:12px;">
              {{ $humedad->humedad }}
            </td>
          </tr>
        </table>

        <div class="section" style="margin-top:10px;">
          <span class="bold">OBSERVACIONES:</span>
          {{ $humedad->observaciones ?? 'SIN OBSERVACIONES' }}
        </div>
      </div>

    </div>
  </div>
</div>
</body>
</html>
