@extends('layouts.app')

@section('content')
    <div class="container-fluid"> <!-- Cambié a container-fluid para ocupar más espacio -->
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">{{ __('DETALLE DE DESPACHO') }}</h6>
                    </div>
                    <div class="col-md-6 text-end">
                        <a class="btn btn-danger btn-sm" href="{{ route('despachos.index') }}">
                            {{ __('VOLVER') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>
                                {{ __('Estás viendo el ID') }}
                            </strong>
                            <span class="badge text-bg-secondary">{{ $despacho->id }}</span>
                            <strong>
                                {{ __('y esta operación fue registrada el ') }}
                            </strong>
                                {{ $despacho->created_at->format('d-m-Y') }}
                            <strong>
                                {{ __('a la(s) ') }}
                            </strong>
                                {{ $despacho->created_at->format('H:i:s') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @if ($despacho->updated_at != $despacho->created_at)
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>
                                    {{ __('Estás viendo el ID') }}
                                </strong>
                                <span class="badge text-bg-secondary">
                                    {{ $despacho->id }}
                                </span>
                                <strong>
                                    {{ __('y esta operación fue actualizada el ') }}
                                </strong>
                                    {{ $despacho->updated_at->format('d-m-Y') }}
                                <strong>
                                    {{ __('a la(s) ') }}
                                </strong>
                                    {{ $despacho->updated_at->format('H:i:s') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @else
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>
                                    {{ __('Este ingreso aún no ha sido actualizado') }}
                                </strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="blendingCod"><strong>Código de Blending</strong></label>
                            <input type="text" class="form-control" value="{{ $blending?->cod ?? 'No disponible' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="totalTMH"><strong>TONELAJE TOTAL DESPACHADO TMH</strong></label>
                            <input type="text" class="form-control" value="{{ $despacho->totalTMH}}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha"><strong>Fecha de Despacho</strong></label>
                            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($despacho->fecha)->format('d/m/Y') }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="deposito"><strong>Depósito</strong></label>
                            <input type="text" class="form-control" value="{{ $despacho->deposito }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="destino"><strong>Destino</strong></label>
                            <input type="text" class="form-control" value="{{ $despacho->destino }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="masomenos"><strong>Falta o excede</strong></label>
                            <input type="text" class="form-control" value="{{ $despacho->masomenos }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="observacion"><strong>Observación</strong></label>
                            <input type="text" class="form-control" value="{{ $despacho->observacion }}" readonly>
                        </div>
                    </div>
                </div>

                <!-- Tabla de retiros relacionados con el despacho -->
                <h4 class="mt-4">Retiros Asociados</h4>
                <div class="table-responsive"> <!-- Agregado para hacer la tabla responsiva -->
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nro Salida</th>
                                <th>Precinto</th>
                                <th>Guía</th>
                                <th>Bruto</th>
                                <th>Tara</th>
                                <th>Neto</th>
                                <th>Tracto</th>
                                <th>Carreta</th>
                                <th>Guía Transporte</th>
                                <th>Ruc Empresa</th>
                                <th>Razón Social</th>
                                <th>Licencia</th>
                                <th>Conductor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($despacho->retiros as $retiro)
                                <tr>
                                    <td>{{ $retiro->nro_salida }}</td>
                                    <td>{{ $retiro->precinto }}</td>
                                    <td>{{ $retiro->guia }}</td>
                                    <td>{{ $retiro->bruto}}</td>
                                    <td>{{ $retiro->tara }}</td>
                                    <td>{{ $retiro->neto }}</td>
                                    <td>{{ $retiro->tracto }}</td>
                                    <td>{{ $retiro->carreta }}</td>
                                    <td>{{ $retiro->guia_transporte }}</td>
                                    <td>{{ $retiro->ruc_empresa }}</td>
                                    <td>{{ $retiro->razon_social }}</td>
                                    <td>{{ $retiro->licencia }}</td>
                                    <td>{{ $retiro->conductor }}</td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
