@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Humedades</h5>
            <a href="{{ route('humedad.create') }}" class="btn btn-primary btn-sm">Nueva Humedad</a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success mb-2">{{ session('success') }}</div>
            @endif

            @if(session('info'))
                <div class="alert alert-info mb-2">{{ session('info') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Mineral</th>
                            <th>Fecha recepción</th>
                            <th>Periodo</th>
                            <th>Fecha emisión</th>
                            <th>Razón social</th>
                            <th>Humedad</th>
                            <th>Peso (W)</th>
                            <th>Obs.</th>
                            <th>Tickets</th>
                            <th style="width:220px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($humedades as $h)
                        @php
                            $pesoTotal = $h->pesos->sum(fn($p) => (int)$p->neto);

                            $periodoTexto = ($h->periodo_inicio && $h->periodo_fin)
                                ? \Carbon\Carbon::parse($h->periodo_inicio)->format('d/m/Y') . ' AL ' . \Carbon\Carbon::parse($h->periodo_fin)->format('d/m/Y')
                                : '';
                        @endphp
                        <tr>
                            <td>
                                <span class="badge bg-dark">
                                    {{ $h->codigo ?? $h->id }}
                                </span>
                            </td>
                            <td>{{ $h->mineral->nombre ?? '' }}</td>
                            <td>{{ $h->fecha_recepcion ? \Carbon\Carbon::parse($h->fecha_recepcion)->format('d/m/Y') : '' }}</td>
                            <td>{{ $periodoTexto }}</td>
                            <td>{{ $h->fecha_emision ? \Carbon\Carbon::parse($h->fecha_emision)->format('d/m/Y') : '' }}</td>
                            <td>{{ $h->cliente->razon_social ?? '' }}</td>
                            <td>{{ $h->humedad ?? '' }}</td>
                            <td>{{ number_format($pesoTotal, 0, '.', ',') }}</td>
                            <td style="max-width:240px;">
                                <div style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    {{ $h->observaciones ?? '' }}
                                </div>
                            </td>
                            <td style="min-width:220px;">
                                @foreach($h->pesos as $p)
                                    <span class="badge bg-secondary me-1 mb-1">
                                        {{ $p->nro_salida }} - {{ $p->origen }}
                                    </span>
                                @endforeach
                            </td>
                            <td style="white-space:nowrap;">
                                <a class="btn btn-info btn-sm" href="{{ route('humedad.show', $h->id) }}">Ver</a>
                                <a class="btn btn-warning btn-sm" href="{{ route('humedad.edit', $h->id) }}">Editar</a>

                                <a href="{{ route('humedad.informe', $h->id) }}"
                                   class="btn btn-sm btn-secondary"
                                   target="_blank"
                                   title="Ver informe">
                                    Informe
                                </a>

                                <form action="{{ route('humedad.destroy', $h->id) }}"
                                      method="POST"
                                      class="d-inline form-eliminar">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="11" class="text-center">Sin registros</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-2">
                {{ $humedades->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.form-eliminar').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: '¿Estás seguro?',
                text: '¡Esta acción no se puede deshacer!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush
