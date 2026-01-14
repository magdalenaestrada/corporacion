@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Editar Humedad #{{ $humedad->id }}</h5>
            <a href="{{ route('humedad.index') }}" class="btn btn-danger btn-sm">Volver</a>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                    </ul>
                </div>
            @endif

            @php
                // Total neto desde tu tabla pivot humedad_peso (modelo HumedadPeso)
                $totalAlfa   = (int) $humedad->pesos()->where('origen','A')->sum('neto');
                $totalKilate = (int) $humedad->pesos()->where('origen','K')->sum('neto');
                $totalGlobal = $totalAlfa + $totalKilate;
            @endphp

            <div class="text-center mb-3">
                <span class="badge bg-dark" style="font-size:14px;">
                    Total Neto ALFA: {{ number_format($totalAlfa, 0, '.', ',') }}
                </span>
                <span class="badge bg-dark" style="font-size:14px;">
                    Total Neto KILATE: {{ number_format($totalKilate, 0, '.', ',') }}
                </span>
                <span class="badge bg-primary" style="font-size:14px;">
                    TOTAL NETO: {{ number_format($totalGlobal, 0, '.', ',') }}
                </span>
            </div>

            <form action="{{ route('humedad.update', $humedad->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-2">
                    <div class="col-md-3">
                        <label class="text-muted">Mineral</label>
                        <select name="estado_mineral_id" class="form-control" required>
                            <option value="">Seleccione...</option>
                            @foreach($minerales as $m)
                                <option value="{{ $m->id }}" {{ old('estado_mineral_id', $humedad->estado_mineral_id)==$m->id?'selected':'' }}>
                                    {{ $m->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-5">
                        <label class="text-muted">Razón social</label>
                        <select name="cliente_id" class="form-control" required>
                            <option value="">Seleccione...</option>
                            @foreach($clientes as $c)
                                <option value="{{ $c->id }}" {{ old('cliente_id', $humedad->cliente_id)==$c->id?'selected':'' }}>
                                    {{ $c->razon_social }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="text-muted">Fecha recepción</label>
                        <input type="date" name="fecha_recepcion" class="form-control"
                               value="{{ old('fecha_recepcion', optional($humedad->fecha_recepcion)->format('Y-m-d')) }}">
                    </div>

                    <div class="col-md-2">
                        <label class="text-muted">Fecha emisión</label>
                        <input type="date" name="fecha_emision" class="form-control"
                               value="{{ old('fecha_emision', optional($humedad->fecha_emision)->format('Y-m-d')) }}">
                    </div>
                </div>

                <div class="row g-2 mt-2">
                    <div class="col-md-2">
                        <label class="text-muted">Periodo inicio</label>
                        <input type="date" name="periodo_inicio" class="form-control"
                               value="{{ old('periodo_inicio', optional($humedad->periodo_inicio)->format('Y-m-d')) }}">
                    </div>

                    <div class="col-md-2">
                        <label class="text-muted">Periodo fin</label>
                        <input type="date" name="periodo_fin" class="form-control"
                               value="{{ old('periodo_fin', optional($humedad->periodo_fin)->format('Y-m-d')) }}">
                    </div>

                    <div class="col-md-2">
                        <label class="text-muted">Humedad</label>
                        <input type="number" step="0.01" name="humedad" class="form-control"
                               value="{{ old('humedad', $humedad->humedad) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted">Observaciones</label>
                        <input type="text" name="observaciones" class="form-control" maxlength="500"
                               value="{{ old('observaciones', $humedad->observaciones) }}">
                    </div>
                </div>

                <div class="text-center mt-3">
                    <button class="btn btn-primary">Actualizar Humedad</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
