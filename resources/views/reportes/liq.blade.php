@extends('layouts.app')

@push('styles')
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        /* Aquí van todos tus estilos de tabla y demás */
        html, body {
            font-family: 'Arial';
            background: linear-gradient(to bottom right, #202d3f, #233d60);
            height: 100%;
            margin: 0;
            overflow: auto;
        }

        h1 {
            text-align: center;
            color: #ffffff;
            margin-top: 20px;
        }

        .table-wrapper {
            max-width: 98%;
            margin: 0 auto;
            overflow-x: auto;
            overflow-y: auto;
            max-height: 70vh;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            padding: 10px;
            position: relative;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
        }

        thead th {
            background-color: #e9ecef;
            position: sticky;
            top: 0;
            z-index: 2;
            text-align: center;
            padding: 10px 8px;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            border: 1px solid #dee2e6;
        }

        thead tr:first-child th {
            background-color: #ced4da;
            font-size: 14px;
            font-weight: 700;
            color: #000;
            position: sticky;
            top: 0;
            z-index: 3;
            text-transform: uppercase;
        }

        thead tr:nth-child(2) th {
            top: 38px;
            z-index: 1;
        }

        td {
            padding: 8px 6px;
            font-size: 12px;
            text-align: center;
            border: 1px solid #dee2e6;
            color: #343a40;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #e2f0ff;
            transition: background-color 0.2s ease;
            
        }

        .btn-excel {
            background-color: #28a745;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }

        .btn-excel:hover {
            background-color: #218838;
        }

        .btn-volver {
            background-color: #6c757d;
            color: white;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            margin-left: 10px;
            transition: background-color 0.2s ease;
        }

        .btn-volver:hover {
            background-color: #5a6268;
        }

        #contadorRegistros {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
            color: #ffffff;
        }

        .filtro-input {
            padding: 6px 8px;
            font-size: 13px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            width: 100%;
            box-sizing: border-box;
        }

        .filtro-select {
            background-color: #f8f9fa;
            font-weight: bold;
            border: 2px solid #007bff;
            color: #007bff;
        }

        .btn-volver-discreto {
            position: absolute;
            top: 15px;
            left: 15px;
            opacity: 0.3;
            padding: 6px 10px;
            font-size: 12px;
            background-color: transparent;
            border: none;
            color: #fff;
            z-index: 10;
            transition: opacity 0.3s ease;
        }

        .btn-volver-discreto:hover {
            opacity: 1;
            background-color: #6c757d;
            border-radius: 50%;
        }

        .modal-promedios {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
        }

        .modal-contenido {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            width: 350px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            position: relative;
        }

        .cerrar {
            position: absolute;
            top: 10px; right: 15px;
            font-size: 24px;
            cursor: pointer;
            color: #888;
        }

        .resumen-promedios p {
            font-size: 16px;
            margin: 10px 0;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <h1>REPORTES DE LIQUIDACIONES</h1>
       
        <div class="d-flex justify-content-end px-4">
            @php
            $codigosBlending = $liquidaciones
                ->pluck('ingreso.blendings')
                ->flatten()
                ->pluck('cod')
                ->filter()
                ->unique()
                ->sort()
                ->values();
         @endphp
        </div>

        <p id="contadorRegistros">Total de registros: 0</p>

        
        
       <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; margin-bottom: 15px; gap: 10px; font-size: 12px;">

    <!-- Leyenda de colores -->
    <div style="display: flex; gap: 10px; color: #f8f9fa;">
        <strong style="color: #28a745;">✅ Cierre</strong>
        <strong style="color: #ffc107;">🟡 Provisional asociado a cierre</strong>
        <strong style="color: #ff6666;">🔺 Sin cierre</strong>
    </div></div>

    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 15px;">

        <!-- Botón Columnas -->
        <div style="position: relative;">
            <button onclick="toggleColumnMenu()" class="btn-excel" style="background-color: #007bff; padding: 6px 10px;">
                <i class="fas fa-sliders-h"></i> Columnas
            </button>
        </div>
    
        <!-- Filtro Estado - más pequeño -->
        <select id="filtroRelacion" class="filtro-input filtro-select" onchange="filtrarTabla()" style="width: 210px; font-size: 12px; padding: 5px 6px;">
            <option value="">🔁 Mostrar todo</option>
            <option value="cierresYSinCierre">✅ Cierres y 🔺 Provisionales sin Cierre</option>
            <option value="soloCierres">✅ Solo Cierres</option>
            <option value="cierresYProvisionales">✅ Cierres y sus Provisionales</option>
            <option value="provisionalesConCierre">🟡 Provisionales con Cierre</option>
            <option value="provisionalesSinCierre">🔺 Provisionales sin Cierre</option>
        </select>
    
        <!-- Filtro Fecha - más compacto -->
        <input id="rangoFechas" class="filtro-input" placeholder="📅 Fecha" readonly style="width: 110px; font-size: 12px; padding: 5px 6px;">
    
        <!-- Botón Exportar -->
        <button onclick="exportarExcel()" class="btn-excel" style="padding: 6px 10px;">
            <i class="fas fa-file-excel"></i> Exportar
        </button>
        
        <!-- Botón Ver Promedios -->
        <button onclick="mostrarModalPromedios()" class="btn-excel" style="background-color:#17a2b8; padding: 6px 10px;">
            <i class="fas fa-chart-bar"></i> Ver Promedios
        </button>
        <div id="columnMenu" style="display: none; position: absolute; background: white; border: 1px solid #ccc; padding: 10px 10px 10px 10px; z-index: 10; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.2); min-width: 180px; position: absolute; top: 40px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                <strong>Mostrar/Ocultar:</strong>
                <span onclick="cerrarColumnMenu()" style="cursor:pointer; font-weight: bold; color: #888;">&times;</span>
            </div>
            <label><input type="checkbox" checked onchange="toggleColumnGroup('peso')"> Peso</label><br>
            <label><input type="checkbox" checked onchange="toggleColumnGroup('ensayo')"> Ensayo</label><br>
            <label><input type="checkbox" checked onchange="toggleColumnGroup('cotizacion')"> Cotización</label><br>
            <label><input type="checkbox" checked onchange="toggleColumnGroup('pagables')"> Pagables</label><br>
            <label><input type="checkbox" checked onchange="toggleColumnGroup('deducciones')"> Deducciones</label><br>
            <label><input type="checkbox" checked onchange="toggleColumnGroup('penalidades')"> Penalidades</label><br>
            <label><input type="checkbox" checked onchange="toggleColumnGroup('valores')"> Valores</label><br>
            <label><input type="checkbox" checked onchange="toggleColumnGroup('descuentos')"> Descuentos</label><br>
            <label><input type="checkbox" checked onchange="toggleColumnGroup('valorfinal')"> Valor Final</label>
        </div>

        <select id="filtroBlendingCod" class="filtro-input filtro-select" onchange="filtrarTabla()" style="width: 200px; font-size: 12px;">
            <option value="">🔁 Todos los Blending</option>
            @foreach ($codigosBlending as $cod)
                <option value="{{ strtolower($cod) }}">{{ $cod }}</option>
            @endforeach
        </select>
        <!-- Buscador global -->
        <input type="text" id="buscador" onkeyup="filtrarTabla()" placeholder="Buscar global..." class="filtro-input" style="min-width: 200px; flex: 1;">
    </div>
    

    <div class="table-wrapper">
       
    <table>
        <thead>
            <tr id="grupoEncabezados">
                <th colspan="11" style="text-align: center;" class="grupo-general">DATOS GENERALES</th>
                <th colspan="5" style="text-align: center;" class="grupo-peso">PESO</th>
                <th colspan="3" style="text-align: center;" class="grupo-ensayo">ENSAYO</th>
                <th colspan="3" style="text-align: center;" class="grupo-cotizacion">COTIZACION</th>
                <th colspan="19" style="text-align: center;" class="grupo-pagables">PAGABLES</th>
                <th colspan="9" style="text-align: center;" class="grupo-deducciones">DEDUCCIONES</th>
                <th colspan="7" style="text-align: center;" class="grupo-penalidades">PENALIDADES</th>
                <th colspan="9" style="text-align: center;" class="grupo-valores">VALORES</th>
                <th colspan="4" style="text-align: center;" class="grupo-descuentos">DESCUENTOS ADICIONALES</th>
                <th colspan="1" style="text-align: center;" class="grupo-valorfinal">VALOR FINAL</th>
                <th colspan="3" style="text-align: center;" class="grupo-extras">EXTRAS</th>
                

                
            </tr>
            <tr>
                <th><input type="checkbox" onclick="toggleSelectAll(this)"></th>
                <!--datos generales-->
                <th>FECHA</th>
                <th>ID</th>
                <th>CLIENTE</th>
                <th>LOTE</th>
                <th style="min-width: 110px;">
                    <input type="text" id="filtroNroSalida" class="filtro-input" placeholder="NRO TICKET" onkeyup="filtrarTabla()" style="width: 70%; font-size: 11px; padding: 4px;">
                </th>
                <th>PRODUCTO</th>
                <th>MUESTRA</th>                                     
                <th>CREADOR</th>
                <th>CIERRE</th>
                <th>ESTADO</th>
                <!--peso-->
                <th class="col-peso">TMH</th>
                <th class="col-peso">HUMEDAD</th>
                <th class="col-peso">TMS</th>
                <th class="col-peso">MERMA</th>
                <th class="col-peso">TMNS</th>
                <!--ensayo--> 
                <th class="col-ensayo">CU</th>
                <th class="col-ensayo">AG</th>
                <th class="col-ensayo">AU</th>
                <!--cotizacion--> 
                <th class="col-cotizacion">COT. CU</th>
                <th class="col-cotizacion">COT. AG</th>
                <th class="col-cotizacion">COT. AU</th>
                <!--pagables--> 
                <th class="col-pagables">LEY. CU</th>
                <th class="col-pagables">PAG. CU</th>
                <th class="col-pagables">DED. CU</th>
                <th class="col-pagables">FORM. CU</th>
                <th class="col-pagables">PRECIO. CU</th>
                <th class="col-pagables">US$&TM CU</th>
                <th class="col-pagables">LEY. AG</th>
                <th class="col-pagables">PAG. AG</th>
                <th class="col-pagables">DED. AG</th>
                <th class="col-pagables">FORM. AG</th>
                <th class="col-pagables">PRECIO. AG</th>
                <th class="col-pagables">US$&TM AG</th>
                <th class="col-pagables">LEY. AU</th>
                <th class="col-pagables">PAG. AU</th>
                <th class="col-pagables">DED. AU</th>
                <th class="col-pagables">FORM. AU</th>
                <th class="col-pagables">PRECIO. AU</th>
                <th class="col-pagables">US$&TM AU</th>
                <th class="col-pagables">TOTAL PAGABLE / TM</th>

                <!--deducciones--> 
                <th class="col-deducciones">REF. CU</th>
                <th class="col-deducciones">REF. AG</th>
                <th class="col-deducciones">REF. AU</th>
                <th class="col-deducciones">MAQUILA</th>
                <th class="col-deducciones">ANALISIS</th>
                <th class="col-deducciones">ESTIBADORES</th>
                <th class="col-deducciones">MOLIENDA</th>
                <th class="col-deducciones">TRANSPORTE</th>
                <th class="col-deducciones">TOTAL DEDUCCION</th>
                <!--penalidades--> 
                <th class="col-penalidades">As</th>
                <th class="col-penalidades">Sb</th>
                <th class="col-penalidades">Bi</th>
                <th class="col-penalidades">Pb+Zn</th>
                <th class="col-penalidades">Hg</th>
                <th class="col-penalidades">H2O</th>
                <th class="col-penalidades">TOTAL PENALIDADES</th>
                <!--VALORES--> 
                <th class="col-valores">Total US$/TM</th>
                <th class="col-valores">Valor Lote US$</th>
                <th class="col-valores">IGV</th>
                <th class="col-valores">Total Liquidacion %</th>
                <th class="col-valores">ADELANTO</th>
                <th class="col-valores">BASE IMPONIBLE</th>
                <th class="col-valores">DETRACCION</th>
                <th class="col-valores">TOTAL LIQ.</th>
                 <!--DESCUENTOS ADICIONALES--> 
                 <th class="col-descuentos">PROCESO DE PLANTA</th>
                 <th class="col-descuentos">ADELANTOS EXTRAS</th>
                 <th class="col-descuentos">PRESTAMOS</th>
                 <th class="col-descuentos">OTROS DESCUENTOS</th>

                 <th class="col-valorfinal">TOTAL</th>
                <!--EXTRAS --> 
                 <th class="col-extras">VER</th>
                 <th class="col-extras" style="min-width: 110px;">
                    <input type="text" id="filtroCodBlending" class="filtro-input" placeholder="COD BLENDING" onkeyup="filtrarTabla()" style="width: 100%; font-size: 11px; padding: 4px;">
                </th>
                 <th class="col-extras">ESTADO</th>

        </thead>
        <tbody>
           
            @foreach ($liquidaciones as $liquidacion)

                <tr class="estado-row" data-estado="{{ $liquidacion->estado ?? 'PROVISIONAL' }}">
                    <td>
                        <input type="checkbox" class="fila-selector" onchange="calcularPromedios(); reordenarFilasSeleccionadas();">
                      </td>
                    <!--PESO-->
                    <td>{{ $liquidacion->created_at }}</td>
                    <td>{{ $liquidacion->id }}</td>
                    <td>{{ $liquidacion->cliente->datos_cliente }}</td>
                    <td>{{ $liquidacion->lote }}</td>
                    <td>{{ $liquidacion->NroSalida }}</td>
                    
                    <td>{{ $liquidacion->producto }}</td>
                    <td>{{ $liquidacion->muestra->codigo ?? '-' }}</td>
                    <td>{{ $liquidacion->creator->name ?? 'N/A' }}</td>
                    <td>{{ $liquidacion->lastEditor->name ?? 'N/A' }}</td>                                               
                    <td>{{ $liquidacion->estado ?? 'PROVISIONAL' }}</td>

                    <td class="col-peso">{{ $liquidacion->peso ?? '-' }}</td>
                    <td class="col-peso">{{ $liquidacion->muestra->humedad ?? '-' }}</td>
                    <td class="col-peso">{{ $liquidacion->tms ?? '-' }}</td>
                    <td class="col-peso">{{ $liquidacion->merma2 ?? '-' }}</td>
                    <td class="col-peso">{{ $liquidacion->tmns ?? '-' }}</td>

                    <td class="col-ensayo">{{ $liquidacion->muestra->cu ?? '-' }}</td>
                    <td class="col-ensayo">{{ $liquidacion->muestra->ag ?? '-' }}</td>
                    <td class="col-ensayo">{{ $liquidacion->muestra->au ?? '-' }}</td>

                    <td class="col-cotizacion">{{ $liquidacion->cotizacion_cu ?? '-' }}</td>
                    <td class="col-cotizacion">{{ $liquidacion->cotizacion_ag ?? '-' }}</td>
                    <td class="col-cotizacion">{{ $liquidacion->cotizacion_au ?? '-' }}</td>

                    <td class="col-pagables">{{ $liquidacion->ley_cu ?? '-' }}</td>
                    <td class="col-pagables">{{ $liquidacion->pagable_cu2 ?? '-' }}</td>
                    <td class="col-pagables">{{ $liquidacion->deduccion_cu2 ?? '-' }}</td>
                    <td class="col-pagables">{{ $liquidacion->formula_cu ?? '-' }}</td>
                    <td class="col-pagables">{{ $liquidacion->precio_cu ?? '-' }}</td>
                    <td class="col-pagables">{{ $liquidacion->val_cu ?? '-' }}</td>

                    <td class="col-pagables">{{ $liquidacion->ley_ag ?? '-' }}</td>
                    <td class="col-pagables">{{ $liquidacion->pagable_ag2 ?? '-' }}</td>
                    <td class="col-pagables">{{ $liquidacion->deduccion_ag2 ?? '-'  }}</td>
                    <td class="col-pagables">{{ $liquidacion->formula_ag ?? '-' }}</td>
                    <td class="col-pagables">{{ $liquidacion->precio_ag ?? '-' }}</td>
                    <td class="col-pagables">{{ $liquidacion->val_ag ?? '-' }}</td>

                    <td class="col-pagables">{{ $liquidacion->ley_au ?? '-' }}</td>
                    <td class="col-pagables">{{ $liquidacion->pagable_au2 ?? '-' }}</td>
                    <td class="col-pagables">{{ $liquidacion->deduccion_au2 ?? '-' }}</td>
                    <td class="col-pagables">{{ $liquidacion->formula_au ?? '-' }}</td>
                    <td class="col-pagables">{{ $liquidacion->precio_au ?? '-' }}</td>
                    <td class="col-pagables">{{ $liquidacion->val_au ?? '-' }}</td>
                    <td class="col-pagables">{{ $liquidacion->total_valores }}</td>

                    <td class="col-deducciones">{{ $liquidacion->fina_cu ?? '-' }}</td>
                    <td class="col-deducciones">{{ $liquidacion->fina_ag ?? '-' }}</td>
                    <td class="col-deducciones">{{ $liquidacion->fina_au ?? '-' }}</td>
                    <td class="col-deducciones">{{ $liquidacion->maquila2 }}</td>
                    <td class="col-deducciones">{{ $liquidacion->division }}</td>
                    <td class="col-deducciones">{{ $liquidacion->resultadoestibadores }}</td>
                    <td class="col-deducciones">{{ $liquidacion->resultadomolienda }}</td>
                    <td class="col-deducciones">{{ $liquidacion->transporte }}</td>
                    <td class="col-deducciones">{{ $liquidacion->total_deducciones }}</td>

                    
                    <td class="col-penalidades">{{ $liquidacion->total_as ?? '-' }}</td>
                    <td class="col-penalidades">{{ $liquidacion->total_sb ?? '-' }}</td>
                    <td class="col-penalidades">{{ $liquidacion->total_bi ?? '-' }}</td>
                    <td class="col-penalidades">{{ $liquidacion->total_pb ?? '-' }}</td>
                    <td class="col-penalidades">{{ $liquidacion->total_hg ?? '-' }}</td>
                    <td class="col-penalidades">{{ $liquidacion->total_s ?? '-' }}</td>
                    <td class="col-penalidades">{{ $liquidacion->total_penalidades }}</td>

                    <td class="col-valores">{{ $liquidacion->total_us }}</td>
                    <td class="col-valores">{{ $liquidacion->valorporlote }}</td>
                    <td class="col-valores">{{ $liquidacion->valor_igv }}</td>
                    <td class="col-valores">{{ $liquidacion->total_porcentajeliqui }}</td>
                    <td class="col-valores">{{ $liquidacion->adelantos }}</td>
                    <td class="col-valores">{{ $liquidacion->saldo }}</td>
                    <td class="col-valores">{{ $liquidacion->detraccion }}</td>
                    <td class="col-valores">{{ $liquidacion->total_liquidacion }}</td>

                    <td class="col-descuentos">{{ $liquidacion->procesoplanta }}</td>
                    <td class="col-descuentos">{{ $liquidacion->adelantosextras }}</td>
                    <td class="col-descuentos">{{ $liquidacion->prestamos }}</td>
                    <td class="col-descuentos">{{ $liquidacion->otrosdescuentos }}</td>

                    <td class="col-valorfinal" style="color: {{ $liquidacion->total < 0 ? 'red' : 'inherit' }}">
                        {{ $liquidacion->total }}
                    </td>

                    <td>
                        <a href="{{ route('liquidaciones.print', ['id' => $liquidacion->id]) }}" target="_blank" class="btn-excel" style="background-color: #8c8aa4; padding: 6px 10px; font-size: 12px;">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                    </td>

                <td>{{ $liquidacion->ingreso?->blendings?->first()?->cod ?? '-' }}</td>
                <td>{{ $liquidacion->ingreso->fase ?? '-' }}</td>                
             
                </tr>
            @endforeach
        </tbody>
        <div id="modalPromedios" class="modal-promedios" style="display: none; position: fixed; z-index: 999; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6);">
            <div class="modal-contenido" style="background: white; padding: 20px; margin: 10% auto; width: 80%; max-width: 600px; border-radius: 10px; position: relative;">
                <span class="cerrar" onclick="cerrarModalPromedios()" style="position: absolute; top: 10px; right: 15px; font-size: 24px; cursor: pointer;">&times;</span>
                <h2 style="margin-bottom: 20px;">Resumen de Selección</h2>
                <div class="resumen-promedios">
                    <p><strong>Cantidad seleccionada:</strong> <span id="modalCantidad">-</span></p>
                    <hr>
                    <p><strong>Total TMH (Peso):</strong> <span id="modalPeso">-</span></p>
                    <p><strong>Humedad:</strong> <span id="modalHumedad">-</span></p>
                    <p><strong>Total TMS:</strong> <span id="modalTms">-</span></p>
                    <hr>
                    <p><strong>Promedio ponderado CU (%):</strong> <span id="modalCu">-</span></p>
                    <p><strong>Promedio ponderado AG (g/t):</strong> <span id="modalAg">-</span></p>
                    <p><strong>Promedio ponderado AU (g/t):</strong> <span id="modalAu">-</span></p>
                    <hr>
                    <p><strong>Total Valor por Lote (US$):</strong> <span id="modalValorLote">-</span></p>
                    <p><strong>Total Valor Liquidación (US$):</strong> <span id="modalTotalLiq">-</span></p>
                    <button onclick="cerrarModalPromedios()" class="btn-excel" style="margin-top: 20px;">Cerrar</button>
                </div>
            </div>
        </div>
    </table>

</div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>


<script>
    function filtrarTabla() {
        const inputGeneral = document.getElementById("buscador").value.toLowerCase();
        const filtroRelacion = document.getElementById("filtroRelacion").value;

        const filtroNroSalida = document.getElementById("filtroNroSalida")?.value.toLowerCase() || "";
        const filtroBlendingCod = document.getElementById("filtroBlendingCod")?.value.toLowerCase() || "";
        const filtroCodBlending = document.getElementById("filtroCodBlending")?.value.toLowerCase() || "";

        const rangoFechas = document.getElementById("rangoFechas").value.split(" a ");
        const fechaInicio = rangoFechas[0] || null;
        const fechaFin = rangoFechas[1] || null;

        const filas = document.querySelector("tbody").getElementsByTagName("tr");
        let contador = 0;
        const salidaEstados = {};

        // Fase 1: Mapeo de estados por NroSalida
        for (let i = 0; i < filas.length; i++) {
            const fila = filas[i];
            const celdas = fila.getElementsByTagName("td");
            const nroSalida = celdas[5]?.textContent.trim().toLowerCase() || '';
            const estado = fila.getAttribute("data-estado")?.trim().toLowerCase() || '';

            if (!salidaEstados[nroSalida]) {
                salidaEstados[nroSalida] = { provisional: false, cierre: false };
            }
            if (estado === "provisional") salidaEstados[nroSalida].provisional = true;
            if (estado === "cierre") salidaEstados[nroSalida].cierre = true;
        }

        // Fase 2: Filtrar filas
        for (let i = 0; i < filas.length; i++) {
            const fila = filas[i];
            const celdas = fila.getElementsByTagName("td");

            const estadoAttr = fila.getAttribute("data-estado");
            const estado = estadoAttr ? estadoAttr.toLowerCase() : '';
            const nroSalida = celdas[5]?.textContent.trim().toLowerCase() || '';
            const codBlending = celdas[71]?.textContent.trim().toLowerCase() || ''; // Asegúrate que sea el índice correcto
            const fechaTexto = celdas[1]?.textContent.trim().slice(0, 10);
            const fechaRegistro = new Date(fechaTexto + 'T00:00:00');

            // Filtro de fecha
            let coincideFecha = true;
            if (fechaInicio && !fechaFin) {
                const fechaFiltro = new Date(fechaInicio + 'T00:00:00');
                coincideFecha = fechaRegistro.toDateString() === fechaFiltro.toDateString();
            } else if (fechaInicio && fechaFin) {
                const desde = new Date(fechaInicio + 'T00:00:00');
                const hasta = new Date(fechaFin + 'T23:59:59');
                coincideFecha = fechaRegistro >= desde && fechaRegistro <= hasta;
            }

            // Filtro global
            let coincideGeneral = false;
            for (let j = 0; j < celdas.length; j++) {
                if (celdas[j].textContent.toLowerCase().includes(inputGeneral)) {
                    coincideGeneral = true;
                    break;
                }
            }

            // Filtros específicos
            const coincideNroSalida = nroSalida.includes(filtroNroSalida);
            const coincideCodBlending = codBlending.includes(filtroCodBlending);

            const tieneProvisional = salidaEstados[nroSalida]?.provisional;
            const tieneCierre = salidaEstados[nroSalida]?.cierre;

            let mostrar = true;

            // Aplicar el filtro por tipo de relación si está activo
            switch (filtroRelacion) {
    case "soloCierres":
        mostrar = estado === "cierre";
        break;
    case "cierresYProvisionales":
        mostrar = estado === "cierre" || (estado === "provisional" && tieneCierre);
        break;
    case "provisionalesConCierre":
        mostrar = estado === "provisional" && tieneCierre;
        break;
    case "provisionalesSinCierre":
        mostrar = estado === "provisional" && !tieneCierre;
        break;
    case "cierresYSinCierre":
        mostrar = estado === "cierre" || (estado === "provisional" && !tieneCierre);
        break;
    default:
        mostrar = true;
}

            // Filtro adicional si se aplica CodBlending
            if (filtroCodBlending !== "") {
    if (filtroRelacion === "provisionalesSinCierre") {
        mostrar = estado === "provisional" && !tieneCierre && codBlending.includes(filtroCodBlending);
    } else if (filtroRelacion === "provisionalesConCierre") {
        mostrar = estado === "provisional" && tieneCierre && codBlending.includes(filtroCodBlending);
    } else if (filtroRelacion === "soloCierres") {
        mostrar = estado === "cierre" && codBlending.includes(filtroCodBlending);
    } else if (filtroRelacion === "cierresYProvisionales") {
        mostrar = (estado === "cierre" || (estado === "provisional" && tieneCierre)) && codBlending.includes(filtroCodBlending);
    } else {
        // Cuando está en "Mostrar todo", no restringimos por estado
        mostrar = codBlending.includes(filtroCodBlending);
    }
}
                // Validar si coincide blending único (nuevo filtro select)
                if (filtroBlendingCod !== "" && codBlending !== filtroBlendingCod) {
                    mostrar = false;
                }

            // Mostrar si todos los filtros se cumplen
            if (
    mostrar &&
    coincideGeneral &&
    coincideNroSalida &&
    coincideCodBlending && // ← este es del input
    coincideFecha
) {
    fila.style.display = "";
    contador++;

    // Colorear según estado y relación
    if (tieneProvisional && tieneCierre) {
        fila.style.backgroundColor = estado === "provisional" ? "#fff3cd" : "#d4edda";
    } else if (tieneProvisional && !tieneCierre) {
        fila.style.backgroundColor = "#ffcccb";
    } else {
        fila.style.backgroundColor = "";
    }
} else {
    fila.style.display = "none";
}
        }

        document.getElementById("contadorRegistros").textContent = `Total de registros: ${contador}`;
    }

  
    document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#rangoFechas", {
        mode: "range",
        dateFormat: "Y-m-d",
        locale: "es",
        onChange: function () {
            filtrarTabla();
        }
    });

    document.getElementById("filtroRelacion").value = ""; // ← esta línea

    filtrarTabla(); // ← forzar la carga inicial completa
});
</script>

<script>
    function toggleColumnGroup(group) {
        const columnas = document.querySelectorAll(`.col-${group}`);
        const encabezadoGrupo = document.querySelector(`.grupo-${group}`);

        columnas.forEach(col => {
            col.style.display = col.style.display === "none" ? "" : "none";
        });

        if (encabezadoGrupo) {
            encabezadoGrupo.style.display = encabezadoGrupo.style.display === "none" ? "" : "none";
        }
    }

    function toggleColumnMenu() {
        const menu = document.getElementById("columnMenu");
        menu.style.display = menu.style.display === "none" ? "block" : "none";
    }
    function reordenarFilasSeleccionadas() {
    const tbody = document.querySelector("tbody");
    const filas = Array.from(tbody.querySelectorAll("tr"));

    const seleccionadas = filas.filter(fila =>
        fila.querySelector(".fila-selector")?.checked && fila.style.display !== "none"
    );
    const noSeleccionadas = filas.filter(fila =>
        !fila.querySelector(".fila-selector")?.checked || fila.style.display === "none"
    );

    // Limpiar tbody
    tbody.innerHTML = "";

    // Agregar primero las seleccionadas
    seleccionadas.forEach(fila => tbody.appendChild(fila));

    // Luego las no seleccionadas
    noSeleccionadas.forEach(fila => tbody.appendChild(fila));
}
</script>
<script>
    function mostrarModalPromedios() {
    calcularPromedios(true); // Con true, mostramos modal
    document.getElementById('modalPromedios').style.display = 'flex';
}

function cerrarModalPromedios() {
    document.getElementById('modalPromedios').style.display = 'none';
}

function calcularPromedios(mostrarEnModal = false) {
    const rows = document.querySelectorAll("tbody tr");
    let totalPeso = 0, totalTms = 0;
    let sumaCu = 0, sumaAg = 0, sumaAu = 0;
    let sumaAs = 0, sumaSb = 0, sumaPb = 0, sumaZn = 0, sumaBi = 0, sumaHg = 0;
    let totalValorLote = 0, totalLiquidacion = 0;
    let count = 0;

    rows.forEach(row => {
    const checkbox = row.querySelector(".fila-selector");
    if (checkbox && checkbox.checked && row.style.display !== 'none') {
        const cells = row.querySelectorAll("td");
        const peso = parseFloat(cells[11]?.textContent) || 0;
        const humedad = parseFloat(cells[12]?.textContent) || 0;
        const tms = parseFloat(cells[13]?.textContent) || 0;

        const cu = parseFloat(cells[16]?.textContent) || 0;
        const ag = parseFloat(cells[17]?.textContent) || 0;
        const au = parseFloat(cells[18]?.textContent) || 0;

        const valorLote = parseFloat(cells[58]?.textContent) || 0;
        const valorTotal = parseFloat(cells[69]?.textContent) || 0;

        totalPeso += peso;
        totalTms += tms;

        sumaCu += tms * cu;
        sumaAg += tms * ag;
        sumaAu += tms * au;

        totalValorLote += valorLote;
        totalLiquidacion += valorTotal;

        count++;
    }
});

const promedio = (suma) => totalTms ? (suma / totalTms).toFixed(3) : '-';

if (mostrarEnModal) {
    document.getElementById("modalCantidad").textContent = count;
    document.getElementById("modalPeso").textContent = totalPeso.toFixed(3);
    document.getElementById("modalTms").textContent = totalTms.toFixed(3);

    document.getElementById("modalCu").textContent = promedio(sumaCu);
    document.getElementById("modalAg").textContent = promedio(sumaAg);
    document.getElementById("modalAu").textContent = promedio(sumaAu);
    let humedadCalculada = totalPeso > 0 ? ((totalPeso - totalTms) / totalPeso * 100).toFixed(3) : '-';
    document.getElementById("modalHumedad").textContent = humedadCalculada;

    document.getElementById("modalValorLote").textContent = totalValorLote.toFixed(3);
    document.getElementById("modalTotalLiq").textContent = totalLiquidacion.toFixed(3);
}}
    </script>
    <script>
        function toggleSelectAll(masterCheckbox) {
            const allCheckboxes = document.querySelectorAll('.fila-selector');
            allCheckboxes.forEach(cb => {
                if (cb.closest("tr").style.display !== "none") {
                    cb.checked = masterCheckbox.checked;
                }
            });
        
            calcularPromedios(); 
            reordenarFilasSeleccionadas(); 
        }
        </script>
<script>
    function cerrarColumnMenu() {
        document.getElementById("columnMenu").style.display = "none";
    }

    // Cerrar al hacer clic fuera del menú
    document.addEventListener('click', function (event) {
        const menu = document.getElementById("columnMenu");
        const button = document.querySelector("button[onclick='toggleColumnMenu()']");

        if (!menu.contains(event.target) && !button.contains(event.target)) {
            menu.style.display = 'none';
        }
    });
</script>
<script>
function exportarExcel() {
  const relacion = document.getElementById('filtroRelacion').value;
  const codBlending = document.getElementById('filtroCodBlending').value;
  const busqueda = document.getElementById('buscador').value;
  const nroSalida = document.getElementById('filtroNroSalida')?.value || '';
  const blendingSelect = document.getElementById('filtroBlendingCod')?.value || '';
  const rangoFechas = document.getElementById('rangoFechas').value;
  const mes = document.getElementById('mes')?.value || ''; // ← opcional

  const params = new URLSearchParams({
    relacion,
    codBlending,
    busqueda,
    nroSalida,
    blendingSelect,
    rangoFechas: mes || rangoFechas // si hay mes, lo priorizamos
  });

  window.location.href = "{{ route('reportes.exportar.excel') }}?" + params.toString();
}
</script>

<script>
    function exportarExcel() {
    const relacion = document.getElementById('filtroRelacion').value;
    const codBlending = document.getElementById('filtroCodBlending').value;
    const busqueda = document.getElementById('buscador').value;
    const nroSalida = document.getElementById('filtroNroSalida')?.value || '';
    const blendingSelect = document.getElementById('filtroBlendingCod')?.value || '';
    const rangoFechas = document.getElementById('rangoFechas').value;

    const params = new URLSearchParams({
        relacion,
        codBlending,
        busqueda,
        nroSalida,
        blendingSelect,
        rangoFechas
    });

    window.location.href = "{{ route('reportes.exportar.excel') }}?" + params.toString();
}
    </script>
@endpush
