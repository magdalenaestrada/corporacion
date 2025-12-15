@extends('layouts.app')

@section('content')
<style>
    h1 {
        color: #ffffff;
        margin-bottom: 20px;
        font-weight: bold;
        font-size: 28px;
        text-align: center;
    }

    .form-container {
        margin: 20px auto;
        max-width: 400px;
        display: flex;
        align-items: center;
        gap: 12px;
        justify-content: center;
    }

    .form-container label {
        font-weight: bold;
        color: #ffffff;
        margin: 0;
    }

    .form-container input[type="text"] {
        padding: 8px 14px;
        font-size: 15px;
        border-radius: 6px;
        border: 1px solid #ccc;
        width: 250px;
    }

    .btn-confirmar {
        background-color: #007bff;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin: 20px auto;
        display: block;
    }

    .btn-confirmar:hover {
        background-color: #0056b3;
    }
    
        .tabla-blending {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .tabla-blending th {
        background: linear-gradient(135deg, #1c445f, #306b8a);
        color: white;
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }

    .tabla-blending td {
        background-color: white;
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
        color: #333;
    }

    .tabla-blending tr:hover {
        background-color: #f1f8ff;
        transition: background-color 0.3s;
    }

    .tabla-blending .totales {
        background-color: #e3f2fd;
        font-weight: bold;
        font-size: 18px;
    }
</style>


<div class="container-fluid">
    <form action="{{ route('finas.store') }}" method="POST">
        @csrf

      <h1>Blending de Liquidaciones</h1>


       

       <table class="tabla-blending">
        <thead>
<div class="form-container">
    <label for="codigoBlending">Código de Blending:</label>
    <input type="text" id="codigoBlending" name="codigoBlending" placeholder="Ingrese el código aquí" required>
</div>
            <tr>
                <th>Liquidación ID</th>
                <th>Cliente</th>
                <th>Creación Liquidación</th>
                <th>Nombre Lote</th>
                <th>Nota</th>
                <th>Ticket Nro Salida</th>
                <th>Producto</th>
                <th>TMH</th>
                <th>%H2O</th>
                <th>TMS</th>
                <th>Código Muestra</th>
                <th>%Cu</th>
                <th>Ag oz/tc</th>
                <th>Au oz/tc</th>
                <th>%As</th>
                <th>%Sb</th>
                <th>%Pb</th>
                <th>%Zn</th>
                <th>%Bi</th>
                <th>%Hg</th>
                <th>Estado</th>
                <th>Valor Por Lote US$</th>
                <th>Total Liquidación</th>
            </tr>
        </thead>
        <tbody>
            @php
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
            @endphp
            @foreach ($liquidaciones as $liquidacion)
                <tr>
                    <td>{{ $liquidacion->id }}</td>
                    <td>{{ $liquidacion->cliente->datos_cliente }}</td>
                    <td>{{ $liquidacion->created_at }}</td>
                    <td>{{ $liquidacion->lote }}</td>
                    <td contenteditable="true" class="editable">{{ $liquidacion->comentario }}</td>
                    <td>{{ $liquidacion->NroSalida }}</td>
                    <td>{{ $liquidacion->producto }}</td>
                    <td>{{ number_format($liquidacion->peso, 3) }}</td>
                    @php $totalTMH += $liquidacion->peso; @endphp
                    <td>{{ number_format($liquidacion->muestra ? $liquidacion->muestra->humedad : 0, 3) }}</td>
                    <td>{{ number_format($liquidacion->tms, 3) }}</td>
                    @php $totalTMS += $liquidacion->tms; @endphp
                    @if ($liquidacion->muestra)
                        <td>{{ $liquidacion->muestra->codigo }}</td>    
                        <td>{{ number_format($liquidacion->muestra->cu, 3) }}</td>
                        @php $sumaProductoTMSCu += $liquidacion->tms * $liquidacion->muestra->cu; @endphp
                        <td>{{ number_format($liquidacion->muestra->ag, 3) }}</td>
                        @php $sumaProductoTMSAg += $liquidacion->tms * $liquidacion->muestra->ag; @endphp
                        <td>{{ number_format($liquidacion->muestra->au, 3) }}</td>
                        @php $sumaProductoTMSAu += $liquidacion->tms * $liquidacion->muestra->au; @endphp
                        <td>{{ number_format($liquidacion->muestra->as, 3) }}</td>
                        @php $sumaProductoTMSAs += $liquidacion->tms * $liquidacion->muestra->as; @endphp
                        <td>{{ number_format($liquidacion->muestra->sb, 3) }}</td>
                        @php $sumaProductoTMSSb += $liquidacion->tms * $liquidacion->muestra->sb; @endphp
                        <td>{{ number_format($liquidacion->muestra->pb, 3) }}</td>
                        @php $sumaProductoTMSPb += $liquidacion->tms * $liquidacion->muestra->pb; @endphp
                        <td>{{ number_format($liquidacion->muestra->zn, 3) }}</td>
                        @php $sumaProductoTMSZn += $liquidacion->tms * $liquidacion->muestra->zn; @endphp
                        <td>{{ number_format($liquidacion->muestra->bi, 3) }}</td>
                        @php $sumaProductoTMSBi += $liquidacion->tms * $liquidacion->muestra->bi; @endphp
                        <td>{{ number_format($liquidacion->muestra->hg, 3) }}</td>
                        @php $sumaProductoTMSHg += $liquidacion->tms * $liquidacion->muestra->hg; @endphp
                    @else
                        <td colspan="11" class="no-muestra">No hay muestra asociada</td>
                    @endif
                    <td>{{ $liquidacion->estado ?? 'PROVISIONAL' }}</td>
                    <td>{{ number_format($liquidacion->valorporlote, 3) }}</td>
                    @php $totalValorLote += $liquidacion->valorporlote; @endphp
                    <td>{{ number_format($liquidacion->total, decimals: 3) }}</td>
                    @php $totalLiquidacion += $liquidacion->total; @endphp
                </tr>
            @endforeach
            @php
                $porcentajeH2O = $totalTMH > 0 ? (($totalTMH - $totalTMS) / $totalTMH) * 100 : 0;
                $promedioPonderadoCu = $totalTMS > 0 ? $sumaProductoTMSCu / $totalTMS : 0;
                $promedioPonderadoAg = $totalTMS > 0 ? $sumaProductoTMSAg / $totalTMS : 0;
                $promedioPonderadoAu = $totalTMS > 0 ? $sumaProductoTMSAu / $totalTMS : 0;
                $promedioPonderadoAs = $totalTMS > 0 ? $sumaProductoTMSAs / $totalTMS : 0;
                $promedioPonderadoSb = $totalTMS > 0 ? $sumaProductoTMSSb / $totalTMS : 0;
                $promedioPonderadoPb = $totalTMS > 0 ? $sumaProductoTMSPb / $totalTMS : 0;
                $promedioPonderadoZn = $totalTMS > 0 ? $sumaProductoTMSZn / $totalTMS : 0;
                $promedioPonderadoBi = $totalTMS > 0 ? $sumaProductoTMSBi / $totalTMS : 0;
                $promedioPonderadoHg = $totalTMS > 0 ? $sumaProductoTMSHg / $totalTMS : 0;
            @endphp
            <tr class="totales">
                <td colspan="7">Totales</td>
                <td>{{ number_format($totalTMH, 3) }}</td>
                <td>{{ number_format($porcentajeH2O, 3) }}</td>
                <td>{{ number_format($totalTMS, 3) }}</td>
                <td></td>
                <td>{{ number_format($promedioPonderadoCu, 3) }}</td>       
                <td>{{ number_format($promedioPonderadoAg, 3) }}</td>
                <td>{{ number_format($promedioPonderadoAu, 3) }}</td>
                <td>{{ number_format($promedioPonderadoAs, 3) }}</td>
                <td>{{ number_format($promedioPonderadoSb, 3) }}</td>
                <td>{{ number_format($promedioPonderadoPb, 3) }}</td>
                <td>{{ number_format($promedioPonderadoZn, 3) }}</td>
                <td>{{ number_format($promedioPonderadoBi, 3) }}</td>
                <td>{{ number_format($promedioPonderadoHg, 3) }}</td>
                <td></td>
                <td>{{ number_format($totalValorLote, 3) }}</td>
                <td>{{ number_format($totalLiquidacion, 3) }}</td>
            </tr>
        </tbody>
    </table>
        @foreach ($liquidaciones as $liquidacion)
            <input type="hidden" name="liquidaciones[]" value="{{ $liquidacion->id }}">
        @endforeach

       <button type="submit" class="btn-confirmar">Confirmar Blending</button>
    </form>
</div>
@endsection
