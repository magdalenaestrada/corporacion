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
            cursor: pointer; /* Hace que parezca clickeable */
        }
        th {
            background-color: #0b2942;
            color: white;
        }
        .highlight {
            background-color: #5ee20b !important; /* Verde */
            color: white;
            font-weight: bold;
        }
        .print-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #0b2942;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .print-button:hover {
            background-color: #0b2942;
        }
        @media print {

    /* Ocultar el botón */
    .print-button {
        display: none !important;
    }

    /* Fondo limpio */
    body {
        background: white !important;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        page-break-inside: auto;
    }

    thead {
        display: table-header-group; /* Repite encabezado */
    }

    tfoot {
        display: table-footer-group;
    }

    tr {
        page-break-inside: avoid;  /* Evitar que una fila se corte */
        page-break-after: auto;
    }

    td, th {
        padding: 4px;
        border: 1px solid #000;
    }

    /* Quitar este HORROR que te rompe todo XD */
    tbody tr:nth-child(n+26) {
        page-break-before: auto !important;
    }

    /* Mantener color verde en impresión */
    .highlight {
        background-color: #5ee20b !important;
        color: white !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
}
    </style>
</head>
<body>
    <div class="logo">
        <span><img src="{{ asset('images/innovalogo.png') }}" alt="" style="width: 100px;"></span>
    </div>

    <h3 style="text-align: center;">{{ __('Detalle de Liquidaciones') }}</h3>
    <table style="font-size: 10px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Nota</th>
                <th>Nombre Lote</th>
                <th>Referencia Lote</th>
                <th>Codigo</th>
                <th>Fecha</th>
                <th>Producto</th>
                <th>TMH</th>
                <th>%H2O</th>
                <th>TMS</th>
                <th>%Cu</th>
                <th>Ag oz/tc</th>
                <th>Au oz/tc</th>
                <th>%As</th>
                <th>%Sb</th>
                <th>%Pb</th>
                <th>%Zn</th>
                <th>%Bi</th>
                <th>%Hg</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fina->liquidaciones as $liquidacion)
                <tr>
                    <td>{{ $liquidacion->id }}</td>
                    <td>{{ $liquidacion->cliente->datos_cliente }}</td>
                    <td contenteditable="true" class="editable">{{ $liquidacion->comentario }}</td>
                    <td>{{ $liquidacion->lote }}</td>
                    <td>{{ $liquidacion->ref_lote }}</td>
                    <td>{{ $liquidacion->NroSalida }}</td>
                    <td>{{ $liquidacion->created_at->format('d-m-Y') }}</td>
                    <td>{{ $liquidacion->producto }}</td>
                    <td>{{ number_format($liquidacion->peso, 3) }}</td>
                    <td>{{ number_format($liquidacion->muestra->humedad ?? 0, 3) }}</td>
                    <td>{{ number_format($liquidacion->tms, 3) }}</td>
                    <td class="clickable">{{ number_format($liquidacion->muestra->cu ?? 0, 3) }}</td>
                    <td class="clickable">{{ number_format($liquidacion->muestra->ag ?? 0, 3) }}</td>
                    <td class="clickable">{{ number_format($liquidacion->muestra->au ?? 0, 3) }}</td>
                    <td>{{ number_format($liquidacion->muestra->as ?? 0, 3) }}</td>
                    <td>{{ number_format($liquidacion->muestra->sb ?? 0, 3) }}</td>
                    <td>{{ number_format($liquidacion->muestra->pb ?? 0, 3) }}</td>
                    <td>{{ number_format($liquidacion->muestra->zn ?? 0, 3) }}</td>
                    <td>{{ number_format($liquidacion->muestra->bi ?? 0, 3) }}</td>
                    <td>{{ number_format($liquidacion->muestra->hg ?? 0, 3) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>

    <table class="table table-sm table-bordered mt-3 text-center" style="width: 25%; margin: auto; font-size: 9px;">
        <thead class="table-info">
            <tr>
                <th colspan="2" class="text-center">Totales y Promedios</th>
            </tr>
        </thead>
        <tbody>
            <tr><td><strong>Total TMH</strong></td><td>{{ number_format($fina->total_tmh, 3) }} TMH</td></tr>
            <tr><td><strong>Porcentaje H2O</strong></td><td>{{ number_format($fina->porcentaje_h2o, 3) }}%</td></tr>
            <tr><td><strong>Total TMS</strong></td><td>{{ number_format($fina->total_tms, 3) }} TMS</td></tr>
            <tr><td class="clickable"><strong>Promedio %Cu</strong></td><td class="clickable">{{ number_format($fina->cu_promedio, 3) }}</td></tr>
            <tr><td class="clickable"><strong>Promedio Ag oz/tc</strong></td><td class="clickable">{{ number_format($fina->ag_promedio, 3) }}</td></tr>
            <tr><td class="clickable"><strong>Promedio Au oz/tc</strong></td><td class="clickable">{{ number_format($fina->au_promedio, 3) }}</td></tr>
            <tr><td><strong>Promedio %As</strong></td><td>{{ number_format($fina->as_promedio, 3) }}</td></tr>
            <tr><td><strong>Promedio %Sb</strong></td><td>{{ number_format($fina->sb_promedio, 3) }}</td></tr>
            <tr><td><strong>Promedio %Pb</strong></td><td>{{ number_format($fina->pb_promedio, 3) }}</td></tr>
            <tr><td><strong>Promedio %Zn</strong></td><td>{{ number_format($fina->zn_promedio, 3) }}</td></tr>
            <tr><td><strong>Promedio %Bi</strong></td><td>{{ number_format($fina->bi_promedio, 3) }}</td></tr>
            <tr><td><strong>Promedio %Hg</strong></td><td>{{ number_format($fina->hg_promedio, 3) }}</td></tr>
           
        </tbody>
    </table>

    <button class="print-button" onclick="window.print();">🖨️ IMPRIMIR</button>

    

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".clickable").forEach(function (cell) {
                cell.addEventListener("click", function () {
                    this.classList.toggle("highlight");
                });
            });
        });
    </script>
</body>
</html>
