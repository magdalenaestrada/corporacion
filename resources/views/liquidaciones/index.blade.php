
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                     <div class="text-center">
                        {{ __('TODAS LAS OPERACIONES REGISTRADAS') }}
                    </div>
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="mb-3 d-flex gap-3">
                            <span class="badge bg-success fs-6">CIERRE: {{ $totalCierre }}</span>
                            <span class="badge bg-warning text-dark fs-6">PROVISIONAL: {{ $totalProvisional }}</span>
                            
                            <span class="badge bg-danger fs-6">SIN CIERRE: {{ $totalSinCierre }}</span>

                        </div>
                       
                        <!-- Modal Ranking 👑 -->
<div class="modal fade" id="modalRanking" tabindex="-1" aria-labelledby="rankingLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content ranking-modal shadow-lg">
            <div class="modal-header bg-dark text-white border-0">
                <h5 class="modal-title" id="rankingLabel">🏅 Ranking de Liquidadores</h5>
                <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body bg-dark text-white">
                <div class="d-flex justify-content-around align-items-end gap-3 flex-wrap"
                     style="min-height: 240px;">
                    @php $max = $conteoCierres->max('count'); @endphp

                    @foreach ($conteoCierres->sortByDesc('count')->take(5) as $user)
                        @php
                            $altura = intval(($user['count'] / $max) * 180); // px
                            $rank   = $loop->index + 1;                     // 1-5
                        @endphp

                        <div class="bar-wrapper rank-{{ $rank }}">
                            {{-- etiqueta medalla --}}
                            <span class="badge rank-badge">{{ $rank }}</span>

                            {{-- barra --}}
                            <div class="bar" style="height: {{ $altura }}px;"></div>

                            {{-- nombre / cierres --}}
                            <div class="meta">
                                <div class="name" title="{{ $user['name'] }}">{{ $user['name'] }}</div>
                                <div class="count">{{ $user['count'] }} cierres</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="modal-footer bg-dark border-0">
                <button type="button" class="btn btn-outline-light btn-sm"
                        data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<style>
/* Modal look & feel */
.ranking-modal { border-radius: 1rem; overflow: hidden; }

/* Wrapper de cada barra */
.bar-wrapper {
    width: 100px;
    position: relative;
    text-align: center;
}
.bar-wrapper .bar {
    width: 100%;
    border-radius: .5rem .5rem 0 0;
    transition: transform .3s ease, opacity .3s ease;
}
.bar-wrapper:hover .bar { transform: translateY(-4px); }

/* Nombres y números */
.bar-wrapper .meta .name  { font-size: .75rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.bar-wrapper .meta .count { font-size: .75rem; color: #1dd2d2; }

/* Medallas */
.rank-badge {
    position: absolute;
    top: -1.8rem;
    left: 50%;
    transform: translateX(-50%);
    font-size: .8rem;
    padding: .25rem .5rem;
    border-radius: 1rem;
    color: #000;
    font-weight: 700;
}

/* Colores gradientes top-3 + barras normales */
.rank-1 .bar { background: linear-gradient(180deg,#ffec54 0%,#d4a400 100%); }
.rank-2 .bar { background: linear-gradient(180deg,#d9d9d9 0%,#9e9e9e 100%); }
.rank-3 .bar { background: linear-gradient(180deg,#d9995f 0%,#8b5a2b 100%); }
.rank-4 .bar,
.rank-5 .bar { background:#0d6efd; }

.rank-1 .rank-badge { background:#ffec54; }
.rank-2 .rank-badge { background:#d9d9d9; }
.rank-3 .rank-badge { background:#d9995f; }
.rank-4 .rank-badge,
.rank-5 .rank-badge { background:#0d6efd; color:#fff; }
</style>
                       
                        <a class="btn btn-sm btn-secondary" href="{{ route('liquidaciones.create') }}">
                            {{ __('CREAR NUEVO LIQUIDACIONES') }}
                        </a>
                    </div>
                    
                    <div class="card-body">
                        <form method="GET" action="{{ route('liquidaciones.index') }}" class="mb-3">
    <div class="row g-2 align-items-center">
        <div class="col-md-5">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar por muestra, cliente, peso o lote">
        </div>  

        <div class="col-md-2">
            <select name="estado" class="form-select">
                <option value="">🔁 Todos los estados</option>
                <option value="CIERRE" {{ request('estado') == 'CIERRE' ? 'selected' : '' }}>✅ Cierre</option>
                <option value="PROVISIONAL" {{ request('estado') == 'PROVISIONAL' ? 'selected' : '' }}>🟡 Provisional</option>
                <option value="SIN CIERRE" {{ request('estado') == 'SIN CIERRE' ? 'selected' : '' }}>
                    🚫 Sin estado asignado
                </option>
            </select>
        </div>

        <div class="col-md-2">
            <select name="producto" class="form-select">
                <option value="">📦 Todos los productos</option>
                @foreach(['CONCENTRADO', 'BLENDING', 'POLVEADO', 'MOLIDO', 'FALCON', 'CHANCADO', 'RELAVE', 'MARTILLADO', 'GRANEL', 'SOBRANTE'] as $p)
                    <option value="{{ $p }}" {{ request('producto') == $p ? 'selected' : '' }}>{{ $p }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-1 d-flex flex-column">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="filtroOcultarClientes" checked>
                <label class="form-check-label" for="filtroOcultarClientes">
                    Ocultar clientes especiales
                </label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="d-flex gap-2">
                <button class="btn btn-secondary flex-fill" type="submit">{{ __('Buscar') }}</button>
                <button type="button" class="btn btn-info flex-fill" data-bs-toggle="modal" data-bs-target="#modalRanking">
                    📊 Ver Ranking
                </button>
            </div>
        </div>
    </div>
</form>
                       
                        <table class="table table table-hover text-center mb-0">
                            @if (count($liquidaciones) > 0)
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('ID') }}</th>
                                        <th scope="col">{{ __('MUESTRA') }}</th>
                                        <th scope="col">{{ __('CLIENTE') }}</th>
                                        <th scope="col">{{ __('EMPRESA') }}</th>
                                        <th scope="col">{{ __('LOTE') }}</th>
                                        <th scope="col">{{ __('PESO') }}</th>
                                        <th scope="col">{{ __('PRODUCTO') }}</th>
                                        <th scope="col">{{ __('ESTADO') }}</th>
                                        <th scope="col">{{ __('TICKET') }}</th>
                                        <th scope="col">{{ __('TOTAL') }}</th>
                                        <th scope="col">{{ __('NOTAS') }}</th>
                                        <th scope="col">{{ __('CREADO POR') }}</th>
                                        <th scope="col">{{ __('CIERRE FINAL') }}</th>
                                        <th scope="col">{{ __('ACCIONES') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($liquidaciones as $liquidacion)
                                    <tr class="@if(in_array(strtoupper($liquidacion->cliente->datos_cliente), ['BLENDING', 'CHAVEZ CORNEJO JURGEN LUIS', 'INNOVA CORPORATIVO S.A.'])) fila-cliente-oculta @endif">

                                        <td>{{ $liquidacion->id }}</td>
                                        <td>{{ $liquidacion->muestra->codigo }}</td>
                                        <td>{{ $liquidacion->cliente->datos_cliente }}</td>
                                        <td>{{ $liquidacion->cliente->razon_social }}</td>
                                        <td>{{ $liquidacion->lote }}</td>
                                        <td>{{ $liquidacion->peso }}</td>
                                        <td>{{ $liquidacion->producto }}</td>
                                  <td>
                                    <span class="badge 
                                        {{ $liquidacion->estado=='CIERRE' ? 'bg-success' : 
                                        ($liquidacion->estado=='PROVISIONAL' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                        {{ $liquidacion->estado ?? 'SIN CIERRE' }}
                                    </span>
                                </td>
                                        <td>{{ $liquidacion->NroSalida }}</td>
                                        <td>{{ $liquidacion->total }} </td>
                                        <td>{{ $liquidacion->comentario }}</td>
                                        <td>{{ $liquidacion->creator->name ?? 'N/A' }} ({{ $liquidacion->created_at->format('d/m/Y - H:i:s') }})</td>
                                        <td>{{ $liquidacion->lastEditor->name ?? 'N/A'}} ({{ $liquidacion->updated_at->format('d/m/Y - H:i:s') }})</td> 
                                       
                                        
                                        <td>
                                            <a href="{{ route('liquidaciones.show', $liquidacion->id) }}" class="btn btn-secondary btn-sm">{{ __('VER') }}</a>
                                            
                                            @if ($liquidacion->estado !== 'CIERRE' && $liquidacion->estado !== 'PROVISIONAL')
                                                <form action="{{ route('duplicate', $liquidacion->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">{{ __('CIERRE') }}</button>
                                                </form>
                                            @endif
                                            @can('update', $liquidacion)
                                            <a href="{{ route('liquidaciones.edit', parameters: $liquidacion->id) }}" class="btn btn-warning btn-sm">{{ __('EDITAR') }}</a>
                                            @endcan
                                            <a href="{{ route('liquidaciones.print', $liquidacion->id) }}" class="btn btn-primary btn-sm">{{ __('IMPRIMIR') }}</a>
                                            <form action="{{ route('liquidaciones.destroy', $liquidacion->id) }}" method="POST" style="display:inline;" class="form-eliminar">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">{{ __('ELIMINAR') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            @else
                                <tr>
                                    <td colspan="10" class="text-center text-muted">{{ __('No hay datos disponibles') }}</td>
                                </tr>
                            @endif
                        </table>

                     <div class="overflow-auto">
    <nav aria-label="Page navigation example">
        <ul class="pagination flex-nowrap">
            <li class="page-item {{ $liquidaciones->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $liquidaciones->previousPageUrl() }}">{{ __('Anterior') }}</a>
            </li>

            @for ($i = 1; $i <= $liquidaciones->lastPage(); $i++)
                <li class="page-item {{ $liquidaciones->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ $liquidaciones->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            <li class="page-item {{ $liquidaciones->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $liquidaciones->nextPageUrl() }}">{{ __('Siguiente') }}</a>
            </li>
        </ul>
    </nav>
</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <style>
    .overflow-auto {
        overflow-x: auto;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
    }
    .pagination {
        flex-wrap: nowrap;
    }
    .pagination .page-link {
        font-size: 0.85rem;
        padding: 0.3rem 0.6rem;
    }
    thead th{
    position: sticky;
    top: 0;
    z-index: 1;
    background: #fff; /* o #f8f9fa si usas la clase table-light */
}
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const eliminarForms = document.querySelectorAll('.form-eliminar');

        eliminarForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); // Prevenir envío inmediato

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡Esta acción no se puede deshacer!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Enviar formulario si confirma
                    }
                });
            });
        });
    });
</script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form[id^="duplicate-form-"]').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    
                    var button = this.querySelector('button[type="submit"]');
                    button.style.display = 'none';

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', this.action, true);
                    xhr.setRequestHeader('X-CSRF-TOKEN', this.querySelector('input[name="_token"]').value);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    
                    xhr.onload = function() {
                        if (xhr.status >= 200 && xhr.status < 300) {
                            var response = JSON.parse(xhr.responseText);
                            alert(response.success ? 'Registro duplicado exitosamente!' : 'Error: ' + response.error);
                        } else {
                            alert('Error en la solicitud: ' + xhr.statusText);
                        }
                        button.style.display = 'inline-block';
                    };
                    
                    xhr.send(new URLSearchParams(new FormData(this)).toString());
                });
            });
        });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkbox = document.getElementById('filtroOcultarClientes');

        function aplicarFiltroClientes() {
            const ocultar = checkbox.checked;
            document.querySelectorAll('.fila-cliente-oculta').forEach(row => {
                row.style.display = ocultar ? 'none' : '';
            });

            // Guardar preferencia en localStorage
            localStorage.setItem('ocultarClientesEspeciales', ocultar ? '1' : '0');
        }

        // Restaurar preferencia al cargar
        const savedPref = localStorage.getItem('ocultarClientesEspeciales');
        if (savedPref !== null) {
            checkbox.checked = savedPref === '1';
        }

        aplicarFiltroClientes(); // aplicar al cargar

        checkbox.addEventListener('change', aplicarFiltroClientes);
    });
</script>

    @endpush
 
@endsection