@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        {{ __('TODAS LAS OPERACIONES REGISTRADAS') }}
                        
                            <a class="btn btn-sm btn-secondary" href="{{ route('adelantos.create') }}">
                                {{ __('CREAR NUEVO ADELANTOS') }}
                            </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            @if (count($adelantos) > 0)
                            <thead>
                                <tr>
                                    <th scope="col">
                                        {{ __('ID') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('FECHA CREACION') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('FACTURA') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('CLIENTE') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('MONTO') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('ACCION') }}
                                    </th>

                            </thead>
                            <tbody>
                                @foreach ($adelantos as $adelanto)
                                <tr>
                                        <td scope="row">
                                            {{ $adelanto->id }}
                                        </td>
                                        <td>
                                            {{ ($adelanto->created_at)->format('d/m/Y - H:i:s') }}
                                        </td>   
                                        <td>
                                            {{ $adelanto->nrofactura}}
                                        </td>   
                                        <td scope="row">
                                            {{ $adelanto->cliente->datos_cliente }}
                                        </td>
                                        <td>
                                            {{ $adelanto->total}}
                                        </td>

                                        <td> 
                                            <a href="{{ route('adelantos.show', $adelanto->id) }}" class="btn btn-secondary btn-sm">
                                                {{ __('VER') }}
                                            </a>
                                           
                                            <a href="{{ route('adelantos.edit', $adelanto->id) }}" class="btn btn-warning btn-sm">
                                                {{ __('EDITAR') }}
                                            </a>

                                            <form class="eliminar-adelantos" action="{{ route('adelantos.destroy', $adelanto->id) }}" method="POST" style="display: inline;">
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
                                <li class="page-item {{ $adelantos->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $adelantos->previousPageUrl() }}">
                                        {{ __('Anterior') }}
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $adelantos->lastPage(); $i++)
                                    <li class="page-item {{ $adelantos->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $adelantos->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ $adelantos->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $adelantos->nextPageUrl() }}">
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