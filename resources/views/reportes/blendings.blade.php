    @extends('layouts.app')

    @push('styles')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <style>
            html, body {
                font-family: 'Arial';
                background: linear-gradient(to bottom right, #202d3f, #233d60);
                height: 100%;
            }
            h1 {
                text-align: center;
                color: white;
                margin-top: 20px;
            }

            .table-wrapper {
                max-width: 98%;
                margin: auto;
                overflow-x: auto;
                max-height: 70vh;
                background-color: #fff;
                border-radius: 10px;
                padding: 10px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th, td {
                border: 1px solid #dee2e6;
                padding: 6px;
                text-align: center;
                font-size: 13px;
            }

            thead th {
                background-color: #e9ecef;
                position: sticky;
                top: 0;
            }

            tr:hover {
                background-color: #e2f0ff;
                transition: background-color 0.2s ease;
            }

            #contadorRegistros, #pesoTotal {
                text-align: center;
                color: white;
                margin: 10px 0;
                font-weight: bold;
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

            .lista-oro {
                background-color: #fff70033; /* amarillo suave */
            }
            .lista-plata {
                background-color: #c2f3ff; /* celeste */
            }
            .lista-cobre {
                background-color: #d4f4d1; /* verde claro */
            }
            .estado-activo {
                color: #28a745; /* verde */
                font-weight: bold;
            }
            .estado-inactivo {
                color: #dc3545; /* rojo */
                font-weight: bold;
            }
            .filtro-input {
                padding: 6px 12px;
                font-size: 13px;
                border: 1px solid #ced4da;
                border-radius: 6px;
                background-color: white;
                box-shadow: 0 1px 2px rgba(0,0,0,0.05);
                min-width: 160px;
            }
            .filtro-input:focus {
                outline: none;
                border-color: #5b9bd5;
                box-shadow: 0 0 0 2px rgba(91, 155, 213, 0.25);
            }
        </style>
    @endpush

    @section('content')
        <div class="container-fluid">
            <h1>REPORTE DE BLENDINGS</h1>
            <div id="contadorRegistros">Total de blendings: {{ $totalRegistros }}</div>
            <div id="pesoTotal">Peso Total de Blendings: {{ number_format($pesoTotalBlending, 3) }}</div>

            <!-- Leyenda de colores para listas -->
           
            <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between mb-3 px-3">
                <div class="d-flex gap-2 flex-wrap">
                    <input type="text" id="buscadorGlobalBlending" class="filtro-input" placeholder="🔍 Buscar...">
                    <input type="text" id="rangoFechasBlending" class="filtro-input" placeholder="📅 Fecha creación" readonly>
                    <select id="filtroLista" class="filtro-input">
                        <option value="">Todas las listas</option>
                        <option value="oro">ORO</option>
                        <option value="plata">PLATA</option>
                        <option value="cobre">COBRE</option>
                    </select>
                    <select id="filtroEstado" class="filtro-input">
                        <option value="">Todos los estados</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                   
                </div>
            <div>
                <form id="formExportarBlending" action="{{ route('reportes.blendings.exportar') }}" method="GET" style="display: inline;">
                    <input type="hidden" name="lista" id="inputFiltroLista">
                    <input type="hidden" name="estado" id="inputFiltroEstado">
                    <input type="hidden" name="fecha" id="inputFiltroFecha">
                    <input type="hidden" name="busqueda" id="inputFiltroBusqueda">
                    <button type="submit" class="btn-excel">
                        <i class="fas fa-file-excel"></i> Exportar Excel
                    </button>
                </form>
        </div>
                <div class="d-flex justify-content-center gap-4 flex-wrap mb-3" style="font-size: 14px;">
                    <span style="display: flex; align-items: center;">
                        <span style="width: 14px; height: 14px; background-color: #fff700; display: inline-block; margin-right: 6px; border-radius: 3px;"></span>
                        <strong style="color: #d4aa00;">Oro</strong>
                    </span>
                    <span style="display: flex; align-items: center;">
                        <span style="width: 14px; height: 14px; background-color: #c2f3ff; display: inline-block; margin-right: 6px; border-radius: 3px;"></span>
                        <strong style="color: #00a6c7;">Plata</strong>
                    </span>
                    <span style="display: flex; align-items: center;">
                        <span style="width: 14px; height: 14px; background-color: #d4f4d1; display: inline-block; margin-right: 6px; border-radius: 3px;"></span>
                        <strong style="color: #28a745;">Cobre</strong>
                    </span>
                </div>
            </div>
           
            <div class="table-wrapper">
                <table class="tabla-blendings">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Lista</th>
                            <th>Notas</th>
                            <th>Estado</th>
                            <th>Usuario</th>
                            <th>Creado</th>
                            <th>Ingresos Asociados</th>
                            <th>Peso Blending</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($blendings as $blending)
                                @php
                                $listaClase = match(strtolower(trim($blending->lista))) {
                                    'oro' => 'lista-oro',
                                    'plata' => 'lista-plata',
                                    'cobre' => 'lista-cobre',
                                    default => '',
                                };
                            @endphp
                                  <tr class="fila-blending {{ $listaClase }}">
                                <td>{{ $blending->id }}</td>
                                <td>{{ $blending->cod }}</td>
                                <td>{{ $blending->lista }}</td>
                                <td>{{ $blending->notas }}</td>
                                @php
                                $estadoClase = strtolower($blending->estado) === 'activo' ? 'estado-activo' : 'estado-inactivo';
                                @endphp
                                <td class="{{ $estadoClase }}">{{ ucfirst($blending->estado) }}</td>
                                <td>{{ $blending->user->name ?? 'N/A' }}</td>
                                <td>{{ $blending->created_at }}</td>
                                <td>
                                    <button class="toggle-ingresos btn btn-sm btn-outline-primary mb-1">
                                        Ver ingresos ({{ count($blending->ingresos) }})
                                    </button>
                                
                                    <div class="contenedor-ingresos" style="display: none; overflow-x: auto; max-height: 200px; background-color: #f9f9f9; border: 1px solid #dee2e6; border-radius: 6px; padding: 6px; margin-top: 5px;">
                                        <input type="text" class="buscador-ingresos filtro-input mb-2" placeholder="Buscar ingreso asociado...">
                                        <table class="tabla-ingresos-asociados" style="width: 100%; border-collapse: collapse; font-size: 12px;">
                                            <thead>
                                                <tr style="background-color: #e9ecef;">
                                                    <th style="padding: 4px; border: 1px solid #ccc;">Ticket</th>
                                                    <th style="padding: 4px; border: 1px solid #ccc;">RUC</th>
                                                    <th style="padding: 4px; border: 1px solid #ccc;">Razon Social</th>
                                                    <th style="padding: 4px; border: 1px solid #ccc;">Lote</th>
                                                    <th style="padding: 4px; border: 1px solid #ccc;">Procedencia</th>
                                                    <th style="padding: 4px; border: 1px solid #ccc;">Peso </th>
                                                   
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($blending->ingresos as $ingreso)
                                                    <tr>
                                                        <td style="padding: 4px; border: 1px solid #ccc;">{{ $ingreso->NroSalida }}</td>
                                                        <td style="padding: 4px; border: 1px solid #ccc;">{{ $ingreso->identificador }}</td>
                                                        <td style="padding: 4px; border: 1px solid #ccc;">{{ $ingreso->nom_iden }}</td>
                                                        <td style="padding: 4px; border: 1px solid #ccc;">{{ $ingreso->ref_lote }}</td>
                                                        <td style="padding: 4px; border: 1px solid #ccc;">{{ $ingreso->procedencia }}</td>
                                                        <td style="padding: 4px; border: 1px solid #ccc;">{{ number_format($ingreso->peso_total, 3) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </td>                                
                                @php
                                $pesoNumerico = number_format($blending->pesoblending, 3, '.', '');
                                $pesoVisual = number_format($blending->pesoblending, 3, ',', '.');
                            @endphp
                            <td data-peso="{{ $pesoNumerico }}">{{ $pesoVisual }}</td>

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
        document.getElementById("formExportarBlending").addEventListener("submit", function(e) {
    document.getElementById("inputFiltroLista").value = document.getElementById("filtroLista").value;
    document.getElementById("inputFiltroEstado").value = document.getElementById("filtroEstado").value;
    document.getElementById("inputFiltroFecha").value = document.getElementById("rangoFechasBlending").value;
    document.getElementById("inputFiltroBusqueda").value = document.getElementById("buscadorGlobalBlending").value;
});
        document.addEventListener('DOMContentLoaded', function () {
            // Inicializa el selector de rango de fechas
            flatpickr("#rangoFechasBlending", {
                mode: "range",
                dateFormat: "Y-m-d",
                locale: "es",
                onChange: filtrarBlendings
            });
    
            // Escucha cambios en los filtros
            document.getElementById('buscadorGlobalBlending').addEventListener('input', filtrarBlendings);
            document.getElementById('filtroLista').addEventListener('change', filtrarBlendings);
            document.getElementById('filtroEstado').addEventListener('change', filtrarBlendings);
    
            // Ejecuta filtrado al iniciar
            filtrarBlendings();
            activarBotonesIngresos();
            activarBuscadoresInternos();
        });
    
        function filtrarBlendings() {
    const filtroEstado = document.getElementById("filtroEstado").value.toLowerCase();
    const filtroLista = document.getElementById("filtroLista").value.toLowerCase();
    const search = document.getElementById("buscadorGlobalBlending").value.toLowerCase();
    const fechas = document.getElementById("rangoFechasBlending").value.split(" a ");
    const desde = fechas[0] ? new Date(fechas[0]) : null;
    const hasta = fechas[1] ? new Date(fechas[1]) : null;

    const filas = document.querySelectorAll(".tabla-blendings tbody tr.fila-blending");
    let total = 0;
    let pesoFiltrado = 0;

    filas.forEach(fila => {
    const cells = fila.querySelectorAll("td");

    const textoFila = [...cells].map(td => td.textContent.toLowerCase()).join(" ");
    const fechaCreacion = new Date(cells[6]?.innerText.trim());
    const estadoTexto = cells[4]?.innerText.trim().toLowerCase();
    const listaTexto = cells[2]?.innerText.trim().toLowerCase();
    const pesoCell = fila.querySelector('[data-peso]');
    const pesoTexto = pesoCell ? pesoCell.getAttribute('data-peso') : "0";

    let visible = true;

    if (search && !textoFila.includes(search)) visible = false;
    if (desde && hasta && (fechaCreacion < desde || fechaCreacion > hasta)) visible = false;
    if (filtroLista && listaTexto !== filtroLista) visible = false;
    if (filtroEstado && estadoTexto !== filtroEstado) visible = false;

    fila.style.display = visible ? "" : "none";

    if (visible) {
        total++;
        const peso = parseFloat(pesoTexto);  // ✅ Esto ahora funciona bien con 123.456
        if (!isNaN(peso)) {
            pesoFiltrado += peso;
            console.log("Suma parcial →", pesoFiltrado);
        } }
    });

    document.getElementById("contadorRegistros").textContent = `Total de blendings: ${total}`;
    document.getElementById("pesoTotal").textContent = `Peso Total Filtrado: ${pesoFiltrado.toFixed(3)}`;
}
    
        function activarBotonesIngresos() {
            document.querySelectorAll('.toggle-ingresos').forEach(btn => {
                btn.addEventListener('click', function () {
                    const contenedor = this.nextElementSibling;
                    const total = this.textContent.match(/\((\d+)\)/)?.[1] || '';
                    if (contenedor.style.display === 'none' || contenedor.style.display === '') {
                        contenedor.style.display = 'block';
                        this.textContent = 'Ocultar ingresos';
                    } else {
                        contenedor.style.display = 'none';
                        this.textContent = `Ver ingresos (${total})`;
                    }
                });
            });
        }
    
        function activarBuscadoresInternos() {
            document.querySelectorAll('.buscador-ingresos').forEach(input => {
                input.addEventListener('input', function () {
                    const texto = this.value.toLowerCase();
                    const tabla = this.nextElementSibling;
                    tabla.querySelectorAll('tbody tr').forEach(row => {
                        row.style.display = row.innerText.toLowerCase().includes(texto) ? '' : 'none';
                    });
                });
            });
        }
    </script>
    @endpush
    