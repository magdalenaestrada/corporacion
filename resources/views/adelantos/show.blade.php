@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <h6 class="mt-2">
                                    {{ __('VER ADELANTOS') }}
                                </h6>
                            </div>
                            <div class="col-md-6 text-end">
                                <a class="btn btn-danger btn-sm" href="{{ route('adelantos.index') }}">
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
                                    <span class="badge text-bg-secondary">{{ $adelanto->id }}</span>
                                    <strong>
                                        {{ __('y esta operación fue registrada el ') }}
                                    </strong>
                                        {{ $adelanto->created_at->format('d-m-Y') }}
                                    <strong>
                                        {{ __('a la(s) ') }}
                                    </strong>
                                        {{ $adelanto->created_at->format('H:i:s') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @if ($adelanto->updated_at != $adelanto->created_at)
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>
                                            {{ __('Estás viendo el ID') }}
                                        </strong>
                                        <span class="badge text-bg-secondary">
                                            {{ $adelanto->id }}
                                        </span>
                                        <strong>
                                            {{ __('y esta operación fue actualizada el ') }}
                                        </strong>
                                            {{ $adelanto->updated_at->format('d-m-Y') }}
                                        <strong>
                                            {{ __('a la(s) ') }}
                                        </strong>
                                            {{ $adelanto->updated_at->format('H:i:s') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @else
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>
                                            {{ __('Este adelanto aún no ha sido actualizado') }}
                                        </strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group col-md-12 g-3">
                                <label for="cliente_id">
                                    {{ __('CLIENTE') }}
                                </label>
                                <input class="form-control" value="{{ $adelanto->cliente->datos_cliente}}" disabled>
                            </div>
                            
                            <div class="form-group col-md-3 g-3">
                                <label for="fecha">
                                    {{ __('FECHA') }}
                                </label>
                                <input class="form-control" value="{{ $adelanto->fecha }}" disabled>
                            </div>
                            <div class="form-group col-md-3 g-3">
                                <label for="nrofactura">
                                    {{ __('NRO FACTURA') }}
                                </label>
                                <input class="form-control" value="{{ $adelanto->nrofactura }}" disabled>
                            </div>

                           
                            <div class="form-group col-md-6 g-3">
                                <label for="proveedor">
                                    {{ __('PROVEEDOR') }}
                                </label>
                                @if ($adelanto->proveedor)
                                    <input class="form-control" value="{{ $adelanto->proveedor }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>
                            <div class="form-group col-md-3 g-3">
                                <label for="total">
                                    {{ __('TOTAL') }}
                                </label>
                                <input class="form-control" value="{{ $adelanto->total }}" disabled>
                            </div>

                            <div class="form-group col-md-3 g-3">
                                <label for="detraccion">
                                    {{ __('DETRACCION') }}
                                </label>
                                @if ($adelanto->detraccion)
                                    <input class="form-control" value="{{ $adelanto->detraccion }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>
                            <div class="form-group col-md-3 g-3">
                                <label for="deposito">
                                    {{ __('DEPOSITO') }}
                                </label>
                                @if ($adelanto->deposito)
                                    <input class="form-control" value="{{ $adelanto->deposito }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>
                            <div class="form-group col-md-12 g-3">
                                <label for="descripcion">
                                    {{ __('DESCRIPCION') }}
                                </label>
                                @if ($adelanto->descripcion)
                                    <input class="form-control" value="{{ $adelanto->descripcion }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection