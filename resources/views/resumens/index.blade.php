@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('TODAS LOS RESUMENES DE ADELANTOS REGISTRADOS') }}
                    
                    <a class="btn btn-sm btn-secondary" href="{{ route('resumens.create') }}">
                        {{ __('CREAR NUEVO RESUMEN') }}
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('ID') }}</th>
                                <th scope="col">{{ __('FECHA REGISTRO') }}</th>
                                <th scope="col">{{ __('FECHA CREACIÓN') }}</th>
                                <th scope="col">{{ __('DATOS CLIENTE') }}</th>
                                <th scope="col">{{ __('FACTURAS')}}</th>
                                <th scope="col">{{ __('CREADO POR') }}</th>
                                <th scope="col">{{ __('ACCIÓN') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($resumens as $resumen)
                            <tr>
                                <td>{{ $resumen->id }}</td>
                                <td>{{ $resumen->fecha_resumen }}</td>
                                <td>{{ $resumen->created_at }}</td>
                                <td>{{ $resumen->cliente->datos_cliente }}</td>
                                <td>
            @foreach ($resumen->adelantos as $adelanto)
                {{ $adelanto->nrofactura }}<br>
            @endforeach
        </td>
                                <td>
                                    @if ($resumen->user)
                                        {{ $resumen->user->name }}
                                    @else
                                        {{ __('Usuario desconocido') }}
                                    @endif
                                </td>
                                
                               
                                <td>
                                    <a href="{{ route('resumens.show', $resumen->id) }}" class="btn btn-secondary btn-sm">
                                        {{ __('VER') }}
                                    </a>
                                    <!-- Agregar formulario para eliminar 
                                    <form action="{{ route('resumens.destroy', $resumen->id) }}" method="POST" class="eliminar-registro d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            {{ __('ELIMINAR') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>-->
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    {{ __('No hay datos disponibles') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item {{ $resumens->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $resumens->previousPageUrl() }}">
                                    {{ __('Anterior') }}
                                </a>
                            </li>
                            @for ($i = 1; $i <= $resumens->lastPage(); $i++)
                                <li class="page-item {{ $resumens->currentPage() == $i ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $resumens->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ $resumens->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $resumens->nextPageUrl() }}">
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
    @if(session('eliminar-resumen') == 'Resumen eliminado con éxito.')
        Swal.fire('Resumen', 'eliminado exitosamente.', 'success')
    @endif
    @if(session('crear-resumen') == 'Resumen creado con éxito.')
        Swal.fire('Resumen', 'creado exitosamente.', 'success')
    @endif
    @if(session('editar-resumen') == 'Resumen actualizado con éxito.')
        Swal.fire('Resumen', 'actualizado exitosamente.', 'success')
    @endif

    $('.eliminar-resumen').submit(function(e){
        e.preventDefault();
        Swal.fire({
            title: '¿Eliminar resumen?',
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
