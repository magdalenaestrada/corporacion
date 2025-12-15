@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Retiros para el Despacho') }} - {{ $despacho->id }}
                </div>
                <div class="card-body">
                    @if($retiros->count())
                    <table class="table table-striped">
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
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($retiros as $retiro)
                            <tr>
                                <td>{{ $retiro->nro_salida }}</td>
                                <td>{{ $retiro->precinto }}</td>
                                <td>{{ $retiro->guia }}</td>
                                <td>{{ $retiro->bruto }}</td>
                                <td>{{ $retiro->tara }}</td>
                                <td>{{ $retiro->neto }}</td>
                                <td>{{ $retiro->tracto }}</td>
                                <td>{{ $retiro->carreta }}</td>
                                <td>{{ $retiro->guia_transporte }}</td>
                                <td>{{ $retiro->ruc_empresa }}</td>
                                <td>{{ $retiro->razon_social }}</td>
                                <td>{{ $retiro->licencia }}</td>
                                <td>{{ $retiro->conductor }}</td>
                                <td>
                                    @if($retiro->recepcion)
                                    <a href="{{ route('retiros.recepcion.show', $retiro->id) }}" class="btn btn-info btn-sm">
                                        Ver Recepción
                                    </a>
                                @else
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#recepcionModal{{ $retiro->id }}">
                                        Recepción
                                    </button>
                                @endif
                                </td>
                            </tr>

                            <!-- Modal de recepción (se repite para cada retiro) -->
                            <div class="modal fade" id="recepcionModal{{ $retiro->id }}" tabindex="-1" aria-labelledby="recepcionModalLabel{{ $retiro->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="recepcionModalLabel{{ $retiro->id }}">Recepción de Retiro - {{ $retiro->nro_salida }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('retiros.recepcion', $retiro->id) }}" method="POST">
                                                @csrf
                                                <div class="card mb-3">
                                                    <div class="card-header">
                                                        <strong>Detalles del Retiro</strong>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label><strong>Bruto</strong></label>
                                                                <p>{{ $retiro->bruto }}</p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label><strong>Tara</strong></label>
                                                                <p>{{ $retiro->tara }}</p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label><strong>Neto</strong></label>
                                                                <p>{{ $retiro->neto }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                    <div class="card mb-3">
                                                    <div class="card-header">
                                                        <strong>Datos Recepcion</strong>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                        <label for="bruto_recep">Bruto</label>
                                                        <input type="text" name="bruto_recep" id="bruto_recep{{ $retiro->id }}" class="form-control" required>
                                                    </div>
                                                
                                                    <div class="col-md-4">
                                                        <label for="tara_recep">Tara</label>
                                                        <input type="text" name="tara_recep" id="tara_recep{{ $retiro->id }}" class="form-control" required>
                                                    </div>
                                                
                                                    <div class="col-md-4">
                                                        <label for="neto_recep">Neto</label>
                                                        <input type="text" name="neto_recep" id="neto_recep{{ $retiro->id }}" class="form-control" required readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-4">
                                                        <label for="diferencia">Diferencia</label>
                                                        <input type="text" name="diferencia" id="diferencia{{ $retiro->id }}" class="form-control" required readonly>
                                                    </div>

                                                    <div class="col-md-8">
                                                        <label for="codigo_lote">Código de Lote</label>
                                                        <input type="text" name="codigo_lote" id="codigo_lote{{ $retiro->id }}" class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                        <label for="fecha_recepcion">Recepción</label>
                                                        <input type="date" name="fecha_recepcion" id="fecha_recepcion{{ $retiro->id }}" class="form-control" required>
                                                    </div>

                                                <div class="form-group">
                                                    <label for="salida">Salida</label>
                                                    <input type="text" name="salida" id="salida{{ $retiro->id }}" class="form-control" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="referencia">Referencia</label>
                                                    <input type="text" name="referencia" id="referencia{{ $retiro->id }}" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label for="custodio">Custodio</label>
                                                    <input type="text" name="custodio" id="custodio{{ $retiro->id }}" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label for="observaciones">Observaciones</label>
                                                    <textarea name="observaciones" id="observaciones{{ $retiro->id }}" class="form-control" rows="3"></textarea>
                                                </div>

                                                <button type="submit" class="btn btn-primary">Guardar Recepción</button>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>No hay retiros registrados para este despacho.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('[id^="bruto_recep"]').forEach(function(input) {
        input.addEventListener('input', function() {
            const retiroId = this.id.replace('bruto_recep', '');
            const bruto = parseFloat(document.getElementById('bruto_recep' + retiroId).value) || 0;
            const tara = parseFloat(document.getElementById('tara_recep' + retiroId).value) || 0;
            const neto = bruto - tara;
            document.getElementById('neto_recep' + retiroId).value = neto.toFixed(3);
            calcularDiferencia(retiroId);
        });
    });

    document.querySelectorAll('[id^="tara_recep"]').forEach(function(input) {
        input.addEventListener('input', function() {
            const retiroId = this.id.replace('tara_recep', '');
            const bruto = parseFloat(document.getElementById('bruto_recep' + retiroId).value) || 0;
            const tara = parseFloat(document.getElementById('tara_recep' + retiroId).value) || 0;
            const neto = bruto - tara;
            document.getElementById('neto_recep' + retiroId).value = neto.toFixed(3);
            calcularDiferencia(retiroId);
        });
    });

    function calcularDiferencia(retiroId) {
        const netoRecepcion = parseFloat(document.getElementById('neto_recep' + retiroId).value) || 0;
        const netoOriginal = parseFloat("{{ $retiro->neto }}"); // Valor neto de la tabla
        const diferencia = netoRecepcion -  netoOriginal ;
        document.getElementById('diferencia' + retiroId).value = diferencia.toFixed(3);
    }
</script>
@endsection
