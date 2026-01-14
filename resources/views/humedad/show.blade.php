@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detalle Humedad #{{ $humedad->id }}</h5>
            <a href="{{ route('humedad.index') }}" class="btn btn-danger btn-sm">Volver</a>
        </div>

        <div class="card-body">
            <div class="row g-2">
                <div class="col-md-3"><b>Mineral:</b> {{ $humedad->mineral->nombre ?? '' }}</div>
                <div class="col-md-5"><b>Razón social:</b> {{ $humedad->cliente->razon_social ?? '' }}</div>
                <div class="col-md-2"><b>Recepción:</b> {{ $humedad->fecha_recepcion }}</div>
                <div class="col-md-2"><b>Emisión:</b> {{ $humedad->fecha_emision }}</div>
                <div class="col-md-4"><b>Periodo:</b> {{ $humedad->periodo_inicio }} AL {{ $humedad->periodo_fin }}</div>
                <div class="col-md-2"><b>Humedad:</b> {{ $humedad->humedad }}</div>
                <div class="col-md-12"><b>Obs:</b> {{ $humedad->observaciones }}</div>
            </div>

            <hr>

            <h6>Tickets asociados</h6>
            <div class="mb-2">
                @foreach($humedad->pesos as $p)
                    <span class="badge bg-secondary me-1">{{ $p->nro_salida }} - {{ $p->origen }}</span>
                @endforeach
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h6>ALFA</h6>
                    <ul>
                        @forelse($alfaTickets as $t)
                            <li>{{ $t->NroSalida }} - Neto: {{ $t->Neto }}</li>
                        @empty
                            <li>Sin tickets ALFA</li>
                        @endforelse
                    </ul>
                </div>

                <div class="col-md-6">
                    <h6>KILATE</h6>
                    <ul>
                        @forelse($kilateTickets as $t)
                            <li>{{ $t->NroSalida }} - Neto: {{ $t->Neto }}</li>
                        @empty
                            <li>Sin tickets KILATE</li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
