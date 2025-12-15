@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        {{ __('TODAS LAS BLENDINGS REGISTRADAS') }}

                        <div class="btn-group">
                            <a class="btn btn-sm btn-secondary me-2" href="{{ route('blendings.create') }}">
                                {{ __('CREAR NUEVO BLENDINGS') }}
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Formulario de búsqueda -->
                        <div class="mb-3">
                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar por código, preparación, peso , usuario o nrosalida">
                        </div>

                        <div class="table-responsive">
                        <table class="table table-striped align-middle tabla-blendings" id="blendingsTable">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Fecha Creación') }}</th>
                                    <th>{{ __('Código') }}</th>
                                    <th>{{ __('Preparación') }}</th>
                                    <th>{{ __('Peso') }}</th>
                                    <th>{{ __('Nro Ticket') }}</th> <!-- Nueva columna -->
                                    <th>{{ __('Notas') }}</th>
                                    <th>{{ __('Creado por') }}</th>
                                    <th>{{ __('Estado') }}</th> <!-- Nueva columna -->
                                    <th>{{ __('Acciones') }}</th>
                                </tr>
                            </thead>                            
                            <tbody>
                                @forelse($blendings as $blending)
                                    <tr>
                                        <td>{{ $blending->id }}</td>
                                        <td>{{ $blending->created_at->format('d-m-Y') }}</td>
                                        <td>{{ $blending->cod }}</td>
                                        <td>{{ $blending->lista }}</td>
                                        <td>{{ $blending->pesoblending }}</td>
                                        <td>
                                            @forelse ($blending->ingresos as $ingreso)
                                                <span class="badge bg-secondary">{{ $ingreso->NroSalida }}</span>
                                            @empty
                                                <span class="text-muted">Sin tickets</span>
                                            @endforelse
                                        </td>
                            
                                        <td>{{ $blending->notas }}</td>
                                        <td>{{ $blending->user ? $blending->user->name : 'Desconocido' }}</td>
                                        <td>
                                            <span class="badge 
                                            @if($blending->estado == 'inactivo') bg-danger 
                                            @elseif($blending->estado == 'despachado') bg-secondary 
                                            @elseif($blending->estado == 'activo') bg-success 
                                            @else bg-primary @endif">
                                            {{ ucfirst($blending->estado) }}
                                        </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('blendings.show', $blending->id) }}" class="btn btn-secondary btn-sm">VER</a>
                                            <a href="{{ route('blendings.edit', $blending->id) }}" class="btn btn-warning btn-sm">EDITAR</a>
                            
                                            <!-- Mostrar el botón de DESPACHO solo si el estado no es 'inactivo' ni 'despachado' -->
                                            @if($blending->estado !== 'inactivo' && $blending->estado !== 'despachado')
                                                <a href="{{ route('despachos.create', $blending->id) }}" class="btn btn-info btn-sm">DESPACHO</a>
                                            @endif
                            
                                            <!-- Botón de eliminar con SweetAlert2 -->
                                           @if($blending->estado !== 'inactivo')
                                                <form action="{{ route('blendings.destroy', $blending->id) }}" method="POST" class="delete-form" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm delete-btn">ELIMINAR</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">{{ __('No hay blendings disponibles') }}</td>
                                    </tr>
                                @endforelse
  
                            </tbody>
                        </table>
                    </div>
                        <nav>
                            <ul class="pagination justify-content-center">
                                {{-- Botón "Anterior" --}}
                                @if ($blendings->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">« Anterior</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $blendings->previousPageUrl() }}">« Anterior</a></li>
                                @endif
                        
                                {{-- Mostrar solo algunas páginas para evitar una paginación muy larga --}}
                                @php
                                    $start = max(1, $blendings->currentPage() - 2);
                                    $end = min($blendings->lastPage(), $blendings->currentPage() + 2);
                                @endphp
                        
                                {{-- Primera página y puntos suspensivos si es necesario --}}
                                @if ($start > 1)
                                    <li class="page-item"><a class="page-link" href="{{ $blendings->url(1) }}">1</a></li>
                                    @if ($start > 2)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                @endif
                        
                                {{-- Numeración de páginas visible --}}
                                @for ($i = $start; $i <= $end; $i++)
                                    <li class="page-item {{ $i == $blendings->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $blendings->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                        
                                {{-- Última página y puntos suspensivos si es necesario --}}
                                @if ($end < $blendings->lastPage())
                                    @if ($end < $blendings->lastPage() - 1)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                    <li class="page-item"><a class="page-link" href="{{ $blendings->url($blendings->lastPage()) }}">{{ $blendings->lastPage() }}</a></li>
                                @endif
                        
                                {{-- Botón "Siguiente" --}}
                                @if ($blendings->hasMorePages())
                                    <li class="page-item"><a class="page-link" href="{{ $blendings->nextPageUrl() }}">Siguiente »</a></li>
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

    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script>
  document.addEventListener("DOMContentLoaded", function() {
    // Búsqueda en la tabla
    let searchInput = document.getElementById("searchInput");
    searchInput.addEventListener("keyup", function() {
      let filter = searchInput.value.toLowerCase();
      let rows = document.querySelectorAll("#blendingsTable tbody tr");

      rows.forEach(row => {
        let codigo = row.cells[2].textContent.toLowerCase();
        let preparacion = row.cells[3].textContent.toLowerCase();
        let pesoblending = row.cells[4].textContent.toLowerCase();
        let nroSalida = row.cells[5].textContent.toLowerCase();
        let usuario = row.cells[7].textContent.toLowerCase();

        if (codigo.includes(filter) || preparacion.includes(filter) || pesoblending.includes(filter) || usuario.includes(filter) || nroSalida.includes(filter)) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
      });
    });

    // Confirmación antes de eliminar (con fallback si SweetAlert no cargó)
    document.querySelectorAll(".delete-btn").forEach(button => {
      button.addEventListener("click", function(e) {
        e.preventDefault(); // evita que el submit se dispare de inmediato
        const form = this.closest(".delete-form");

        // Fallback si por alguna razón SweetAlert no está disponible
        if (typeof Swal === 'undefined') {
          if (confirm('¿Estás seguro? ¡Esta acción no se puede deshacer!')) {
            form.submit();
          }
          return;
        }

        Swal.fire({
          title: "¿Estás seguro?",
          text: "¡Esta acción no se puede deshacer!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#d33",
          cancelButtonColor: "#3085d6",
          confirmButtonText: "Sí, eliminar",
          cancelButtonText: "Cancelar"
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });
  });
</script>
@endpush


@endsection
