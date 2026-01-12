@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Nuevo Estado Mineral</div>
        <div class="card-body">
            <form method="POST" action="{{ route('estados_mineral.store') }}">
                @csrf

                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" required>

                <div class="mt-3 text-end">
                    <button class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
