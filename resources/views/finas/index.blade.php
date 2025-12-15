@extends('layouts.app')

@section('content')
<style>
    .table thead th {
        background: linear-gradient(135deg, #1c445f, #306b8a);
        color: white;
        vertical-align: middle;
    }
    .table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .table tbody tr:hover {
        background-color: #f1f8ff;
        transition: background-color 0.3s;
    }
    .filtros label {
        font-weight: bold;
        color: #f1f1f1;
    }
    .form-control {
        border-radius: 6px;
        border: 1px solid #ccc;
    }
    .btn-blend-fixed {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        animation: bounce 1.5s infinite;
    }
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
</style>

<div class="container-fluid">
    <h1 class="text-center my-3 text-white">BLENDINGS</h1>

    <div class="filtros d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center">
            <label class="mr-3">
                <input type="checkbox" id="estadoNA" onchange="filtrarTabla()"> PROVISIONAL
            </label>
            <label class="mr-3">
                <input type="checkbox" id="estadoCierre" onchange="filtrarTabla()"> CIERRE
            </label>
            <label class="mr-3">
                <input type="checkbox" id="mostrarChancado" onchange="filtrarTabla()"> CHANCADO
            </label>
        </div>

        <div class="d-flex w-50">
            <input type="text" id="buscador" onkeyup="filtrarTabla()" placeholder="Buscar por Liquidación ID, Producto, o Muestra..." class="form-control">
        </div>

        <form id="blendForm" action="{{ route('finas.create') }}" method="POST">
            @csrf
            <div class="d-flex align-items-center">
                <button class="btn btn-success ml-2" type="button" onclick="exportarExcel()">
                    Exportar Excel <i class="fas fa-file-excel"></i>
                </button>
                <a href="{{ route('procesadas') }}" class="btn btn-primary ml-2">
                    Volver
                </a>
            </div>
        </form>
    </div>

    <form id="blendForm" action="{{ route('finas.create') }}" method="POST">
        @csrf
        <table id="tablaExport" class="table table-bordered table-striped table-hover text-center shadow-sm">
            <thead>
                <tr>
                    <th></th>
                    <th>Creación Liquidación</th>
                    <th>Liquidación ID</th>
                    <th>Cliente</th>
                    <th>Nombre Lote</th>
                    <th>Nota</th>
                    <th>Ticket Nro Salida</th>
                    <th>Producto</th>
                    <th>Peso</th>
                    <th>%H2O</th>
                    <th>TMS</th>
                    <th>Código Muestra</th>
                    <th>Cu</th>
                    <th>Ag</th>
                    <th>Au</th>
                    <th>As</th>
                    <th>Sb</th>
                    <th>Pb</th>
                    <th>Zn</th>
                    <th>Bi</th>
                    <th>Hg</th>
                    <th>Valor Por Lote US$</th>
                    <th>Total Liquidación</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($liquidaciones as $liquidacion)
                    <tr class="estado-row" data-estado="{{ $liquidacion->estado ?? 'N/A PROVISIONAL' }}" data-producto="{{ strtolower($liquidacion->producto) }}">
                        <td><input type="checkbox" name="liquidaciones[]" value="{{ $liquidacion->id }}"></td>
                        <td>{{ $liquidacion->created_at }}</td>
                        <td>{{ $liquidacion->id }}</td>
                        <td>{{ $liquidacion->cliente->datos_cliente }}</td>
                        <td>{{ $liquidacion->lote }}</td>
                        <td>{{ $liquidacion->comentario }}</td>
                        <td>{{ $liquidacion->NroSalida }}</td>
                        <td>{{ $liquidacion->producto }}</td>
                        <td>{{ $liquidacion->peso }}</td>
                        <td>{{ $liquidacion->muestra->humedad ?? 'N/A' }}</td>
                        <td>{{ $liquidacion->tms }}</td>
                        @if ($liquidacion->muestra)
                            <td>{{ $liquidacion->muestra->codigo }}</td>
                            <td>{{ $liquidacion->muestra->cu }}</td>
                            <td>{{ $liquidacion->muestra->ag }}</td>
                            <td>{{ $liquidacion->muestra->au }}</td>
                            <td>{{ $liquidacion->muestra->as }}</td>
                            <td>{{ $liquidacion->muestra->sb }}</td>
                            <td>{{ $liquidacion->muestra->pb }}</td>
                            <td>{{ $liquidacion->muestra->zn }}</td>
                            <td>{{ $liquidacion->muestra->bi }}</td>
                            <td>{{ $liquidacion->muestra->hg }}</td>
                            <td>{{ $liquidacion->valorporlote }}</td>
                            <td>{{ $liquidacion->total }}</td>
                        @else
                            <td colspan="13" class="text-danger font-italic">No hay muestra asociada</td>
                        @endif
                        <td>{{ $liquidacion->estado ?? 'PROVISIONAL' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary btn-lg btn-blend-fixed">Blendear</button>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("mostrarChancado").checked = false;
        filtrarTabla();
    });

    function filtrarTabla() {
    var inputGeneral = document.getElementById("buscador").value.toLowerCase();
    var estadoNA = document.getElementById("estadoNA").checked;
    var estadoCierre = document.getElementById("estadoCierre").checked;
    var mostrarChancado = document.getElementById("mostrarChancado").checked;
    var filas = document.querySelectorAll("table tbody tr");

    filas.forEach(fila => {
        const textoFila = fila.textContent.toLowerCase();
        const producto = fila.dataset.producto;
        const estado = fila.dataset.estado?.toLowerCase() || "";

        let coincideBusqueda = textoFila.includes(inputGeneral);
        let coincideEstado =
            (!estadoNA && !estadoCierre) ||
            (estadoNA && (estado === 'provisional' || estado === 'n/a provisional')) ||
            (estadoCierre && estado === 'cierre');
      let incluirChancado = mostrarChancado ? producto === "chancado" : producto !== "chancado";

        if (coincideBusqueda && coincideEstado && incluirChancado) {
            fila.style.display = "";
        } else {
            fila.style.display = "none";
        }
    });
}

    function exportarExcel() {
    const tabla = document.getElementById("tablaExport");
    const filas = tabla.querySelectorAll("tbody tr");
    const datos = [];
    const encabezados = Array.from(tabla.querySelectorAll("thead th"))
        .slice(1) // Omitir checkbox
        .map(th => th.textContent.trim());

    datos.push(encabezados);

    filas.forEach(fila => {
        if (fila.style.display !== "none") {
            const celdas = fila.querySelectorAll("td");
            const filaDatos = [];
            celdas.forEach((celda, index) => {
                if (index === 0) return; // Omitir checkbox
                filaDatos.push(celda.textContent.trim());
            });
            datos.push(filaDatos);
        }
    });

    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.aoa_to_sheet(datos);

    // 👉 Estilo manual de cabecera (fondo + fuente) usando XLSX writing options (solo compatible con SheetJS Pro)
    // Para la versión gratuita, puedes hacer algo visual aplicando formatos luego en Excel

    // Truco básico: sobrescribir el primer rango con un estilo (opcional visual, no color real)
    const range = XLSX.utils.decode_range(ws['!ref']);
    for (let C = range.s.c; C <= range.e.c; ++C) {
        const cell_address = XLSX.utils.encode_cell({ c: C, r: 0 });
        if (!ws[cell_address]) continue;
        ws[cell_address].s = {
            fill: { fgColor: { rgb: "1F4E78" } },
            font: { bold: true, color: { rgb: "FFFFFF" } }
        };
    }

    XLSX.utils.book_append_sheet(wb, ws, "Liquidaciones");
    XLSX.writeFile(wb, "liquidaciones_filtradas.xlsx");
}
</script>
@endsection
