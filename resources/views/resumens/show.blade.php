@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('RESUMEN DE ADELANTOS SELECCIONADOS') }}
                        </h6>
                    </div>
                    <div class="col-md-6 text-end">
                        <a class="btn btn-danger btn-sm" href="{{ route('resumens.index') }}">
                            {{ __('VOLVER') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group col-md-3 g-3">
                    <label for="fecha_resumen" class="text-muted">
                        {{ __('FECHA DE RESUMEN') }}
                    </label>
                    <input type="text" id="fecha_resumen" name="fecha_resumen" class="form-control" value="{{ $resumen->fecha_resumen }}" readonly>
                </div>

                <div class="form-group col-md-12 g-3 mb-2">
                    <label for="seleccion_cliente" class="text-muted">{{ __('CLIENTE SELECCIONADO PARA EL RESUMEN') }}</label>
                    <input type="text" id="seleccion_cliente" name="seleccion_cliente" class="form-control" value="{{ $resumen->cliente->datos_cliente }}" readonly>
                </div>

                <div class="form-group col-md-12 g-3 mb-2">
                    <label class="text-muted">{{ __('ADELANTOS SELECCIONADOS') }}</label><br>
                    <ul>
                        @foreach ($resumen->adelantos as $adelanto)
                            <li>
                                CLIENTE: {{ $adelanto->cliente->datos_cliente }} - FACTURA: {{ $adelanto->nrofactura }} - TOTAL: {{ $adelanto->total }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="form-group col-md-12 g-3">
                    <label for="suma_total" class="text-muted">
                        {{ __('SUMA TOTAL SELECCIONADA') }}
                    </label>
                    <input type="text" id="suma_total" name="suma_total" class="form-control" value="{{ number_format($sumaTotal, 2, '.', '') }}" readonly>
                </div>
            </div>
        </div>
    </div>
@endsection
