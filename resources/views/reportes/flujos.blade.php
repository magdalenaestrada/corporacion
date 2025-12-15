@extends('layouts.app')

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Colores para las secciones */
        .grupo-ingresos    { background-color: #d1ecf1 !important; }
        .grupo-blending    { background-color: #fff3cd !important; }
        .grupo-despachos   { background-color: #fde2e2 !important; }
        .grupo-liquidaciones { background-color: #d4edda !important; }
        .custom-modal-width {
    max-width: 98% !important;
}
        td.col-ingresos         { background-color: #d1ecf1; }
        td.col-blending         { background-color: #fff8d1; }
        td.col-despachos        { background-color: #ffe2e2; }
        td.col-liquidaciones    { background-color: #e7f6e7; }
        body { background: #1a1a2e; color: white; font-family: Arial; }
        h1 { text-align: center; margin: 20px 0; }
        .table-wrapper { overflow-x: auto; margin: 0 auto; width: 98%; max-height: 75vh; background: white; color: black; border-radius: 10px; padding: 10px; }
        th, td { padding: 6px; text-align: center; border: 1px solid black; white-space: nowrap; } 
        table { width: 100%; border-collapse: collapse; font-size: 12px; border: 2px solid black; }

        thead th { background-color: #e9ecef; position: sticky; top: 0; }
        tr:hover { background-color: #f1f1f1; }
        .btn-export { background: #28a745; color: white; padding: 8px 14px; border-radius: 6px; text-decoration: none; font-weight: bold; margin: 10px 5px; }
        .filtro-input { padding: 6px 10px; font-size: 13px; border-radius: 6px; border: 1px solid #ced4da; margin-bottom: 10px; width: 250px; }
        .fila-seleccionada {
            background-color: #939da7 !important;
            color: #007bff !important;
        }
        /* Estilo para los botones de lista desplegable */
        .toggle-section {
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            padding: 5px;
            border-radius: 5px;
            margin: 5px;
            display: inline-block;
            width: 22%;
            text-align: center;
        }

        .btn-ingresos { background-color: #007bff; color: white; }
        .btn-blending { background-color: #ffcc00; color: white; }
        .btn-despachos { background-color: #ff5733; color: white; }
        .btn-liquidaciones { background-color: #28a745; color: white; }
        .checkbox-list {
    display: none;
    padding: 10px;
    flex-wrap: wrap;
    gap: 8px;
    max-height: 320px; /* puedes ajustar según necesidad */
    overflow-y: auto;
}

.checkbox-list.active {
    display: flex;
}

.checkbox-list label {
    width: calc(100% / 12 - 8px); /* 12 columnas */
    white-space: nowrap;
}

        /* Estilo para la leyenda */
        .section-legend {
            margin: 10px 0;
            font-size: 18px;
            font-weight: bold;
        }

        /* Alineación horizontal */
        .button-container {
            display: flex;
            justify-content: space-between;
        }

    </style>
@endpush

@section('content')
<div class="container-fluid">
    <h1>REPORTE DETALLADO DEL FLUJO</h1>
    
    <div style="margin-bottom: 15px;">
        <div style="margin-bottom: 15px;">
            <button type="button" class="btn btn-warning btn-export" data-bs-toggle="modal" data-bs-target="#modalBlendings">
                Abrir Blendings Sin Sobrante
            </button>
        </div>
        <label style="font-weight: bold; color: white; margin-right: 10px;">Mostrar:</label>
        <select class="filtro-input" onchange="filtrarTipoIngreso(this.value)">
            <option value="todos">Todos</option>
            <option value="asociados">Ingresos asociados a liquidaciones</option>
            <option value="libres">Ingresos libres (sin liquidación)</option>
        </select>
    </div>
    
    <!-- Lista de checkboxes para mostrar/ocultar columnas -->
    <div class="button-container">
        <button class="toggle-section btn-ingresos" onclick="toggleDropdown('ingresos')">INGRESOS</button>
        <button class="toggle-section btn-blending" onclick="toggleDropdown('blending')">BLENDING</button>
        <button class="toggle-section btn-despachos" onclick="toggleDropdown('despachos')">DESPACHOS</button>
        <button class="toggle-section btn-liquidaciones" onclick="toggleDropdown('liquidaciones')">LIQUIDACIONES</button>
    </div>

<!-- Sección de INGRESOS -->
<div>
    <div id="ingresos" class="checkbox-list">
        <label><input type="checkbox" id="col1" checked onclick="toggleColumn(1, 'ingresos')"> NroSalida</label><br>
        <label><input type="checkbox" id="col2" checked onclick="toggleColumn(2, 'ingresos')"> Peso Total</label><br>
        <label><input type="checkbox" id="col3" checked onclick="toggleColumn(3, 'ingresos')"> Fecha Ingreso</label><br>
        <label><input type="checkbox" id="col4" checked onclick="toggleColumn(4, 'ingresos')"> DNI / RUC</label><br>
        <label><input type="checkbox" id="col5" checked onclick="toggleColumn(5, 'ingresos')"> NOMBRE / RAZON SOCIAL</label><br>
        <label><input type="checkbox" id="col6" checked onclick="toggleColumn(6, 'ingresos')"> Material</label><br>
        <label><input type="checkbox" id="col7" checked onclick="toggleColumn(7, 'ingresos')"> Procedencia</label><br>
        <label><input type="checkbox" id="col8"  onclick="toggleColumn(8, 'ingresos')"> Placa</label><br>
        <label><input type="checkbox" id="col9"  onclick="toggleColumn(9, 'ingresos')"> Guia Transporte</label><br>
        <label><input type="checkbox" id="col10"  onclick="toggleColumn(10, 'ingresos')"> Guia Remision</label><br>
        <label><input type="checkbox" id="col11"  onclick="toggleColumn(11, 'ingresos')"> Muestreo</label><br>
        <label><input type="checkbox" id="col12"  onclick="toggleColumn(12, 'ingresos')"> Preparacion</label><br>
        <label><input type="checkbox" id="col13"  onclick="toggleColumn(13, 'ingresos')"> Analisis Nasca Lab</label><br>
        <label><input type="checkbox" id="col14"  onclick="toggleColumn(14, 'ingresos')"> Analisis Lab Peru</label><br>
        <label><input type="checkbox" id="col15" checked onclick="toggleColumn(15, 'ingresos')"> Lote</label><br>
    </div>
</div>

<!-- Sección de BLENDING -->
<div>
    <div id="blending" class="checkbox-list">
        <label><input type="checkbox" id="col16" checked onclick="toggleColumn(16, 'blending')"> Lista</label><br>
        <label><input type="checkbox" id="col17" checked onclick="toggleColumn(17, 'blending')"> Cod Blending</label><br>
        <label><input type="checkbox" id="col18" checked onclick="toggleColumn(18, 'blending')"> Activo o Inactivo</label><br>
        <label><input type="checkbox" id="col19" checked onclick="toggleColumn(19, 'blending')"> Peso Blending</label><br>
    </div>
</div>

<!-- Sección de DESPACHOS -->
<div>
    <div id="despachos" class="checkbox-list">
        <label><input type="checkbox" id="col20" checked onclick="toggleColumn(20, 'despachos')"> ID Despacho</label><br>
        <label><input type="checkbox" id="col21" checked onclick="toggleColumn(21, 'despachos')"> TMH Despacho</label><br>
        <label><input type="checkbox" id="col22" checked onclick="toggleColumn(22, 'despachos')"> Mas/Menos</label><br>
        <label><input type="checkbox" id="col23" checked onclick="toggleColumn(23, 'despachos')"> Fecha Despacho</label><br>
        <label><input type="checkbox" id="col24" checked onclick="toggleColumn(24, 'despachos')"> Nro Salida Retiro</label><br>
        <label><input type="checkbox" id="col25" onclick="toggleColumn(25, 'despachos')"> Precinto</label><br>
        <label><input type="checkbox" id="col26" checked onclick="toggleColumn(26, 'despachos')"> Guia</label><br>
        <label><input type="checkbox" id="col27" checked onclick="toggleColumn(27, 'despachos')"> Bruto</label><br>
        <label><input type="checkbox" id="col28" checked onclick="toggleColumn(28, 'despachos')"> Tara</label><br>
        <label><input type="checkbox" id="col29" checked onclick="toggleColumn(29, 'despachos')"> Neto</label><br>
        <label><input type="checkbox" id="col30"  onclick="toggleColumn(30, 'despachos')"> Tracto</label><br>
        <label><input type="checkbox" id="col31"  onclick="toggleColumn(31, 'despachos')"> Carreta</label><br>
        <label><input type="checkbox" id="col32"  onclick="toggleColumn(32, 'despachos')"> Guia Transporte</label><br>
        <label><input type="checkbox" id="col33" checked onclick="toggleColumn(33, 'despachos')"> RUC Despacho</label><br>
        <label><input type="checkbox" id="col34" checked onclick="toggleColumn(34, 'despachos')"> Razon Social</label><br>
        <label><input type="checkbox" id="col35" checked onclick="toggleColumn(35, 'despachos')"> Licencia</label><br>
        <label><input type="checkbox" id="col36" checked onclick="toggleColumn(36, 'despachos')"> Conductor</label><br>
    </div>
</div>

<!-- Sección de LIQUIDACIONES -->
<div>
    <div id="liquidaciones" class="checkbox-list">
        <label><input type="checkbox" id="col37" onclick="toggleColumn(37, 'liquidaciones')" checked> ID</label><br>
        <label><input type="checkbox" id="col38" onclick="toggleColumn(38, 'liquidaciones')" checked> Fecha Actualización</label><br>
        <label><input type="checkbox" id="col39" onclick="toggleColumn(39, 'liquidaciones')" checked> Ruc Cliente</label><br>
        <label><input type="checkbox" id="col40" onclick="toggleColumn(40, 'liquidaciones')" checked> Cliente</label><br>
        <label><input type="checkbox" id="col41" onclick="toggleColumn(41, 'liquidaciones')" checked> Producto</label><br>
        <label><input type="checkbox" id="col42" onclick="toggleColumn(42, 'liquidaciones')" checked> Comentario</label><br>
        <label><input type="checkbox" id="col43" onclick="toggleColumn(43, 'liquidaciones')" checked> Peso</label><br>
        <label><input type="checkbox" id="col44" onclick="toggleColumn(44, 'liquidaciones')" > Humedad</label><br>
        <label><input type="checkbox" id="col45" onclick="toggleColumn(45, 'liquidaciones')" > TMS</label><br>
        <label><input type="checkbox" id="col46" onclick="toggleColumn(46, 'liquidaciones')" > Merma</label><br>
        <label><input type="checkbox" id="col47" onclick="toggleColumn(47, 'liquidaciones')" checked> TMNS</label><br>
        <label><input type="checkbox" id="col48" onclick="toggleColumn(48, 'liquidaciones')" checked> Cotización Cu</label><br>
        <label><input type="checkbox" id="col49" onclick="toggleColumn(49, 'liquidaciones')" checked> Cotización Ag</label><br>
        <label><input type="checkbox" id="col50" onclick="toggleColumn(50, 'liquidaciones')" checked> Cotización Au</label><br>
        <label><input type="checkbox" id="col51" onclick="toggleColumn(51, 'liquidaciones')" checked> Ley Cu</label><br>
        <label><input type="checkbox" id="col52" onclick="toggleColumn(52, 'liquidaciones')" > Pagable Cu</label><br>
        <label><input type="checkbox" id="col53" onclick="toggleColumn(53, 'liquidaciones')" checked> Ley Ag</label><br>
        <label><input type="checkbox" id="col54" onclick="toggleColumn(54, 'liquidaciones')" > Pagable Ag</label><br>
        <label><input type="checkbox" id="col55" onclick="toggleColumn(55, 'liquidaciones')" checked> Ley Au</label><br>
        <label><input type="checkbox" id="col56" onclick="toggleColumn(56, 'liquidaciones')" > Pagable Au</label><br>
        <label><input type="checkbox" id="col57" onclick="toggleColumn(57, 'liquidaciones')" checked> Cu</label><br>
        <label><input type="checkbox" id="col58" onclick="toggleColumn(58, 'liquidaciones')" checked> Ag</label><br>
        <label><input type="checkbox" id="col59" onclick="toggleColumn(59, 'liquidaciones')" checked> Au</label><br>
        <label><input type="checkbox" id="col60" onclick="toggleColumn(60, 'liquidaciones')" checked> As</label><br>
        <label><input type="checkbox" id="col61" onclick="toggleColumn(61, 'liquidaciones')" checked> Sb</label><br>
        <label><input type="checkbox" id="col62" onclick="toggleColumn(62, 'liquidaciones')" checked> Bi</label><br>
        <label><input type="checkbox" id="col63" onclick="toggleColumn(63, 'liquidaciones')" checked> Pb</label><br>
        <label><input type="checkbox" id="col64" onclick="toggleColumn(64, 'liquidaciones')" checked> Hg</label><br>
        <label><input type="checkbox" id="col65" onclick="toggleColumn(65, 'liquidaciones')" checked> S</label><br>
        <label><input type="checkbox" id="col66" onclick="toggleColumn(66, 'liquidaciones')" checked> Valor US</label><br>
        <label><input type="checkbox" id="col67" onclick="toggleColumn(67, 'liquidaciones')" > Valor Lote</label><br>
        <label><input type="checkbox" id="col68" onclick="toggleColumn(68, 'liquidaciones')" > IGV</label><br>
        <label><input type="checkbox" id="col69" onclick="toggleColumn(69, 'liquidaciones')" > % Liquidación</label><br>
        <label><input type="checkbox" id="col70" onclick="toggleColumn(70, 'liquidaciones')" > Adelantos</label><br>
        <label><input type="checkbox" id="col71" onclick="toggleColumn(71, 'liquidaciones')" > Saldo</label><br>
        <label><input type="checkbox" id="col72" onclick="toggleColumn(72, 'liquidaciones')" > Detracción</label><br>
        <label><input type="checkbox" id="col73" onclick="toggleColumn(73, 'liquidaciones')" checked> Total Liquidación</label><br>
        <label><input type="checkbox" id="col74" onclick="toggleColumn(74, 'liquidaciones')" > Proceso Planta</label><br>
        <label><input type="checkbox" id="col75" onclick="toggleColumn(75, 'liquidaciones')" > Adelantos Extras</label><br>
        <label><input type="checkbox" id="col76" onclick="toggleColumn(76, 'liquidaciones')" > Préstamos</label><br>
        <label><input type="checkbox" id="col77" onclick="toggleColumn(77, 'liquidaciones')" > Otros Descuentos</label><br>
        <label><input type="checkbox" id="col78" onclick="toggleColumn(78, 'liquidaciones')" checked> Total Final</label><br>
        <label><input type="checkbox" id="col79" onclick="toggleColumn(79, 'liquidaciones')" > Fase</label><br>
        <label><input type="checkbox" id="col80" onclick="toggleColumn(80, 'liquidaciones')" checked> Estado</label><br>
        <label><input type="checkbox" id="col81" onclick="toggleColumn(81, 'liquidaciones')" > Liquidador</label><br>
    </div>
</div>
<div class="modal fade" id="modalBlendings" tabindex="-1" aria-labelledby="modalBlendingsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable custom-modal-width">
                <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalBlendingsLabel">Blendings Sin Sobrante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Código Blending</th>
                            <th>Peso Blending</th>
                            <th>Estado</th>
                            <th>¿Sobrante Asociado?</th>
                            <th>TMH</th>
                            <th>% H2O</th>
                            <th>TMS</th>
                            <th>Prom. Cu</th>
                            <th>Prom. Ag</th>
                            <th>Prom. Au</th>
                            <th>Prom. As</th>
                            <th>Prom. Sb</th>
                            <th>Prom. Pb</th>
                            <th>Prom. Zn</th>
                            <th>Prom. Bi</th>
                            <th>Prom. Hg</th>
                            <th>Valor Lote</th>
                            <th>Total Liquidación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($blendings as $blending)
                        @php
                        // Grupo completo: registros que pertenecen al blending (incluyendo sobrantes)
                        $grupoCompleto = $liquidaciones->filter(function ($liq) use ($blending) {
                            return optional($liq->ingreso->blendings->first())->cod == $blending->cod;
                        });

                        // Grupo SIN SOBRANTES: sólo los registros normales (para calcular promedios y valorización)
                        $grupoSinSobrantes = $grupoCompleto->filter(function ($liq) {
                            return stripos(strtoupper($liq->comentario ?? ''), 'SOBRANTE') === false;
                        });

                        // Sobrantes asociados (por si quieres contarlos o mostrarlos)
                        $sobrantes = $grupoCompleto->filter(function ($liq) {
                            return stripos(strtoupper($liq->comentario ?? ''), 'SOBRANTE') !== false;
                        });

                        $todosCierre = $grupoCompleto->every(function ($liq) {
                            return strtolower(trim($liq->estado)) === 'cierre';
                        });

                        // CALCULOS SOLO CON EL GRUPO SIN SOBRANTES
                        $totalTMH = $grupoSinSobrantes->sum('peso') ?? 0;
                        $totalTMS = $grupoSinSobrantes->sum('tms') ?? 0;
                        $porcentajeH2O = $totalTMH > 0 ? (($totalTMH - $totalTMS) / $totalTMH) * 100 : 0;
                        $prom = fn($campo) => $totalTMS > 0 ? $grupoSinSobrantes->sum(fn($l) => $l->tms * ($l->muestra->$campo ?? 0)) / $totalTMS : 0;
                        $valorLote = $grupoSinSobrantes->sum('valorporlote') ?? 0;
                        $totalLiquidacion = $grupoSinSobrantes->sum('total_liquidacion') ?? 0;
                    @endphp
                        <tr>
                            <td>{{ $blending->cod }}</td>
                            <td>{{ number_format($blending->pesoblending ?? 0, 3) }}</td>
                            <td style="color: {{ $todosCierre ? 'green' : 'orange' }}; font-weight:bold;">
                                {{ $todosCierre ? 'REAL' : 'TENTATIVO' }}
                            </td>
                            <td>{{ $sobrantes->count() > 0 ? 'Sí' : 'No' }}</td>
                    
                            <!-- Campos de resumen -->
                            <td>{{ number_format($totalTMH, 3) }}</td>
                            <td>{{ number_format($porcentajeH2O, 3) }}</td>
                            <td>{{ number_format($totalTMS, 3) }}</td>
                            <td>{{ number_format($prom('cu'), 3) }}</td>
                            <td>{{ number_format($prom('ag'), 3) }}</td>
                            <td>{{ number_format($prom('au'), 3) }}</td>
                            <td>{{ number_format($prom('as'), 3) }}</td>
                            <td>{{ number_format($prom('sb'), 3) }}</td>
                            <td>{{ number_format($prom('pb'), 3) }}</td>
                            <td>{{ number_format($prom('zn'), 3) }}</td>
                            <td>{{ number_format($prom('bi'), 3) }}</td>
                            <td>{{ number_format($prom('hg'), 3) }}</td>
                            <td>{{ number_format($valorLote, 2) }}</td>
                            <td>{{ number_format($totalLiquidacion, 2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
    <!-- Tabla de datos -->
    <div class="table-wrapper">
        <table id="tablaFlujo">
            <thead>
                <!-- Cabecera de la tabla (similar a la original) -->
                <tr>
                    <th>#</th>
                    <th class="col-ingresos">NroSalida</th>
                    <th class="col-ingresos">Peso Total</th>
                    <th class="col-ingresos">Fecha Ingreso</th>
                    <th class="col-ingresos">DNI / RUC</th>
                    
                    <th class="col-ingresos">NOMBRE / RAZON SOCIAL</th>
                    <th class="col-ingresos">Material</th>
                    <th class="col-ingresos">Procedencia</th>
                    <th class="col-ingresos">Placa</th>
                    <th class="col-ingresos">Guia Transporte</th>
                    <th class="col-ingresos">Guia Remision</th>
                    <th class="col-ingresos">Muestreo</th>
                    <th class="col-ingresos">Preparacion</th>
                    <th class="col-ingresos">Analisis Nasca Lab</th>
                    <th class="col-ingresos">Analisis Lab Peru</th>
                    <th class="col-ingresos">Lote</th>

                    <!-- BLENDING -->
                    <th class="col-blending">Lista</th>
                    <th class="col-blending">Cod Blending</th>
                    <th class="col-blending">A / I </th>
                    <th class="col-blending">Peso Blending</th>

                    <!-- DESPACHOS -->
                    <th class="col-despachos">ID Despacho</th>
                    <th class="col-despachos">TMH Despacho</th>
                    <th class="col-despachos">Mas/Menos</th>
                    <th class="col-despachos">Fecha Despacho</th>
                    <th class="col-despachos">Nro Salida Retiro</th>
                    <th class="col-despachos">Precinto</th>
                    <th class="col-despachos">Guia</th>
                    <th class="col-despachos">Bruto</th>
                    <th class="col-despachos">Tara</th>
                    <th class="col-despachos">Neto</th>
                    <th class="col-despachos">Tracto</th>
                    <th class="col-despachos">Carreta</th>
                    <th class="col-despachos">Guia Transporte</th>
                    <th class="col-despachos">RUC Despacho</th>
                    <th class="col-despachos">Razon Social</th>
                    <th class="col-despachos">Licencia</th>
                    <th class="col-despachos">Conductor</th>

                    <!-- LIQUIDACIONES -->
                    <th class="col-liquidaciones">ID</th>
                    <th class="col-liquidaciones">Fecha Actualización</th>
                    <th class="col-liquidaciones">Ruc</th>
                    <th class="col-liquidaciones">Cliente</th>
                    <th class="col-liquidaciones">Producto</th>
                    <th class="col-liquidaciones">Notas</th>
                    <th class="col-liquidaciones">Peso</th>
                    <th class="col-liquidaciones">Humedad</th>
                    <th class="col-liquidaciones">TMS</th>
                    <th class="col-liquidaciones">Merma</th>
                    <th class="col-liquidaciones">TMNS</th>
                    <th class="col-liquidaciones">Cotización Cu</th>
                    <th class="col-liquidaciones">Cotización Ag</th>
                    <th class="col-liquidaciones">Cotización Au</th>
                    <th class="col-liquidaciones">Ley Cu</th>
                    <th class="col-liquidaciones">Pagable Cu</th>
                    <th class="col-liquidaciones">Ley Ag</th>
                    <th class="col-liquidaciones">Pagable Ag</th>
                    <th class="col-liquidaciones">Ley Au</th>
                    <th class="col-liquidaciones">Pagable Au</th>
                    <th class="col-liquidaciones">Cu</th>
                    <th class="col-liquidaciones">Ag</th>
                    <th class="col-liquidaciones">Au</th>
                    <th class="col-liquidaciones">As</th>
                    <th class="col-liquidaciones">Sb</th>
                    <th class="col-liquidaciones">Bi</th>
                    <th class="col-liquidaciones">Pb</th>
                    <th class="col-liquidaciones">Hg</th>
                    <th class="col-liquidaciones">S</th>
                    <th class="col-liquidaciones">Valor US</th>
                    <th class="col-liquidaciones">Valor Lote</th>
                    <th class="col-liquidaciones">IGV</th>
                    <th class="col-liquidaciones">% Liquidación</th>
                    <th class="col-liquidaciones">Adelantos</th>
                    <th class="col-liquidaciones">Saldo</th>
                    <th class="col-liquidaciones">Detracción</th>
                    <th class="col-liquidaciones">Total Liquidación</th>
                    <th class="col-liquidaciones">Proceso Planta</th>
                    <th class="col-liquidaciones">Adelantos Extras</th>
                    <th class="col-liquidaciones">Préstamos</th>
                    <th class="col-liquidaciones">Otros Descuentos</th>
                    <th class="col-liquidaciones">Total Final</th>
                    <th class="col-liquidaciones">Fase</th>
                    <th class="col-liquidaciones">Estado</th>
                    <th class="col-liquidaciones">Liquidador</th>
                    <th class="col-promedio">TMH Grupo</th>
                    <th class="col-promedio">% H2O</th>
                    <th class="col-promedio">TMS Grupo</th>
                    <th class="col-promedio">Prom. Cu</th>
                    <th class="col-promedio">Prom. Ag</th>
                    <th class="col-promedio">Prom. Au</th>
                    <th class="col-promedio">Prom. As</th>
                    <th class="col-promedio">Prom. Sb</th>
                    <th class="col-promedio">Prom. Pb</th>
                    <th class="col-promedio">Prom. Zn</th>
                    <th class="col-promedio">Prom. Bi</th>
                    <th class="col-promedio">Prom. Hg</th>
                    <th class="col-promedio">Valor Lote Grupo</th>
                    <th class="col-promedio">Total Liquidación Grupo</th>
                </tr>
            </thead>
            
       
            <tbody>
                @php
                    $i = 1;
                    $blendingGroups = $liquidaciones->groupBy(function ($liq) {
                        return optional($liq->ingreso->blendings->first())->cod ?? null;
                    });
                @endphp
            
                @foreach ($liquidaciones as $liq)
                    @php
                        $estadoLiq = strtolower(trim($liq->estado ?? ''));
                        $ingreso = $liq->ingreso;
                        $blending = $ingreso->blendings->first();
                        $despacho = $blending?->despacho;
                        $retiro = $despacho?->retiros->first();
                        $codBlending = optional($blending)->cod;
            
                        $comentario = strtoupper($liq->comentario ?? '');
                        $codComentario = null;
            
                        if (preg_match('/B\d+/', $comentario, $matches)) {
                            $codComentario = $matches[0];
                        }
            
                        $esFilaResumen = $codComentario && is_null($blending);
                        $grupo = $blendingGroups[$codComentario] ?? collect();
            
                        $totalTMH = $grupo->sum('peso') ?? 0;
                        $totalTMS = $grupo->sum('tms') ?? 0;
                        $porcentajeH2O = $totalTMH > 0 ? (($totalTMH - $totalTMS) / $totalTMH) * 100 : 0;
                        $prom = fn($campo) => $totalTMS > 0 ? $grupo->sum(fn($l) => $l->tms * ($l->muestra->$campo ?? 0)) / $totalTMS : 0;
                        $valorLote = $grupo->sum('valorporlote') ?? 0;
                        $totalLiquidacion = $grupo->sum('total_liquidacion') ?? 0;
                    @endphp
            
                    @if ($estadoLiq === 'cierre' || $estadoLiq === '')
                        <tr class="con-liquidacion">
                            <td>{{ $i++ }}</td>
                            <!-- INGRESOS -->
                            <td style="background-color:#d1ecf1;">{{ $liq->NroSalida }}</td>
                            <td style="background-color:#d1ecf1;">{{ number_format($ingreso->peso_total ?? 0, 3) }}</td>
                            <td style="background-color:#d1ecf1;">{{ \Carbon\Carbon::parse($ingreso->fecha_ingreso)->format('d/m/Y') ?? 'N/A' }}</td>
                            <td style="background-color:#d1ecf1;">{{ $ingreso->identificador ?? 'N/A' }}</td>
                            <td style="background-color:#d1ecf1;">{{ $ingreso->nom_iden ?? 'N/A' }}</td>
                            <td style="background-color:#d1ecf1;">{{ $ingreso->estado ?? 'N/A' }}</td>
                            <td style="background-color:#d1ecf1;">{{ $ingreso->procedencia ?? 'N/A' }}</td>
                            <td style="background-color:#d1ecf1;">{{ $ingreso->placa ?? 'N/A' }}</td>
                            <td style="background-color:#d1ecf1;">{{ $ingreso->guia_transporte ?? 'N/A' }}</td>
                            <td style="background-color:#d1ecf1;">{{ $ingreso->guia_remision ?? 'N/A' }}</td>
                            <td style="background-color:#d1ecf1;">{{ $ingreso->muestreo ?? 'N/A' }}</td>
                            <td style="background-color:#d1ecf1;">{{ $ingreso->preparacion ?? 'N/A' }}</td>
                            <td style="background-color:#d1ecf1;">{{ $ingreso->req_analisis ?? 'N/A' }}</td>
                            <td style="background-color:#d1ecf1;">{{ $ingreso->req_analisis1 ?? 'N/A' }}</td>
                            <td style="background-color:#d1ecf1;">{{ $ingreso->ref_lote ?? 'N/A' }}</td>
            
                            <!-- BLENDING -->
                            <td style="background-color:#fff3cd;">{{ $blending->lista ?? 'N/A' }}</td>
                            <td style="background-color:#fff3cd;">{{ $blending->cod ?? 'N/A' }}</td>
                            <td style="background-color:#fff3cd;">{{ $blending->estado ?? 'N/A' }}</td>
                            <td style="background-color:#fff3cd;">{{ number_format($blending->pesoblending ?? 0, 3) }}</td>
            
                            <!-- DESPACHOS -->
                            <td style="background-color:#fde2e2;">{{ $despacho->id ?? 'N/A' }}</td>
                            <td style="background-color:#fde2e2;">{{ number_format($despacho->totalTMH ?? 0, 3) }}</td>
                            <td style="background-color:#fde2e2;">{{ $despacho->masomenos ?? '-' }}</td>
                            <td style="background-color:#fde2e2;">{{ $despacho->fecha ?? '-' }}</td>
                            <td style="background-color:#fde2e2;">{{ $retiro->nro_salida ?? '-' }}</td>
                            <td style="background-color:#fde2e2;">{{ $retiro->precinto ?? '-' }}</td>
                            <td style="background-color:#fde2e2;">{{ $retiro->guia ?? '-' }}</td>
                            <td style="background-color:#fde2e2;">{{ $retiro->bruto ?? '-' }}</td>
                            <td style="background-color:#fde2e2;">{{ $retiro->tara ?? '-' }}</td>
                            <td style="background-color:#fde2e2;">{{ $retiro->neto ?? '-' }}</td>
                            <td style="background-color:#fde2e2;">{{ $retiro->tracto ?? '-' }}</td>
                            <td style="background-color:#fde2e2;">{{ $retiro->carreta ?? '-' }}</td>
                            <td style="background-color:#fde2e2;">{{ $retiro->guia_transporte ?? '-' }}</td>
                            <td style="background-color:#fde2e2;">{{ $retiro->ruc_empresa ?? '-' }}</td>
                            <td style="background-color:#fde2e2;">{{ $retiro->razon_social ?? '-' }}</td>
                            <td style="background-color:#fde2e2;">{{ $retiro->licencia ?? '-' }}</td>
                            <td style="background-color:#fde2e2;">{{ $retiro->conductor ?? '-' }}</td>
            
                            <!-- LIQUIDACIONES -->
                            <td style="background-color:#d4edda;">{{ $liq->id ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->updated_at ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->cliente->documento_cliente ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->cliente->datos_cliente ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->producto }}</td>
                            <td style="background-color:#d4edda;">
                                @if (stripos($liq->comentario, 'SOBRANTE') !== false)
                                    {{ $liq->comentario }}
                                @endif
                            </td>
                            <td style="background-color:#d4edda;">{{ $liq->peso ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->muestra->humedad ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->tms ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->merma2 ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->tmns ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->cotizacion_cu ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->cotizacion_ag ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->cotizacion_au ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->ley_cu ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->pagable_cu2 ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->ley_ag ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->pagable_ag2 ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->ley_au ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->pagable_au2 ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->muestra->cu ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->muestra->ag ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->muestra->au ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->muestra->as ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->muestra->sb ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->muestra->bi ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->muestra->pb ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->muestra->hg ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->muestra->s ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->total_us ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->valorporlote ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->valor_igv ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->total_porcentajeliqui ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->adelantos ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->saldo ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->detraccion ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->total_liquidacion ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->procesoplanta ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->adelantosextras ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->prestamos ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->otrosdescuentos ?? '-' }}</td>
                            <td style="background-color:#d4edda; color: {{ $liq->total < 0 ? 'red' : 'inherit' }};">{{ $liq->total }}</td>
                            <td style="background-color:#d4edda;">{{ $ingreso->fase ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->estado ?? '-' }}</td>
                            <td style="background-color:#d4edda;">{{ $liq->lastEditor->name ?? 'N/A' }}</td>
            
                            {{-- PROMEDIOS O GUIONES --}}
                            @if ($esFilaResumen)
                                <td>{{ number_format($totalTMH, 3) }}</td>
                                <td>{{ number_format($porcentajeH2O, 3) }}</td>
                                <td>{{ number_format($totalTMS, 3) }}</td>
                                <td>{{ number_format($prom('cu'), 3) }}</td>
                                <td>{{ number_format($prom('ag'), 3) }}</td>
                                <td>{{ number_format($prom('au'), 3) }}</td>
                                <td>{{ number_format($prom('as'), 3) }}</td>
                                <td>{{ number_format($prom('sb'), 3) }}</td>
                                <td>{{ number_format($prom('pb'), 3) }}</td>
                                <td>{{ number_format($prom('zn'), 3) }}</td>
                                <td>{{ number_format($prom('bi'), 3) }}</td>
                                <td>{{ number_format($prom('hg'), 3) }}</td>
                                <td>{{ number_format($valorLote, 2) }}</td>
                                <td>{{ number_format($totalLiquidacion, 2) }}</td>
                            @else
                                <td colspan="14" style="color:gray;">-</td>
                            @endif
                        </tr>
                    @endif
                @endforeach
             @foreach ($ingresosSinLiquidacion as $ingreso)
             <tr class="sin-liquidacion">
                 <td>{{ $i++ }}</td>
                 <!-- Repite solo las columnas de INGRESOS -->
                 <td style="background-color:#d1ecf1;">{{ $ingreso->NroSalida ?? '-' }}</td>
                 <td style="background-color:#d1ecf1;">{{ number_format($ingreso->peso_total ?? 0, 3) }}</td>
                 <td style="background-color:#d1ecf1;">{{ \Carbon\Carbon::parse($ingreso->fecha_ingreso)->format('d/m/Y') ?? 'N/A' }}</td>
                 <td style="background-color:#d1ecf1;">{{ $ingreso->identificador ?? '-' }}</td>
                 <td style="background-color:#d1ecf1;">{{ $ingreso->nom_iden ?? '-' }}</td>
                 <td style="background-color:#d1ecf1;">{{ $ingreso->producto ?? '-' }}</td>
                 <td style="background-color:#d1ecf1;">{{ $ingreso->procedencia ?? '-' }}</td>
                 <td style="background-color:#d1ecf1;">{{ $ingreso->placa ?? '-' }}</td>
                 <td style="background-color:#d1ecf1;">{{ $ingreso->guia_transporte ?? '-' }}</td>
                 <td style="background-color:#d1ecf1;">{{ $ingreso->guia_remision ?? '-' }}</td>
                 <td style="background-color:#d1ecf1;">{{ $ingreso->muestreo ?? '-' }}</td>
                 <td style="background-color:#d1ecf1;">{{ $ingreso->preparacion ?? '-' }}</td>
                 <td style="background-color:#d1ecf1;">{{ $ingreso->req_analisis ?? '-' }}</td>
                 <td style="background-color:#d1ecf1;">{{ $ingreso->req_analisis1 ?? '-' }}</td>
                 <td style="background-color:#d1ecf1;">{{ $ingreso->ref_lote ?? '-' }}</td>
         
                 <!-- Vacío para BLENDING (4 columnas) -->
                 <td colspan="4" style="background-color:#fff3cd;">SIN DATOS</td>
         
                 <!-- Vacío para DESPACHOS (17 columnas) -->
                 <td colspan="17" style="background-color:#fde2e2;">SIN DATOS</td>
         
                 <!-- Vacío para LIQUIDACIONES (41 columnas) -->
                 <td colspan="41" style="background-color:#d4edda;">SIN DATOS</td>
         
                 <!-- Vacío para PROMEDIOS (14 columnas) -->
                 <td colspan="14" style="background-color:#f0f0f0; color:gray;">-</td>
             </tr>
         @endforeach
         </tbody>
     </table>
 </div>
</div>

@endsection
@push('scripts')
<script>
    function toggleColumn(index, section) {
        const table = document.getElementById("tablaFlujo");
        const rows = table.getElementsByTagName("tr");

        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName("td");
            const headers = rows[i].getElementsByTagName("th");

            if (i === 0) {
                if (headers[index]) {
                    headers[index].classList.toggle("hidden");
                }
            } else {
                if (cells[index]) {
                    cells[index].classList.toggle("hidden");
                }
            }
        }

        toggleHeaderVisibility(section);
    }

    function toggleDropdown(section) {
        const sectionList = document.getElementById(section);
        sectionList.classList.toggle("active");
    }

    function toggleHeaderVisibility(section) {
        const sectionColumns = document.querySelectorAll(`.${section} .col-${section}`);
        const isVisible = [...sectionColumns].some(cell => !cell.classList.contains("hidden"));

        const header = document.querySelector(`.grupo-${section}`);
        if (header) {
            header.style.display = isVisible ? "" : "none";
        }
    }

    function filtrarTipoIngreso(valor) {
        const filasCon = document.querySelectorAll(".con-liquidacion");
        const filasSin = document.querySelectorAll(".sin-liquidacion");

        if (valor === "todos") {
            filasCon.forEach(f => f.style.display = "");
            filasSin.forEach(f => f.style.display = "");
        } else if (valor === "asociados") {
            filasCon.forEach(f => f.style.display = "");
            filasSin.forEach(f => f.style.display = "none");
        } else if (valor === "libres") {
            filasCon.forEach(f => f.style.display = "none");
            filasSin.forEach(f => f.style.display = "");
        }
    }

    window.onload = function () {
    const allCheckboxes = document.querySelectorAll('.checkbox-list input[type="checkbox"]');
    allCheckboxes.forEach((checkbox) => {
        if (!checkbox.checked) {
            const match = checkbox.id.match(/\d+/);
            const index = match ? parseInt(match[0]) : -1;
            const section = checkbox.closest('.checkbox-list').id;
            if (index >= 0) {
                toggleColumn(index, section); // ya no restamos 1
            }
        }
    });
};
document.addEventListener("DOMContentLoaded", function () {
    const filas = document.querySelectorAll("#tablaFlujo tbody tr");

    filas.forEach(fila => {
        fila.addEventListener("click", function () {
            // Quitar la clase de todas las filas primero
            filas.forEach(f => f.classList.remove("fila-seleccionada"));
            // Agregar la clase solo a la fila clicada
            this.classList.add("fila-seleccionada");
        });
    });
});

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endpush
