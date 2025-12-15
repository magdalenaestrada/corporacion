@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        {{ __('TODAS LAS OPERACIONES REGISTRADAS') }}
                        
                            <a class="btn btn-sm btn-secondary" href="{{ route('clientes.create') }}">
                                {{ __('CREAR NUEVO CLIENTE') }}
                            </a>
                            <form method="GET" action="{{ route('clientes.index') }}" class="mb-4">
                                <div class="form-row align-items-end">
                                    <div class="col">
                                        <div class="input-group">
                                            <input type="text" name="filtro" class="form-control" placeholder="Buscar" value="{{ request('filtro') }}">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary btn-sm">Buscar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            @if (count($clientes) > 0)
                            <thead>
                                <tr>
                                    <th scope="col">
                                        {{ __('ID') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('DNI') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('CLIENTE') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('RUC') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('RAZON SOCIAL') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('FECHA CREACION') }}
                                    </th>
                                    <th>
                                        {{ __('Acción') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientes as $cliente)
                                    <tr>
                                        <td scope="row">
                                            {{ $cliente->id }}
                                        </td>
                                        <td scope="row">
                                            {{ $cliente->documento_cliente }}
                                        </td>

                                        <td scope="row">
                                            {{ $cliente->datos_cliente }}
                                        </td>
                                        <td scope="row">
                                            {{ $cliente->ruc_empresa }}
                                        </td>

                                        <td scope="row">
                                            {{ $cliente->razon_social }}
                                        </td>                                                                                                
                                        <td scope="row">
                                            {{ ($cliente->created_at)->format('d/m/Y - H:i:s') }}
                                        </td>

                                        <td> 
                                            <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-secondary btn-sm">
                                                {{ __('VER') }}
                                            </a>
                                           
                                            <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning btn-sm">
                                                {{ __('EDITAR') }}
                                            </a>
                                            <form class="eliminar-clientes" action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este cliente?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    {{ __('ELIMINAR') }}
                                                </button>
                                            </form>
                                           
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            @else
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        {{ __('No hay datos disponibles') }} 
                                    </td>
                                </tr>
                            @endif
                        </table>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                <li class="page-item {{ $clientes->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $clientes->previousPageUrl() }}">
                                        {{ __('Anterior') }}
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $clientes->lastPage(); $i++)
                                    <li class="page-item {{ $clientes->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $clientes->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ $clientes->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $clientes->nextPageUrl() }}">
                                        {{ __('Siguiente') }}
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            @if(session('eliminar-registro') == 'Registro eliminado con éxito.')
                Swal.fire('Registro', 'eliminado exitosamente.', 'success')
            @endif
            @if(session('crear-registro') == 'Registro creado con éxito.')
                Swal.fire('Registro', 'creado exitosamente.', 'success')
            @endif
            @if(session('editar-registro') == 'Registro actualizado con éxito.')
                Swal.fire('Registro', 'actualizado exitosamente.', 'success')
            @endif
        </script>
        <script>
            $('.eliminar-registro').submit(function(e){
                e.preventDefault();
                Swal.fire({
                    title: '¿Eliminar registro?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, continuar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if(result.isConfirmed){
                        this.submit();
                    }
                })
            });
        </script>
    @endpush
@endsection