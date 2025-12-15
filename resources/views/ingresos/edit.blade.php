@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('MÓDULO PARA EDITAR INGRESOS') }}
                        </h6>
                    </div>
                    <div class="col-md-6 text-end">
                        <a class="btn btn-danger btn-sm" href="{{ route('ingresos.index') }}">
                            {{ __('VOLVER') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="editar-ingreso" action="{{ route('ingresos.update', $ingreso->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="codigo" class="text-muted">CODIGO</label>
                                <input type="text" id="codigo" name="codigo" class="form-control" value="{{ $ingreso->codigo }}" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fecha_ingreso" class="text-muted">{{ __('FECHA DE INGRESO') }}</label>
                                <input type="datetime-local" id="fecha_ingreso" name="fecha_ingreso" class="form-control" value="{{ old('fecha_ingreso', $ingreso->fecha_ingreso)}}"readonly>
                            </div>
                            <div class="form-group col-md-3 ">
                                <label for="estado" class="text-muted">{{ __('ESTADO') }}</label>
                                <select name="estado" id="estado" class="form-control @error('estado') is-invalid @enderror">
                                    <option value="">Seleccione estado producto</option>
                                    @foreach(['CONCENTRADO', 'BLENDING', 'POLVEADO', 'MOLIDO','FALCON', 'CHANCADO','LLAMPO', 'RELAVE', 'MARTILLADO', 'GRANEL'] as $estado)
                                        <option value="{{ $estado }}" {{ old('estado', $ingreso->estado) == $estado ? 'selected' : '' }}>{{ $estado }}</option>
                                    @endforeach
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="ref_lote" class="text-muted">REFERENCIA LOTE</label>
                                <input type="text" id="ref_lote" name="ref_lote" class="form-control" value="{{ $ingreso->ref_lote }}" required>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="identificador" class="text-success">{{ __('DNI / RUC') }}</label>
                                <input type="text" id="identificador" name="identificador" class="form-control" value="{{ $ingreso->identificador }}">
                            </div>
                            <div class="form-group col-md-9">
                                <label for="nom_iden" class="text-muted">{{ __('NOMBRE / RAZON SOCIAL') }}</label>
                                <input type="text" id="nom_iden" name="nom_iden" class="form-control" value="{{ $ingreso->nom_iden }}">
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="pesoexterno" class="text-muted">PESO EXTERNO</label>
                                <input type="text" id="pesoexterno" name="pesoexterno" class="form-control" value="{{ $ingreso->pesoexterno }}" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="descuento" class="text-muted">DESCUENTO</label>
                                <input type="text" id="descuento" name="descuento" class="form-control" value="{{ $ingreso->descuento }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="descripcion" class="text-muted">DESCRIPCION</label>
                                <input type="text" id="descripcion" name="descripcion" class="form-control" value="{{ $ingreso->descripcion }}" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="peso_total" class="text-muted">PESO TOTAL</label>
                                <input type="text" id="peso_total" name="peso_total" class="form-control" value="{{ $ingreso->peso_total }}" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="NroSalida" class="text-muted">NUMERO DE TICKET</label>
                                <input type="text" id="NroSalida" name="NroSalida" class="form-control" value="{{ $ingreso->NroSalida }}" >
                            </div>
                            <div class="form-group col-md-3">
                                <label for="placa" class="text-muted">PLACA</label>
                                <input type="text" id="placa" name="placa" class="form-control" value="{{ $ingreso->placa }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="procedencia" class="text-muted">PROCEDENCIA</label>
                                <input type="text" id="procedencia" name="procedencia" class="form-control" value="{{ $ingreso->procedencia }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="deposito" class="text-muted">DEPOSITO</label>1
                                <input type="text" id="deposito" name="deposito" class="form-control" value="{{ $ingreso->deposito }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="balanza" class="text-muted">BALANZA</label>
                                <input type="text" id="balanza" name="balanza" class="form-control" value="{{ $ingreso->balanza }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="tolva" class="text-muted">TOLVA</label>
                                <input type="text" id="tolva" name="tolva" class="form-control" value="{{ $ingreso->tolva }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="guia_transporte" class="text-muted">GUIA TRANSPORTE</label>
                                <input type="text" id="guia_transporte" name="guia_transporte" class="form-control" value="{{ $ingreso->guia_transporte }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="guia_remision" class="text-muted">GUIA REMISION</label>
                                <input type="text" id="guia_remision" name="guia_remision" class="form-control" value="{{ $ingreso->guia_remision }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="muestreo" class="text-muted">MUESTREO</label>
                                <input type="text" id="muestreo" name="muestreo" class="form-control" value="{{ $ingreso->muestreo }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="preparacion" class="text-muted">PREPARACION</label>
                                <input type="text" id="preparacion" name="preparacion" class="form-control" value="{{ $ingreso->preparacion }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="req_analisis" class="text-muted">REQ.ANALISIS NASCA LAB</label>
                                <input type="text" id="req_analisis" name="req_analisis" class="form-control" value="{{ $ingreso->req_analisis }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="req_analisis1" class="text-muted">REQ.ANALISIS LAB PERU</label>
                                <input type="text" id="req_analisis1" name="req_analisis1" class="form-control" value="{{ $ingreso->req_analisis1   }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="fecha_salida" class="text-muted">FECHA SALIDA</label>
                                <input type="date" id="fecha_salida" name="fecha_salida" class="form-control" value="{{ $ingreso->fecha_salida }}">
                            </div>
                            
                            <div class="form-group col-md-3">
                                <label for="retiro" class="text-muted">RETIRO</label>
                                <input type="text" id="retiro" name="retiro" class="form-control" value="{{ $ingreso->retiro }}">
                            </div>
                        <!-- <div class="form-group col-md-3">
                                <label for="lote" class="text-muted">CAMPO</label>
                                <select name="lote" id="lote" class="form-control @error('lote') is-invalid @enderror">
                                    <option value="">Seleccione un espacio...</option>
                                    @for ($i = 1; $i <= 200; $i++)
                                        <option value="{{ $i }}" {{ old('lote', $ingreso->lote) == $i ? 'selected' : '' }}>Seccion {{ $i }}</option>
                                    @endfor
                                </select>
                                @error('lote')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>-->
    
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">{{ __('Guardar Cambios') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
                        

@endsection
