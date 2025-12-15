@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Recepción de Retiro - {{ $recepcion->retiro->nro_salida }}</h5>
            <div>
                <!-- Botón para Volver a la Lista de Retiros -->
                <a href="{{ route('despachos.retiros', $recepcion->retiro->despacho_id) }}" class="btn btn-secondary btn-sm">
                    Volver a Retiros
                </a>
        
                <!-- Botón para Editar Recepción -->
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarRecepcionModal">
                    Editar Recepción
                </button>
            </div>
        </div>
        <div class="card-body">
            <p><strong>Bruto:</strong> {{ $recepcion->bruto_recep }}</p>
            <p><strong>Tara:</strong> {{ $recepcion->tara_recep }}</p>
            <p><strong>Neto:</strong> {{ $recepcion->neto_recep }}</p>
            <p><strong>Diferencia:</strong> {{ $recepcion->diferencia }}</p>
            <p><strong>Código de Lote:</strong> {{ $recepcion->codigo_lote }}</p>
            <p><strong>Fecha de Recepción:</strong> {{ $recepcion->fecha_recepcion }}</p>
            <p><strong>Referencia:</strong> {{ $recepcion->referencia }}</p>
            <p><strong>Custodio:</strong> {{ $recepcion->custodio }}</p>
            <p><strong>Observaciones:</strong> {{ $recepcion->observaciones }}</p>
        </div>
    </div>

    <!-- Modal para editar Recepción -->
    <div class="modal fade" id="editarRecepcionModal" tabindex="-1" aria-labelledby="editarRecepcionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarRecepcionLabel">Editar Recepción - {{ $recepcion->retiro->nro_salida }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('retiros.recepcion.update', $recepcion->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <label>Bruto</label>
                                <input type="text" name="bruto_recep" value="{{ $recepcion->bruto_recep }}" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label>Tara</label>
                                <input type="text" name="tara_recep" value="{{ $recepcion->tara_recep }}" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label>Neto</label>
                                <input type="text" name="neto_recep" value="{{ $recepcion->neto_recep }}" class="form-control" readonly required>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label>Diferencia</label>
                                <input type="text" name="diferencia" value="{{ $recepcion->diferencia }}" class="form-control" readonly required>
                            </div>
                            <div class="col-md-8">
                                <label>Código de Lote</label>
                                <input type="text" name="codigo_lote" value="{{ $recepcion->codigo_lote }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label>Fecha de Recepción</label>
                            <input type="date" name="fecha_recepcion" value="{{ $recepcion->fecha_recepcion }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Referencia</label>
                            <input type="text" name="referencia" value="{{ $recepcion->referencia }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Custodio</label>
                            <input type="text" name="custodio" value="{{ $recepcion->custodio }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Observaciones</label>
                            <textarea name="observaciones" class="form-control" rows="3">{{ $recepcion->observaciones }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-success">Actualizar Recepción</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
