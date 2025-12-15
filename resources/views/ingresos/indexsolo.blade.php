    @extends('layouts.app')

    @section('content')
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                               {{ __('INGRESOS - SOLO PRODUCTO CHANCADO') }}
                            </div>
                            <div class="text-center w-200">
                            
                                <span class="badge bg-info  text-black fs-10 p-2">
                                    {{ __('Peso Total: ') }} {{ number_format($pesoTotal, 3) }} 
                                </span>
                                <span class="badge bg-success text-black fs-10 p-2">
                                    {{ __('Peso Ingresados: ') }} {{ number_format($pesoIngresados, 3) }}
                                </span>
                                <span class="badge bg-warning fs-10 p-2 text-dark">
                                    {{ __('Peso Blending: ') }} {{ number_format($pesoBlending, 3) }}
                                </span>
                                <span class="badge bg-danger text-black fs-10 p-2">
                                    {{ __('Peso Despachado: ') }} {{ number_format($pesoDespachado, 3) }}
                                </span>
                                <span class="badge bg-white text-black fs-10 p-2">
                                    {{ __('Peso Retirado: ') }} {{ number_format($pesoRetirado, 3) }}
                                </span>
                                <span class="badge bg-primary text-black fs-10 p-2">
                                    {{ __('Peso en Stock: ') }} {{ number_format($pesoEnStock, 3) }}
                                </span>
                            </div>
                            <div class="btn-group">
                                <a class="btn btn-sm btn-secondary me-2" href="{{ route('ingresos.create') }}">
                                    {{ __('CREAR NUEVO INGRESO') }}
                                </a>
                                 <a class="btn btn-sm btn-danger me-2" href="{{ route('ingresos.index') }}">
                                    {{ __('VOLVER') }}
                                </a>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <!-- Formulario de búsqueda -->
                            <form method="GET" action="{{ route('ingresos.index') }}" class="mb-3">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="text" name="search" class="form-control" placeholder="Buscar..." value="{{ request()->get('search') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="fase" class="form-control">
                                            <option value="">{{ __('Filtrar por Fase') }}</option>
                                            @foreach ($fases as $fase)
                                                <option value="{{ $fase }}" {{ request()->get('fase') == $fase ? 'selected' : '' }}>
                                                    {{ ucfirst($fase) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary" type="submit">{{ __('Filtrar') }}</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Tabla de registros -->
                           <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0 align-middle tabla-chancado w-100">
                            <thead class="text-center">
                                <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>CÓDIGO</th>
                                    <th>DNI / RUC</th>
                                    <th>DATOS</th>
                                    <th>FECHA DE TICKET</th>
                                    <th>REGISTRADO</th>
                                    <th>REF. LOTE</th>
                                    <th>ESTADO</th>
                                    <th>PRODUCTO</th>
                                    <th>PESO TOTAL</th>
                                    <th>NRO TICKET</th>
                                    <th>LOTE</th>
                                    <th class="col-descripcion">DESCRIPCIÓN</th>
                                    <th class="col-creado">CREADO POR</th>
                                    <th class="col-acciones">ACCIONES</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ingresos as $index => $ingreso)
                                    <tr>
                                            <td>{{ ($ingresos->currentPage() - 1) * $ingresos->perPage() + $index + 1 }}</td>
                                            <td>{{ $ingreso->id }}</td>
                                            <td>{{ $ingreso->codigo }}</td>
                                            <td>{{ $ingreso->identificador }}</td>
                                            <td>{{ $ingreso->nom_iden }}</td>
                                            <td>{{ $ingreso->fecha_ingreso }}</td>
                                              @php
                                                $fechaIngreso = \Carbon\Carbon::parse($ingreso->fecha_ingreso);
                                                $fechaCreado = \Carbon\Carbon::parse($ingreso->created_at);
                                                $diferenciaHoras = $fechaCreado->diffInHours($fechaIngreso);
                                            @endphp
                                            <td class="{{ $diferenciaHoras > 24 ? 'bg-danger text-white' : '' }}">
                                                {{ $ingreso->created_at }}
                                            </td>
                                            <td>{{ $ingreso->ref_lote }}</td>
                                            <td>
                                                @php
                                                $faseClass = match(strtolower($ingreso->fase)) {
                                                    'ingresado' => 'bg-success',
                                                    'blending' => 'bg-warning text-dark',
                                                    'despachado' => 'bg-orange',
                                                    'retirado' => 'bg-lightgray text-dark',
                                                    default => 'bg-secondary'
                                                };
                                            @endphp
                                            
                                            <span class="badge {{ $faseClass }}">
                                                {{ ucfirst($ingreso->fase) }}
                                            </span>                        </td>
                                            <td>{{ $ingreso->estado }}</td>
                                            <td>{{ number_format($ingreso->peso_total, 3) }}</td>
                                            <td>{{ $ingreso->NroSalida }}</td>
                                            <td>{{ $ingreso->lote }}</td>
                                          <td class="col-descripcion">{{ $ingreso->descripcion }}</td>
                                            <td class="col-creado">{{ $ingreso->user ? $ingreso->user->name : 'Desconocido' }}</td>
                                            <td>
                                                <a href="{{ route('ingresos.show', $ingreso->id) }}" class="btn btn-secondary btn-sm">Ver</a>
                                                <a class="btn btn-primary btn-sm" href="{{ route('ingresos.imprimir', $ingreso->id) }}">Imprimir</a>
                                
                                                @if(strtolower($ingreso->fase) !== 'retirado')
                                                    <a href="{{ route('ingresos.edit', $ingreso->id) }}" class="btn btn-warning btn-sm btn-editar">Editar</a>
                                
                                                    <form action="{{ route('ingresos.destroy', $ingreso->id) }}" method="POST" class="d-inline eliminar-registro">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm btn-eliminar">Eliminar</button>
                                                    </form>
                                
                                                    <button type="button" class="btn btn-light  btn-sm retirar-btn" data-id="{{ $ingreso->id }}">Retirar</button>
                                                @else
                                                    <span class="badge bg-dark">Retirado</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                           </div>
                            <!-- Paginación centrada -->
                            <div class="d-flex justify-content-center mt-3">
                                <nav>
                                    <ul class="pagination">
                                        {{-- Botón "Anterior" --}}
                                        @if ($ingresos->onFirstPage())
                                            <li class="page-item disabled"><span class="page-link">« Anterior</span></li>
                                        @else
                                            <li class="page-item"><a class="page-link" href="{{ $ingresos->previousPageUrl() }}">« Anterior</a></li>
                                        @endif
                            
                                        {{-- Numeración de páginas --}}
                                        @for ($i = 1; $i <= $ingresos->lastPage(); $i++)
                                            <li class="page-item {{ $i == $ingresos->currentPage() ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $ingresos->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endfor
                            
                                        {{-- Botón "Siguiente" --}}
                                        @if ($ingresos->hasMorePages())
                                            <li class="page-item"><a class="page-link" href="{{ $ingresos->nextPageUrl() }}">Siguiente »</a></li>
                                        @else
                                            <li class="page-item disabled"><span class="page-link">Siguiente »</span></li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @push('styles')
        <style>
            .table-orange {
                background-color: #ffcccc !important; /* rojo suave */
            }
        
            .table-lightgray {
                background-color: #f8f9fa !important; /* gris muy clarito */
            }
        
            .bg-orange {
                background-color: #ff4d4d !important; /* rojo más intenso */
                color: white !important;
            }
        
            .bg-lightgray {
                background-color: #e6e6e6 !important; /* gris clarito */
                color: #333 !important;
            }
        </style>
        @endpush
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.retirar-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        const ingresoId = this.dataset.id;
                        const btn = this;
            
                        Swal.fire({
                            title: '¿Estás seguro?',
                            text: "Este ingreso será marcado como retirado.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Sí, retirar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                fetch("{{ url('/ingresos') }}/" + ingresoId + "/retirar", {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json'
                                    },
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        const parentTd = btn.closest('td');
                                        parentTd.querySelector('.btn-editar')?.classList.add('d-none');
                                        parentTd.querySelector('.btn-eliminar')?.classList.add('d-none');
            
                                        // Reemplaza el botón por una etiqueta
                                        btn.outerHTML = '<span class="badge bg-lightgray text-dark">Retirado</span>';
            
                                        Swal.fire(
                                            'Retirado',
                                            'El ingreso fue retirado correctamente.',
                                            'success'
                                        );
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire('Error', 'Ocurrió un error al retirar el ingreso.', 'error');
                                });
                            }
                        });
                    });
                });
            });
            </script>
<style>
    .tabla-chancado th,
    .tabla-chancado td {
        font-size: 0.72rem;
        padding: 0.3rem;
        vertical-align: middle;
        white-space: nowrap;
    }

    .tabla-chancado .col-descripcion,
    .tabla-chancado .col-creado {
        max-width: 130px;
        white-space: normal;
    }

    .tabla-chancado .col-acciones {
        min-width: 170px;
    }

    .tabla-chancado .btn {
        padding: 0.2rem 0.35rem;
        font-size: 0.7rem;
    }

    .tabla-chancado .badge {
        font-size: 0.7rem;
        padding: 0.3rem 0.5rem;
    }

    /* Asegura que no haya margen adicional horizontal */
    .container-fluid {
        overflow-x: hidden;
    }

    /* Elimina scroll horizontal forzado por tablas o contenedores */
    body {
        overflow-x: hidden;
    }
</style>

        @endpush
    @endsection
