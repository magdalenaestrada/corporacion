@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-lg">
        <div class="card-header  text-black d-flex justify-content-between">
            <h5 class="mb-0">Detalles de la Fina</h5>
            <div class="d-flex justify-content-start align-items-center gap-3">
                <!-- Botón de impresión -->
                <button class="btn btn-success btn-sm" onclick="printFina({{ $fina->id }})">
                    🖨️ IMPRIMIR
                </button>
            
                <!-- Botón de volver -->
                <a class="btn btn-danger btn-sm" href="{{ route('procesadas') }}">
                    {{ __('VOLVER') }}
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <div class="alert alert-success" role="alert">
                <strong>{{ __('Estás viendo el ID') }}</strong> 
                <span class="badge bg-secondary">{{ $fina->id }}</span>
                <strong>{{ __('registrado el ') }}</strong> {{ $fina->created_at->format('d-m-Y H:i:s') }}
            </div>

            <h4 class="text-black text-center mt-4">
                <strong>{{ $fina->codigoBlending ?? 'N/A' }}</strong>
            </h4>

            @if($fina->liquidaciones->isEmpty())
                <p class="text-danger">No hay liquidaciones asociadas a esta fina.</p>
            @else
                <!-- Contenedor con scroll horizontal -->
                <div class="table-responsive">
                    @php
                        $totalTMH = 0;
                        $totalTMS = 0;
                        $sumaProductoTMSCu = 0;
                        $sumaProductoTMSAg = 0;
                        $sumaProductoTMSAu = 0;
                        $sumaProductoTMSAs = 0;
                        $sumaProductoTMSSb = 0;
                        $sumaProductoTMSPb = 0;
                        $sumaProductoTMSZn = 0;
                        $sumaProductoTMSBi = 0;
                        $sumaProductoTMSHg = 0;
                        $totalValorLote = 0;
                        $totalLiquidacion = 0;

                        foreach ($fina->liquidaciones as $liq) {
                            $tmh = $liq->peso ?? 0;
                            $tms = $liq->tms ?? 0;
                            $totalTMH += $tmh;
                            $totalTMS += $tms;

                            $muestra = $liq->muestra;

                            if ($muestra) {
                                $sumaProductoTMSCu += $tms * $muestra->cu;
                                $sumaProductoTMSAg += $tms * $muestra->ag;
                                $sumaProductoTMSAu += $tms * $muestra->au;
                                $sumaProductoTMSAs += $tms * $muestra->as;
                                $sumaProductoTMSSb += $tms * $muestra->sb;
                                $sumaProductoTMSPb += $tms * $muestra->pb;
                                $sumaProductoTMSZn += $tms * $muestra->zn;
                                $sumaProductoTMSBi += $tms * $muestra->bi;
                                $sumaProductoTMSHg += $tms * $muestra->hg;
                            }

                            $totalValorLote += $liq->valorporlote ?? 0;
                            $totalLiquidacion += $liq->total ?? 0;
                        }

                        $porcentajeH2O = $totalTMH > 0 ? (($totalTMH - $totalTMS) / $totalTMH) * 100 : 0;

                        $promCu = $totalTMS > 0 ? $sumaProductoTMSCu / $totalTMS : 0;
                        $promAg = $totalTMS > 0 ? $sumaProductoTMSAg / $totalTMS : 0;
                        $promAu = $totalTMS > 0 ? $sumaProductoTMSAu / $totalTMS : 0;
                        $promAs = $totalTMS > 0 ? $sumaProductoTMSAs / $totalTMS : 0;
                        $promSb = $totalTMS > 0 ? $sumaProductoTMSSb / $totalTMS : 0;
                        $promPb = $totalTMS > 0 ? $sumaProductoTMSPb / $totalTMS : 0;
                        $promZn = $totalTMS > 0 ? $sumaProductoTMSZn / $totalTMS : 0;
                        $promBi = $totalTMS > 0 ? $sumaProductoTMSBi / $totalTMS : 0;
                        $promHg = $totalTMS > 0 ? $sumaProductoTMSHg / $totalTMS : 0;
                    @endphp
                    <table class="table table-bordered table-liquidaciones">
                        <thead class="thead-blue">
                            <tr>
                                <th>Liquidación ID</th>
                                
                                <th>Cliente</th>
                                <th>Nota</th>
                                <th>Creación Liquidación</th>
                                <th>Nombre Lote</th>
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
                            @foreach($fina->liquidaciones as $liquidacion)
                                <tr>
                                    <td>{{ $liquidacion->id }}</td>
                                    <td>{{ $liquidacion->cliente->datos_cliente }}</td>
                                    <td>{{ $liquidacion->comentario }}</td>
                                    <td>{{ $liquidacion->created_at }}</td>
                                    <td>{{ $liquidacion->lote }}</td>
                                    <td>{{ $liquidacion->NroSalida }}</td>
                                    <td>{{ $liquidacion->producto }}</td>
                                    <td>{{ number_format($liquidacion->peso, 3) }}</td>
                                    <td>{{ number_format($liquidacion->muestra ? $liquidacion->muestra->humedad : 0, 3) }}</td>
                                    <td>{{ number_format($liquidacion->tms, 3) }}</td>
                                    <td>{{ $liquidacion->muestra ? $liquidacion->muestra->codigo : 'N/A' }}</td>
                                    <td>{{ number_format($liquidacion->muestra->cu ?? 0, 3) }}</td>
                                    <td>{{ number_format($liquidacion->muestra->ag ?? 0, 3) }}</td>
                                    <td>{{ number_format($liquidacion->muestra->au ?? 0, 3) }}</td>
                                    <td>{{ number_format($liquidacion->muestra->as ?? 0, 3) }}</td>
                                    <td>{{ number_format($liquidacion->muestra->sb ?? 0, 3) }}</td>
                                    <td>{{ number_format($liquidacion->muestra->pb ?? 0, 3) }}</td>
                                    <td>{{ number_format($liquidacion->muestra->zn ?? 0, 3) }}</td>
                                    <td>{{ number_format($liquidacion->muestra->bi ?? 0, 3) }}</td>
                                    <td>{{ number_format($liquidacion->muestra->hg ?? 0, 3) }}</td>
                                    <td>{{ $liquidacion->estado ?? 'PROVISIONAL' }}</td>
                                    <td>${{ number_format($liquidacion->valorporlote, 2) }}</td>
                                    <td>${{ number_format($liquidacion->total, 2) }}</td>
                                </tr>
                            @endforeach
                            <tr class="table-footer">
                                <td colspan="7">Totales</td>
                                <td>{{ number_format($totalTMH, 3) }}</td>
                                <td>{{ number_format($porcentajeH2O, 3) }}</td>
                                <td>{{ number_format($totalTMS, 3) }}</td>
                                <td></td>
                                <td>{{ number_format($promCu, 3) }}</td>
                                <td>{{ number_format($promAg, 3) }}</td>
                                <td>{{ number_format($promAu, 3) }}</td>
                                <td>{{ number_format($promAs, 3) }}</td>
                                <td>{{ number_format($promSb, 3) }}</td>
                                <td>{{ number_format($promPb, 3) }}</td>
                                <td>{{ number_format($promZn, 3) }}</td>
                                <td>{{ number_format($promBi, 3) }}</td>
                                <td>{{ number_format($promHg, 3) }}</td>
                                <td></td>
                                <td>${{ number_format($totalValorLote, 2) }}</td>
                                <td>${{ number_format($totalLiquidacion, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .table-liquidaciones {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .table-liquidaciones th {
        background: linear-gradient(135deg, #1c445f, #306b8a);
        color: white;
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }

    .table-liquidaciones td {
        background-color: white;
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
        color: #333;
    }

    .table-liquidaciones tr:hover {
        background-color: #f1f8ff;
        transition: background-color 0.3s;
    }

    .table-footer {
        background-color: #e3f2fd !important;
        font-weight: bold;
        font-size: 16px;
    }

    .table-responsive {
        overflow-x: auto;
        max-width: 100%;
    }

    .btn-success {
        display: flex;
        align-items: center;
        gap: 5px;
    }
</style>

@endsection
