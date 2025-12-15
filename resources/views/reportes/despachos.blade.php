@extends('layouts.app')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    html, body {
        font-family: Arial;
        background: #2c3e50;
        color: white;
    }
    h1 {
        text-align: center;
        margin-top: 20px;
    }
    .table-wrapper {
        background-color: white;
        color: black;
        margin: auto;
        max-width: 98%;
        max-height: 70vh;
        overflow-x: auto;
        padding: 10px;
        border-radius: 10px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    th, td {
        padding: 6px;
        text-align: center;
        border: 1px solid #dee2e6;
    }
    thead th {
        position: sticky;
        top: 0;
        background-color: #e9ecef;
    }
    tr:hover {
        background-color: #e2f0ff;
    }
    .filtro-input {
        padding: 6px 10px;
        font-size: 13px;
        border-radius: 6px;
        border: 1px solid #ced4da;
        background: white;
    }
    .btn-excel {
        background-color: #198754;
        color: white;
        padding: 8px 14px;
        border-radius: 6px;
        font-weight: bold;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    #contadorRegistros, #tmhTotal {
        text-align: center;
        font-weight: bold;
        margin: 10px 0;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <h1>REPORTE DE DESPACHOS</h1>
    <div id="contadorRegistros">Total de despachos: {{ count($despachos) }}</div>
    <div id="tmhTotal">Total TMH filtrado: {{ number_format($totalTMH, 3) }}</div>

    <div class="d-flex gap-2 flex-wrap justify-content-between px-3 mb-3">
        <div>
        <input type="text" id="buscadorDespachos" class="filtro-input" placeholder="🔍 Buscar código o destino">
        <input type="text" id="filtroFechaDespacho" class="filtro-input" placeholder="📅 Fecha" readonly></div>
        <form action="{{ route('reportes.despachos.exportar') }}" method="GET" id="formExportarDespachos">
            <input type="hidden" name="busqueda" id="inputBusqueda">
            <input type="hidden" name="fecha" id="inputFecha">
            <button type="submit" class="btn-excel">
                <i class="fas fa-file-excel"></i> Exportar Excel
            </button>
        </form>
    </div>

    <div class="table-wrapper">
        <table class="tabla-despachos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Blending</th>
                    <th>Total TMH</th>
                    <th>Falta o Excede</th>
                    <th>Fecha</th>
                    <th>Destino</th>
                    <th>Deposito</th>
                    <th>Observación</th>
                    <th>Retiros</th>
                </tr>
            </thead>
            <tbody>
                @foreach($despachos as $despacho)
                    <tr class="fila-despacho">
                        <td>{{ $despacho->id }}</td>
                        <td>{{ $despacho->blending->cod ?? 'N/A' }}</td>
                        <td data-tmh="{{ number_format($despacho->totalTMH, 3, '.', '') }}">{{ number_format($despacho->totalTMH, 3, ',', '.') }}</td>
                        <td>{{ $despacho->masomenos }}</td>
                        <td>{{ $despacho->fecha }}</td>
                        <td>{{ $despacho->destino }}</td>
                        <td>{{ $despacho->deposito }}</td>
                        <td>{{ $despacho->observacion }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary toggle-retiros">
                                Ver retiros ({{ $despacho->retiros->count() }})
                            </button>
                            <div class="contenedor-retiros mt-2" style="display:none;">
                                <input type="text" class="filtro-input buscador-retiros mb-2" placeholder="Buscar retiro...">
                                <table class="tabla-retiros" style="width: 100%; font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th>Nro Salida</th>
                                            <th>Precinto</th>
                                            <th>Guía</th>
                                            <th>Bruto</th>
                                            <th>Tara</th>
                                            <th>Neto</th>
                                            <th>Tracto</th>
                                            <th>Carreta</th>
                                            <th>Guia Transporte</th>
                                            <th>RUC</th>
                                            <th>Razón Social</th>
                                            <th>Licencia</th>
                                            <th>Conductor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($despacho->retiros as $retiro)
                                            <tr>
                                                <td>{{ $retiro->nro_salida }}</td>
                                                <td>{{ $retiro->precinto }}</td>
                                                <td>{{ $retiro->guia }}</td>
                                                <td>{{ $retiro->bruto }}</td>
                                                <td>{{ $retiro->tara }}</td>
                                                <td>{{ $retiro->neto }}</td>
                                                <td>{{ $retiro->tracto }}</td>
                                                <td>{{ $retiro->carreta }}</td>
                                                <td>{{ $retiro->guia_transporte }}</td>
                                                <td>{{ $retiro->ruc_empresa }}</td>
                                                <td>{{ $retiro->razon_social }}</td>
                                                <td>{{ $retiro->licencia }}</td>
                                                <td>{{ $retiro->conductor }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </td>
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
    document.addEventListener('DOMContentLoaded', () => {
        flatpickr("#filtroFechaDespacho", {
            mode: "range",
            dateFormat: "Y-m-d",
            locale: "es",
            onChange: filtrarDespachos
        });

        document.getElementById("buscadorDespachos").addEventListener('input', filtrarDespachos);
        document.getElementById("filtroFechaDespacho").addEventListener('change', filtrarDespachos);

        document.getElementById("formExportarDespachos").addEventListener("submit", () => {
            document.getElementById("inputBusqueda").value = document.getElementById("buscadorDespachos").value;
            document.getElementById("inputFecha").value = document.getElementById("filtroFechaDespacho").value;
        });

        activarBotonesRetiros();
        activarBuscadoresInternos();
        filtrarDespachos();
    });

    function filtrarDespachos() {
    const search = document.getElementById("buscadorDespachos").value.toLowerCase();
    const fechas = document.getElementById("filtroFechaDespacho").value.split(" a ");
    const desde = fechas[0] ? new Date(fechas[0]) : null;
    const hasta = fechas[1] ? new Date(fechas[1]) : null;

    let total = 0;
    let totalTMH = 0;

    document.querySelectorAll(".tabla-despachos tbody tr.fila-despacho").forEach(row => {
        const tds = row.querySelectorAll("td");
        const textoFila = [...tds].map(td => td.textContent.toLowerCase()).join(" ");
        const fecha = new Date(tds[4]?.innerText.trim()); // CORREGIDO: fecha ahora es tds[4]
        const tmh = parseFloat(tds[2]?.getAttribute('data-tmh')) || 0;

        let visible = true;
        if (search && !textoFila.includes(search)) visible = false;
        if (desde && hasta && (fecha < desde || fecha > hasta)) visible = false;

        row.style.display = visible ? '' : 'none';
        if (visible) {
            total++;
            totalTMH += tmh;
        }
    });

    document.getElementById("contadorRegistros").textContent = `Total de despachos: ${total}`;
    document.getElementById("tmhTotal").textContent = `Total TMH filtrado: ${totalTMH.toFixed(3)}`;
}

    function activarBotonesRetiros() {
    document.querySelectorAll('.toggle-retiros').forEach(btn => {
        btn.addEventListener('click', function () {
            const contenedor = this.closest('td').querySelector('.contenedor-retiros');
            contenedor.style.display = contenedor.style.display === 'none' || contenedor.style.display === '' ? 'block' : 'none';
        });
    });
}

    function activarBuscadoresInternos() {
        document.querySelectorAll('.buscador-retiros').forEach(input => {
            input.addEventListener('input', function () {
                const texto = this.value.toLowerCase();
                const filas = this.nextElementSibling.querySelectorAll('tbody tr');
                filas.forEach(row => {
                    row.style.display = row.innerText.toLowerCase().includes(texto) ? '' : 'none';
                });
            });
        });
    }
</script>
@endpush
