@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        {{ __('TODAS LAS MUESTRAS REGISTRADAS') }}
                        <a class="btn btn-sm btn-secondary" href="{{ route('muestras.create') }}">
                            {{ __('CREAR NUEVA MUESTRA') }}
                        </a>
                        <form method="GET" action="{{ route('muestras.index') }}" class="mb-4">
                            <div class="form-row align-items-end">
                                <div class="col">
                                    <div class="input-group">
                                        <input type="text" name="codigo" class="form-control" placeholder="Buscar por codigo..." value="{{ request('codigo') }}">
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
                            @if (count($muestras) > 0)
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('ID') }}</th>
                                    <th scope="col">{{ __('CODIGO') }}</th>
                                    <th scope="col">{{ __('FECHA CREACION') }}</th>
                                    <th scope="col">{{ __('COBRE') }}</th>
                                    <th scope="col">{{ __('PLATA') }}</th>
                                    <th scope="col">{{ __('ORO') }}</th>
                                    <th scope="col">{{ __('CREADO POR:') }}</th>
                                    <th scope="col">{{ __('ESTADO:') }}</th>
                                    <th scope="col">{{ __('ACCION') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($muestras as $muestra)
                                    <tr>
                                        <td>{{ $muestra->id }}</td>
                                        <td>{{ $muestra->codigo }}</td>
                                        <td>{{ ($muestra->created_at)->format('d/m/Y - H:i:s') }}</td>   
                                        <td>{{ $muestra->cu }}</td>
                                        <td>{{ $muestra->ag }}</td>
                                        <td>{{ $muestra->au }}</td>
                                        <td>{{ $muestra->user->name }}</td>
                                        <td>{{ $muestra->est }}</td>
                                        <td>
                                            <a href="{{ route('muestras.show', $muestra->id) }}" class="btn btn-secondary btn-sm">{{ __('VER') }}</a>
                                            <a href="{{ route('muestras.edit', $muestra->id) }}" class="btn btn-warning btn-sm">{{ __('EDITAR') }}</a>
                                            <form class="eliminar-muestras" action="{{ route('muestras.destroy', $muestra->id) }}" method="POST" style="display: inline;">
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

                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item {{ $muestras->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $muestras->previousPageUrl() }}">{{ __('Anterior') }}</a>
                            </li>
                            @for ($i = 1; $i <= $muestras->lastPage(); $i++)
                                <li class="page-item {{ $muestras->currentPage() == $i ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $muestras->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ $muestras->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $muestras->nextPageUrl() }}">{{ __('Siguiente') }}</a>
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
            @if(session('eliminar-registro'))
                Swal.fire('Registro', 'eliminado exitosamente.', 'success');
            @endif
            @if(session('error'))
                Swal.fire({
                    title: 'Error',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            @endif
        </script>
    @endpush
@endsection
