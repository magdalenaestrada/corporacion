@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Contenedor con título a la izquierda y botones a la derecha -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <!-- Título a la izquierda -->
        <h1 class="text-left" style="font-size: 1.5rem;">LOTIZACIÓN DE INGRESOS</h1>
        
        <!-- Botones a la derecha -->
        <div>
            <a href="{{ route('ingresos.index') }}" class="btn btn-light mx-2">Ingresos</a>
            <a href="{{ route('blendings.index') }}" class="btn btn-light mx-2">Blending</a>
            <a href="{{ route('despachos.index') }}" class="btn btn-light  mx-2">Despachos</a>
<a href="{{ route('chancado') }}" 
   class="btn fw-bold text-white mx-2" 
   style="background: linear-gradient(45deg, #f39c12, #e67e22); box-shadow: 0 4px 12px rgba(0,0,0,0.2); border: none;">
   🪨 Chancado
</a>
     </div>
    </div>

    <!-- Nueva Sección: Estadísticas de Peso -->
    <div class="text-center w-100 mb-3">
        <span class="badge bg-dark fs-6 p-3">
            {{ __('Total Registros: ') }} {{ $ingresos->count() }}
        </span>
        <span class="badge bg-info fs-6 p-3">
            {{ __('Peso Total: ') }} {{ number_format($pesoTotal, 3) }} 
        </span>
        <span class="badge bg-primary fs-6 p-3">
            {{ __('Peso Ingresados: ') }} {{ number_format($pesoIngresados, 3) }}
        </span>
        <span class="badge bg-warning fs-6 p-3 text-dark">
            {{ __('Peso Blending: ') }} {{ number_format($pesoBlending, 3) }}
        </span>
        <span class="badge bg-danger fs-6 p-3">
            {{ __('Peso Despachado: ') }} {{ number_format($pesoDespachado, 3) }}
        </span>
        <span class="badge bg-success text-white fs-6 p-3">
            {{ __('Peso en Stock: ') }} {{ number_format($pesoEnStock, 3) }}
        </span>
    </div>
    
    <div class="outer-grid">
        <div class="grid">
            @for ($i = 1; $i <= 504; $i++)
                @php
                    $ingresosLote = $ingresos->where('lote', $i);
                @endphp
                @if ($ingresosLote->isNotEmpty())
                    @php
                        $isBlending = $ingresosLote->first()->fase === 'BLENDING';
                        $totalPeso = $ingresosLote->sum('peso_total');
                        $codigo = $ingresosLote->pluck('codigo')->join(', ');
                        $estado = $ingresosLote->pluck('estado')->join(', ');
                        $fecha = $ingresosLote->pluck('fecha_ingreso')->join(', ');
                        $blendingsData = $ingresosLote->first()->blendings;
                        @endphp

                    <div class="cell {{ $isBlending ? 'blending' : 'filled' }}"
                         data-toggle="modal"
                         data-target="#infoModal"
                         data-codigo="{{ $codigo }}"
                         data-estado="{{ $estado }}"
                         data-peso_total="{{ $totalPeso }}"
                         data-fecha="{{ $fecha }}"
                         data-identificador="{{ $ingresosLote->pluck('identificador')->join(', ') }}"
                         data-nom_iden="{{ $ingresosLote->pluck('nom_iden')->join(', ') }}"
                         data-ref_lote="{{ $ingresosLote->pluck('ref_lote')->join(', ') }}"
                         @php
                            $nroSalida = $ingresosLote->pluck('NroSalida')->join(', ');
                        @endphp
                        data-nro_salida="{{ $nroSalida }}" 
                         data-procedencia="{{ $ingresosLote->pluck('procedencia')->join(', ') }}"
                         data-deposito="{{ $ingresosLote->pluck('deposito')->join(', ') }}"
                         data-balanza="{{ $ingresosLote->pluck('balanza')->join(', ') }}"
                         data-placa="{{ $ingresosLote->pluck('placa')->join(', ') }}"
                         data-tolva="{{ $ingresosLote->pluck('tolva')->join(', ') }}"
                         data-guia_transporte="{{ $ingresosLote->pluck('guia_transporte')->join(', ') }}"
                         data-guia_remision="{{ $ingresosLote->pluck('guia_remision')->join(', ') }}"
                         data-muestreo="{{ $ingresosLote->pluck('muestreo')->join(', ') }}"
                         data-preparacion="{{ $ingresosLote->pluck('preparacion')->join(', ') }}"
                         data-req_analisis="{{ $ingresosLote->pluck('req_analisis')->join(', ') }}"
                         data-descuento="{{ $ingresosLote->pluck('descuento')->join(', ') }}"
                         data-fecha_salida="{{ $ingresosLote->pluck('fecha_salida')->join(', ') }}"
                         data-retiro="{{ $ingresosLote->pluck('retiro')->join(', ') }}"
                         data-pesoexterno="{{ $ingresosLote->pluck('pesoexterno')->join(', ') }}"
                         data-lote="{{ $ingresosLote->first()->lote }}"
                         data-descripcion="{{ $ingresosLote->pluck('descripcion')->join(', ') }}">
                         <div class="info">
                            <p>
                                @if ($isBlending)
                                    @foreach ($blendingsData as $blending)
                                       {{ $blending->cod ?? 'N/A' }} -  {{ $blending->lista ?? 'N/A' }} - {{ $blending->pesoblending ?? 'N/A' }}<br>
                                    @endforeach
                                @else
                                    {{ $ingresosLote->first()->codigo }} - {{ $ingresosLote->first()->peso_total }} -{{ $ingresosLote->first()->ref_lote }}
                                @endif
                            </p>
                        </div>
                    </div>
                @else
                    <div class="cell empty">
                        <div class="info">
                            <p style="font-weight: bold; font-size: 14px;">{{ $i }}</p>
                        </div>
                    </div>
                @endif
            @endfor
        </div>
    </div>
</div>

<!-- Modal para información general -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #102c44; color: white;">
                <h5 class="modal-title" id="infoModalLabel">INFORMACION DEL REGISTRO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <p><strong>Códigos:</strong> <span id="modalCodigo"></span></p>
                        <p><strong>Fechas:</strong> <span id="modalFecha"></span></p>
                        <p><strong>Identificadores:</strong> <span id="modalIdentificador"></span></p>
                        <p><strong>Nombres/Razones Sociales:</strong> <span id="modalNomIden"></span></p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Referencias Lote:</strong> <span id="modalRefLote"></span></p>
                        <p><strong>Peso Total:</strong> <span id="modalPesoTotal"></span></p>
                        <p><strong>Estados:</strong> <span id="modalEstado"></span></p>
                        <p><strong>Números de Ticket:</strong> <span id="modalNroSalida"></span></p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Procedencias:</strong> <span id="modalProcedencia"></span></p>
                        <p><strong>Depositos:</strong> <span id="modalDeposito"></span></p>
                        <p><strong>Balanza:</strong> <span id="modalBalanza"></span></p>
                        <p><strong>Placas:</strong> <span id="modalPlaca"></span></p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Tolvas:</strong> <span id="modalTolva"></span></p>
                        <p><strong>Guias de Transporte:</strong> <span id="modalGuiaTransporte"></span></p>
                        <p><strong>Guias de Remisión:</strong> <span id="modalGuiaRemision"></span></p>
                        <p><strong>Muestreos:</strong> <span id="modalMuestreo"></span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <p><strong>Preparaciones:</strong> <span id="modalPreparacion"></span></p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Requerimientos de Análisis:</strong> <span id="modalReqAnalisis"></span></p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Descuentos:</strong> <span id="modalDescuento"></span></p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Fechas de Salida:</strong> <span id="modalFechaSalida"></span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <p><strong>Retiros:</strong> <span id="modalRetiro"></span></p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Peso Externo:</strong> <span id="modalPesoExterno"></span></p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Lote:</strong> <span id="modalLote"></span></p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Descripciones:</strong> <span id="modalDescripcion"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .outer-grid {
        display: flex;
        flex-wrap: wrap;
    }
    .grid {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        gap: 10px;
    }
    .cell {
        border: 1px solid #ccc;
        padding: 20px;
        text-align: center;
        cursor: pointer;
    }
    .filled {
        background-color: #39ff14; /* Verde para "INGRESADO" */
    }
    .empty {
        background-color: #e61919; /* Rojo para registros vacíos */
    }
    .blending {
        background-color: #fbff20; /* Amarillo para "BLENDING" */
    }
</style>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
   $(document).ready(function() {
    $('.cell').on('click', function() {
        const datos = [
            'codigo', 'estado', 'peso_total', 'fecha', 'identificador', 
            'nom_iden', 'ref_lote', 'nro_salida', 
            'procedencia', 'deposito', 'balanza', 'placa', 
            'tolva', 'guia_transporte', 'guia_remision', 'muestreo', 
            'preparacion', 'req_analisis', 'descuento', 
            'fecha_salida', 'retiro', 'pesoexterno', 
            'lote', 'descripcion'
        ];
        
        datos.forEach(dato => {
            const valor = $(this).data(dato);
            console.log(dato, valor); // Imprime el valor para depuración
            $(`#modal${dato.charAt(0).toUpperCase() + dato.slice(1)}`).text(valor);
        });

        // Si quieres hacerlo solo para nro_salida.
        const pesototal  = $(this).data('peso_total');
        $('#modalPesoTotal').text(pesototal);
        const nomIden = $(this).data('nom_iden');
        $('#modalNomIden').text(nomIden);   
        const nroSalida = $(this).data('nro_salida');
        $('#modalNroSalida').text(nroSalida);
        const guiaTransporte = $(this).data('guia_transporte');
        $('#modalGuiaTransporte').text(guiaTransporte);
        const guiaRemision = $(this).data('guia_remision');
        $('#modalGuiaRemision').text(guiaRemision);
        const refLote = $(this).data('ref_lote');
        $('#modalRefLote').text(refLote);
        const reqAnalisis = $(this).data('req_analisis');
        $('#modalReqAnalisis').text(reqAnalisis);
        const pesoExterno = $(this).data('pesoexterno');
        $('#modalPesoExterno').text(pesoExterno); 
        const fechaSalida = $(this).data('fecha_salida');
        $('#modalFechaSalida').text(fechaSalida);
    });
});
</script>

@endsection
