@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h6>Estados de Mineral</h6>
            <a href="{{ route('estados_mineral.create') }}" class="btn btn-primary btn-sm">
                Nuevo Estado
            </a>
        </div>

        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Estado</th>
                        <th>Activo</th>
                        <th width="120">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($estados as $estado)
                        <tr>
                            <td>{{ $estado->id }}</td>
                            <td>{{ $estado->nombre }}</td>
                            <td>
                                <span class="badge {{ $estado->activo ? 'bg-success' : 'bg-danger' }}">
                                    {{ $estado->activo ? 'SI' : 'NO' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('estados_mineral.edit', $estado) }}"
                                   class="btn btn-warning btn-sm">
                                   Editar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

      <div class="card-footer d-flex justify-content-center">
            {{ $estados->onEachSide(1)->links() }}
        </div>
    </div>
</div>
@endsection
