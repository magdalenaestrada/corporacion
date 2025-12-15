@extends('layouts.app')

@section('content')
<style>
    .table-liquidaciones {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .table-liquidaciones th {
        background: linear-gradient(135deg, #1c445f, #306b8a);
        color: white;
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }

    .table-liquidaciones td {
        background-color: white;
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
        color: #333;
    }

    .table-liquidaciones tr:hover {
        background-color: #f1f8ff;
        transition: background-color 0.3s;
    }
</style>

<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Editar Fina</h5>
            <a href="{{ route('finas.index') }}" class="btn btn-secondary btn-sm">← Volver a la lista</a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('finas.update', $fina->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="codigoBlending" class="form-label">Código Blending</label>
                    <input type="text" name="codigoBlending" id="codigoBlending" class="form-control" value="{{ old('codigoBlending', $fina->codigoBlending) }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Liquidaciones asociadas</label>
                    <div class="table-responsive">
                    <table class="table table-liquidaciones text-center">
                                <thead>
                                <tr>
                                    <th>Liquidación ID</th>
                                    <th>Cliente</th>
                                    <th>Nota</th>
                                    <th>Creación</th>
                                    <th>Lote</th>
                                    <th>Ticket Nro</th>
                                    <th>Producto</th>
                                    <th>TMH</th>
                                    <th>%H2O</th>
                                    <th>TMS</th>
                                    <th>Muestra</th>
                                    <th>%Cu</th>
                                    <th>Ag oz/tc</th>
                                    <th>Au oz/tc</th>
                                    <th>%As</th>
                                    <th>%Sb</th>
                                    <th>%Pb</th>
                                    <th>%Zn</th>
                                    <th>%Bi</th>
                                    <th>%Hg</th>
                                    <th>Estado</th>
                                    <th>Valor Lote</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($fina->liquidaciones as $liq)
                                    <tr>
                                        <td>{{ $liq->id }}</td>
                                        <td>{{ $liq->cliente->datos_cliente }}</td>
                                        <td>{{ $liq->comentario }}</td>
                                        <td>{{ $liq->created_at->format('d-m-Y H:i') }}</td>
                                        <td>{{ $liq->lote }}</td>
                                        <td>{{ $liq->NroSalida }}</td>
                                        <td>{{ $liq->producto }}</td>
                                        <td>{{ number_format($liq->peso, 3) }}</td>
                                        <td>{{ number_format(optional($liq->muestra)->humedad, 3) }}</td>
                                        <td>{{ number_format($liq->tms, 3) }}</td>
                                        <td>{{ optional($liq->muestra)->codigo ?? 'N/A' }}</td>
                                        <td>{{ number_format(optional($liq->muestra)->cu, 3) }}</td>
                                        <td>{{ number_format(optional($liq->muestra)->ag, 3) }}</td>
                                        <td>{{ number_format(optional($liq->muestra)->au, 3) }}</td>
                                        <td>{{ number_format(optional($liq->muestra)->as, 3) }}</td>
                                        <td>{{ number_format(optional($liq->muestra)->sb, 3) }}</td>
                                        <td>{{ number_format(optional($liq->muestra)->pb, 3) }}</td>
                                        <td>{{ number_format(optional($liq->muestra)->zn, 3) }}</td>
                                        <td>{{ number_format(optional($liq->muestra)->bi, 3) }}</td>
                                        <td>{{ number_format(optional($liq->muestra)->hg, 3) }}</td>
                                        <td>{{ $liq->estado ?? 'PROVISIONAL' }}</td>
                                        <td>${{ number_format($liq->valorporlote, 2) }}</td>
                                        <td>${{ number_format($liq->total, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="23" class="text-muted">No hay liquidaciones asociadas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">💾 Guardar cambios</button>
                    <a href="{{ route('procesadas') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
