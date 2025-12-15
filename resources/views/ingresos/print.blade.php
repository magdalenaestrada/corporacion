<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ __('DETALLE DE INGRESO') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Estilos de Bootstrap -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
            color: #333;
            background-color: #f9f9f9;
        }
        h2 {
            text-align: center;
            color: #000000;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 2px solid #080707;
            text-align: left;
            padding: 5px;
        }
        th {
            background-color: #be748b;
            color: white;
        }
        .half {
            width: 30%;
        }
        .print-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #be748b;
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .print-button:hover {
            background-color: #a7627a;
        }
        @media print {
            .print-button {
                display: none; /* Ocultar el botón al imprimir */
            }
        }
    </style>
</head>
<body>
    <div class="logo">
        <span><img src="{{ asset('images/innovalogo.png') }}" alt="" style="width: 100px;"></span>
    </div>
   
    <h2>{{ __('INNOVA MINNING COMPANY E.I.R.L') }}</h2>
    <h3 style="text-align: center;">{{ __('DETALLE DE INGRESO ') }}</h3>
    <table>
        <tr>
            <th class="half">{{ __('CODIGO:') }}</th>
            <td class="half">{{ $ingreso->codigo }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('FECHA DE INGRESO:') }}</th>
            <td class="half">{{ $ingreso->fecha_ingreso }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('PRODUCTO:') }}</th>
            <td class="half">{{ $ingreso->estado }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('REFERENCIA LOTE:') }}</th>
            <td class="half">{{ $ingreso->ref_lote }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('DNI / RUC:') }}</th>
            <td class="half">{{ $ingreso->identificador }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('NOMBRE / RAZONSOCIAL:') }}</th>
            <td class="half">{{ $ingreso->nom_iden }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('PESO EXTERNO:') }}</th>
            <td class="half">{{ $ingreso->pesoexterno }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('DESCUENTO:') }}</th>
            <td class="half">{{ $ingreso->descuento }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('DESCRIPCION:') }}</th>
            <td class="half">{{ $ingreso->descripcion }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('PESO TOTAL:') }}</th>
            <td class="half">{{ $ingreso->peso_total }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('NUMERO DE TICKET:') }}</th>
            <td class="half">{{ $ingreso->NroSalida }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('PLACA:') }}</th>
            <td class="half">{{ $ingreso->placa }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('PROCEDENCIA:') }}</th>
            <td class="half">{{ $ingreso->procedencia }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('DEPOSITO:') }}</th>
            <td class="half">{{ $ingreso->deposito }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('BALANZA:') }}</th>
            <td class="half">{{ $ingreso->balanza }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('TOLVA:') }}</th>
            <td class="half">{{ $ingreso->tolva }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('GUIA TRANSPORTE:') }}</th>
            <td class="half">{{ $ingreso->guia_transporte }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('GUIA REMISION:') }}</th>
            <td class="half">{{ $ingreso->guia_remision }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('MUESTREO:') }}</th>
            <td class="half">{{ $ingreso->muestreo }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('PREPARACION:') }}</th>
            <td class="half">{{ $ingreso->preparacion }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('REQ. ANALISIS NASCA LAB:') }}</th>
            <td class="half">{{ $ingreso->req_analisis }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('REQ. ANALISIS LAB PERU:') }}</th>
            <td class="half">{{ $ingreso->req_analisis1 }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('FECHA SALIDA:') }}</th>
            <td class="half">{{ $ingreso->fecha_salida }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('RETIRO:') }}</th>
            <td class="half">{{ $ingreso->retiro }}</td>
        </tr>
        <tr>
            <th class="half">{{ __('LOTE:') }}</th>
            <td class="half">{{ $ingreso->lote }}</td>
        </tr>
    </table>

    <button class="print-button" onclick="window.print();">{{ __('Imprimir') }}</button>
</body>
</html>
