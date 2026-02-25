@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Editar Estado</div>
        <div class="card-body">
            <form method="POST" action="{{ route('estados_mineral.update', $estados_mineral) }}">
                @csrf
                @method('PUT')

                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control"
                       value="{{ $estados_mineral->nombre }}" required>

                <label class="mt-2">Activo</label>
                <select name="activo" class="form-control">
                    <option value="1" {{ $estados_mineral->activo ? 'selected' : '' }}>SI</option>
                    <option value="0" {{ !$estados_mineral->activo ? 'selected' : '' }}>NO</option>
                </select>

                <div class="mt-3 text-end">
                    <button class="btn btn-success">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
