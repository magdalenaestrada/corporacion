@extends('layouts.app')

@push('styles')
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
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
            margin: 20px 0;
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
            padding: 8px;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            border: 1px solid #dee2e6;
        }

        td {
            padding: 6px;
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
            width: 200px;
        }
        .btn-excel {
                background-color: #198754;
                color: white;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 8px 14px;
                border-radius: 6px;
                text-decoration: none;
                font-weight: bold;
                font-size: 14px;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
                transition: background-color 0.3s ease;
            }

            .btn-excel:hover {
                background-color: #218838;
                color: white;
            }
        /* Fase colors */
        .fase-ingresado { background-color: #c3e6cb !important; }
        .fase-blending { background-color: #fff3cd !important; }
        .fase-despachado { background-color: #f8d7da !important; }
        .fase-retirado { background-color: #dee2e6 !important; }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <h1>REPORTE DE INGRESOS</h1>
<div class="text-center my-3">
   
    <span class="badge bg-info text-dark fs-10 p-2">
        {{ __('Peso Total: ') }} {{ number_format($pesoTotal, 3) }} 
    </span>
    <span class="badge bg-success text-dark fs-10 p-2">
        {{ __('Peso Ingresados: ') }} {{ number_format($pesoIngresados, 3) }}
    </span>
    <span class="badge bg-warning fs-10 p-2 text-dark">
        {{ __('Peso Blending: ') }} {{ number_format($pesoBlending, 3) }}
    </span>
    <span class="badge bg-danger text-dark fs-10 p-2">
        {{ __('Peso Despachado: ') }} {{ number_format($pesoDespachado, 3) }}
    </span>
    <span class="badge bg-white text-dark fs-10 p-2">
        {{ __('Peso Retirado: ') }} {{ number_format($pesoRetirado, 3) }}
    </span>
    <span class="badge bg-primary text-dark text-white fs-10 p-2">
        {{ __('Peso en Stock: ') }} {{ number_format($pesoEnStock, 3) }}
    </span>
</div>
    <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between mb-3 px-3">
        <div style="display: flex; gap: 10px; color: #f8f9fa;">
            <strong style="color: #28a745;">🟩 Ingresado</strong>
            <strong style="color: #ffc107;">🟨 Blending</strong>
            <strong style="color: #dc3545;">🟥 Despachado</strong>
            <strong style="color: #adb5bd;">⬜ Retirado</strong>
        </div>
    <div>
        <form id="formExportIngresos" action="{{ route('reportes.exportar.ingresos') }}" method="GET" style="display: inline;">
            <input type="hidden" name="fase" id="inputFase">
            <input type="hidden" name="fecha" id="inputFecha">
            <input type="hidden" name="busqueda" id="inputBusqueda">
            
            <button type="submit" class="btn-excel" style="padding: 6px 10px;">
                <i class="fas fa-file-excel"></i> Exportar Excel
            </button>
        </form>
    </a>
</div>
        <div class="d-flex gap-2 flex-wrap">
            <input type="text" id="buscadorGlobal" class="filtro-input" placeholder="🔍 Buscar...">
            <input type="text" id="rangoFechas" class="filtro-input" placeholder="📅 Fecha ingreso" readonly>
            <select id="filtroFase" class="filtro-input" onchange="filtrarTabla()">
                <option value="">Todas las fases</option>
                <option value="ingresado">Ingresado</option>
                <option value="blending">Blending</option>
                <option value="despachado">Despachado</option>
                <option value="retirado">Retirado</option>
            </select>
        </div>
    </div>

    <p id="contadorRegistros">Total de registros: 0</p>
    <p id="contadorPesoFiltrado" style="font-size: 16px; font-weight: bold; text-align: center; color: #ffffff;">
        Peso total filtrado: 0.000
    </p>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Fecha Ingreso</th>
                    <th>Identificador</th>
                    <th>Nombre Ident.</th>
                    <th>Ref. Lote</th>
                    <th>Peso Total</th>
                    <th>Estado</th>
                    <th>NroSalida</th>
                    <th>Procedencia</th>
                    <th>Deposito</th>
                    <th>Balanza</th>
                    <th>Placa</th>
                    <th>Tolva</th>
                    <th>Guía Transporte</th>
                    <th>Guía Remisión</th>
                    <th>Muestreo</th>
                    <th>Preparación</th>
                    <th>Req. Análisis Nasca Lab</th>
                    <th>Req. Análisis Lab Peru</th>
                    <th>Descuento</th>
                    <th>Fecha Salida</th>
                    <th>Retiro</th>
                    <th>Peso Externo</th>
                    <th>
                        <input type="text" id="filtroLote" class="filtro-input" placeholder="Buscar Lote...">
                    </th>
                    <th>Descripción</th>
                    <th>Fase</th>
                    <th>Usuario</th>
                    <th>Creado</th>
                    <th>Actualizado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ingresos as $ingreso)
                    @php
                        $fase = strtolower($ingreso->fase ?? '');
                    @endphp
                    <tr class="fila-fase fase-{{ $fase }}">
                        <td>{{ $ingreso->id }}</td>
                        <td>{{ $ingreso->codigo }}</td>
                        <td>{{ $ingreso->fecha_ingreso }}</td>
                        <td>{{ $ingreso->identificador }}</td>
                        <td>{{ $ingreso->nom_iden }}</td>
                        <td>{{ $ingreso->ref_lote }}</td>
                        <td class="peso-total">{{ $ingreso->peso_total }}</td>
                        <td>{{ $ingreso->estado }}</td>
                        <td>{{ $ingreso->NroSalida }}</td>
                        <td>{{ $ingreso->procedencia }}</td>
                        <td>{{ $ingreso->deposito }}</td>
                        <td>{{ $ingreso->balanza }}</td>
                        <td>{{ $ingreso->placa }}</td>
                        <td>{{ $ingreso->tolva }}</td>
                        <td>{{ $ingreso->guia_transporte }}</td>
                        <td>{{ $ingreso->guia_remision }}</td>
                        <td>{{ $ingreso->muestreo }}</td>
                        <td>{{ $ingreso->preparacion }}</td>
                        <td>{{ $ingreso->req_analisis }}</td>
                        <td>{{ $ingreso->req_analisis1 }}</td>
                        <td>{{ $ingreso->descuento }}</td>
                        <td>{{ $ingreso->fecha_salida }}</td>
                        <td>{{ $ingreso->retiro }}</td>
                        <td>{{ $ingreso->pesoexterno }}</td>
                        <td>{{ $ingreso->lote }}</td>
                        <td>{{ $ingreso->descripcion }}</td>
                        <td>{{ ucfirst($fase) }}</td>
                        <td>{{ $ingreso->user ? $ingreso->user->name : 'Desconocido' }}</td>
                        <td>{{ $ingreso->created_at }}</td>
                        <td>{{ $ingreso->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        flatpickr("#rangoFechas", {
            mode: "range",
            dateFormat: "Y-m-d",
            locale: "es",
            onChange: filtrarTabla
        });

        document.getElementById('buscadorGlobal').addEventListener('input', filtrarTabla);
        document.getElementById('filtroLote').addEventListener('input', filtrarTabla);
        document.getElementById('filtroFase').addEventListener('change', filtrarTabla);

        filtrarTabla();
    });

    function filtrarTabla() {
        const search = document.getElementById("buscadorGlobal").value.toLowerCase();
        const loteSearch = document.getElementById("filtroLote").value.toLowerCase();
        const fase = document.getElementById("filtroFase").value.toLowerCase();
        const fechas = document.getElementById("rangoFechas").value.split(" to ");
        const desde = fechas[0] ? new Date(fechas[0]) : null;
        const hasta = fechas[1] ? new Date(fechas[1]) : null;

        const filas = document.querySelectorAll("tbody tr");
        let total = 0;
        let pesoFiltrado = 0;

        filas.forEach(fila => {
            const cells = fila.querySelectorAll("td");
            const textoFila = [...cells].map(td => td.textContent.toLowerCase()).join(" ");
            const faseTexto = cells[26]?.textContent.toLowerCase() || "";
            const fecha = new Date(cells[2]?.textContent);
            const loteTexto = cells[24]?.textContent.toLowerCase() || "";
            const pesoTexto = fila.querySelector(".peso-total")?.textContent || "0";

            let visible = true;

            if (search && !textoFila.includes(search)) visible = false;
            if (loteSearch && !loteTexto.includes(loteSearch)) visible = false;
            if (fase && !faseTexto.includes(fase)) visible = false;
            if (desde && hasta && (fecha < desde || fecha > hasta)) visible = false;

            fila.style.display = visible ? "" : "none";

            if (visible) {
                total++;
                pesoFiltrado += parseFloat(pesoTexto) || 0;
            }
        });

        document.getElementById("contadorRegistros").textContent = `Total de registros: ${total}`;
        document.getElementById("contadorPesoFiltrado").textContent = `Peso total filtrado: ${pesoFiltrado.toFixed(3)}`;
    }
</script>
<script>
    document.querySelector('#formExportIngresos').addEventListener('submit', function (e) {
        document.querySelector('#inputFase').value = document.querySelector('#filtroFase').value;
        document.querySelector('#inputFecha').value = document.querySelector('#rangoFechas').value;
        document.querySelector('#inputBusqueda').value = document.querySelector('#buscadorGlobal').value;
    });
</script>
@endpush
