@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        {{ __('TODAS LOS REQUERIMIENTOS REGISTRADOS') }}
                        
                        <a class="btn btn-sm btn-secondary" href="{{ route('requerimientos.create') }}">
                            {{ __('CREAR NUEVAS CONDICIONES DEL CLIENTE') }}
                        </a>
                        <form method="GET" action="{{ route('requerimientos.index') }}">
                            <div class="input-group mb-3">
                                <input type="text" name="query" class="form-control" placeholder="Ingrese valor a buscar" value="{{ request()->input('query') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            @if (count($requerimientos) > 0)
                            <thead>
                                <tr>
                                    <th scope="col">
                                        {{ __('ID') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('FECHA CREACION') }}
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
                                        {{ __('ACCION') }}
                                    </th>

                            </thead>
                            <tbody>
                                @foreach ($requerimientos as $requerimiento)
                                    <tr>
                                        <td scope="row">
                                            {{ $requerimiento->id }}
                                        </td>
                                        <td>
                                            {{ ($requerimiento->created_at)->format('d/m/Y - H:i:s') }}
                                        </td>   
                                        <td scope="row">
                                            {{ $requerimiento->cliente->documento_cliente}}
                                        </td>
                                        <td scope="row">
                                            {{ $requerimiento->cliente->datos_cliente}}
                                        </td>
                                        <td scope="row">
                                            {{ $requerimiento->cliente->ruc_empresa }}
                                        </td>
                                        <td scope="row">
                                            {{ $requerimiento->cliente->razon_social }}
                                        </td>
                                        <td>
                                            <a href="{{ route('requerimientos.show', $requerimiento->id) }}" class="btn btn-secondary btn-sm">
                                                {{ __('VER') }}
                                            </a>
                                            <a href="{{ route('requerimientos.edit', $requerimiento->id) }}" class="btn btn-warning btn-sm">
                                                {{ __('EDITAR') }}
                                            </a>
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
                                <li class="page-item {{ $requerimientos->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $requerimientos->previousPageUrl() }}">
                                        {{ __('Anterior') }}
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $requerimientos->lastPage(); $i++)
                                    <li class="page-item {{ $requerimientos->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $requerimientos->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ $requerimientos->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $requerimientos->nextPageUrl() }}">
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