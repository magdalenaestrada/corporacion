@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">{{ __('DETALLE DE INGRESO') }}</h6>
                    </div>
                    <div class="col-md-6 text-end">
                        <a class="btn btn-danger btn-sm" href="{{ route('ingresos.index') }}">
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
                            <span class="badge text-bg-secondary">{{ $ingreso->id }}</span>
                            <strong>
                                {{ __('y esta operación fue registrada el ') }}
                            </strong>
                                {{ $ingreso->created_at->format('d-m-Y') }}
                            <strong>
                                {{ __('a la(s) ') }}
                            </strong>
                                {{ $ingreso->created_at->format('H:i:s') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @if ($ingreso->updated_at != $ingreso->created_at)
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>
                                    {{ __('Estás viendo el ID') }}
                                </strong>
                                <span class="badge text-bg-secondary">
                                    {{ $ingreso->id }}
                                </span>
                                <strong>
                                    {{ __('y esta operación fue actualizada el ') }}
                                </strong>
                                    {{ $ingreso->updated_at->format('d-m-Y') }}
                                <strong>
                                    {{ __('a la(s) ') }}
                                </strong>
                                    {{ $ingreso->updated_at->format('H:i:s') }}
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
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="codigo" class="text-muted">CODIGO</label>
                        <input type="text" id="codigo" class="form-control" value="{{ $ingreso->codigo }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="fecha_ingreso" class="text-muted">{{ __('FECHA DE INGRESO') }}</label>
                        <input type="text" id="fecha_ingreso" class="form-control" value="{{ $ingreso->fecha_ingreso }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="estado" class="text-muted">{{ __('PRODUCTO') }}</label>
                        <input type="text" id="estado" class="form-control" value="{{ $ingreso->estado }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="ref_lote" class="text-muted">REFERENCIA LOTE</label>
                        <input type="text" id="ref_lote" class="form-control" value="{{ $ingreso->ref_lote }}" readonly>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="identificador" class="text-success">{{ __('DNI / RUC') }}</label>
                        <input type="text" id="identificador" class="form-control" value="{{ $ingreso->identificador }}" readonly>
                    </div>
                    <div class="form-group col-md-9">
                        <label for="nom_iden" class="text-muted">{{ __('NOMBRE / RAZONSOCIAL') }}</label>
                        <input type="text" id="nom_iden" class="form-control" value="{{ $ingreso->nom_iden }}" readonly>
                    </div>
                </div>
               
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="pesoexterno" class="text-muted">PESO EXTERNO</label>
                        <input type="text" id="pesoexterno" class="form-control" value="{{ $ingreso->pesoexterno }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="descuento" class="text-muted">DESCUENTO</label>
                        <input type="text" id="descuento" class="form-control" value="{{ $ingreso->descuento }}" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="descripcion" class="text-muted">DESCRIPCION</label>
                        <input type="text" id="descripcion" class="form-control" value="{{ $ingreso->descripcion }}" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="peso_total" class="text-muted">PESO TOTAL</label>
                        <input type="text" id="peso_total" class="form-control" value="{{ $ingreso->peso_total }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="NroSalida" class="text-muted">NUMERO DE TICKET</label>
                        <input type="text" id="NroSalida" class="form-control" value="{{ $ingreso->NroSalida }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="placa" class="text-muted">PLACA</label>
                        <input type="text" id="placa" class="form-control" value="{{ $ingreso->placa }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="procedencia" class="text-muted">PROCEDENCIA</label>
                        <input type="text" id="procedencia" class="form-control" value="{{ $ingreso->procedencia }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="deposito" class="text-muted">DEPOSITO</label>
                        <input type="text" id="deposito" class="form-control" value="{{ $ingreso->deposito }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="balanza" class="text-muted">BALANZA</label>
                        <input type="text" id="balanza" class="form-control" value="{{ $ingreso->balanza }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="tolva" class="text-muted">TOLVA</label>
                        <input type="text" id="tolva" class="form-control" value="{{ $ingreso->tolva }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="guia_transporte" class="text-muted">GUIA TRANSPORTE</label>
                        <input type="text" id="guia_transporte" class="form-control" value="{{ $ingreso->guia_transporte }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="guia_remision" class="text-muted">GUIA REMISION </label>
                        <input type="text" id="guia_remision" class="form-control" value="{{ $ingreso->guia_remision }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="muestreo" class="text-muted">MUESTREO</label>
                        <input type="text" id="muestreo" class="form-control" value="{{ $ingreso->muestreo }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="preparacion" class="text-muted">PREPARACION</label>
                        <input type="text" id="preparacion" class="form-control" value="{{ $ingreso->preparacion }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="req_analisis" class="text-muted">REQ. ANALISIS NASCA LAB</label>
                        <input type="text" id="req_analisis" class="form-control" value="{{ $ingreso->req_analisis }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="req_analisis1" class="text-muted">REQ. ANALISIS LAB PERU</label>
                        <input type="text" id="req_analisis1" class="form-control" value="{{ $ingreso->req_analisis1 }}" readonly>
                    </div>
                   
                    <div class="form-group col-md-3">
                        <label for="fecha_salida" class="text-muted">FECHA SALIDA</label>
                        <input type="text" id="fecha_salida" class="form-control" value="{{ $ingreso->fecha_salida }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="retiro" class="text-muted">RETIRO</label>
                        <input type="text" id="retiro" class="form-control" value="{{ $ingreso->retiro }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="lote" class="text-muted">SECCION</label>
                        <input type="text" id="lote" class="form-control" value="{{ $ingreso->lote }}" readonly>
                    </div>
                </div>         
        </div>
    </div>
@endsection
