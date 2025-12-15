@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('MÓDULO PARA EDITAR CONDICIONES DEL CLIENTE') }}
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
                <form class="editar-adelanto" action="{{ route('adelantos.update', $adelanto->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-md-12 g-3">
                            <label for="datos_cliente">
                                {{ __('DATOS DEL CLIENTE') }}
                            </label>
                            @if ($adelanto->cliente)
                                <input class="form-control" value="{{ $adelanto->cliente->datos_cliente }}" disabled>
                            @else
                                <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                            @endif
                        </div>

                        <div class="row">
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
                            <input type="text" name="nrofactura" id="nrofactura"
                                class="form-control @error('nrofactura') is-invalid @enderror" value="{{$adelanto->nrofactura ?? old('nrofactura') }}"
                                placeholder="Ingrese numero de la factura" disabled>
                            @error('nrofactura')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 g-3">
                            <label for="proveedor" >
                                {{ __('PROVEEDOR') }}
                            </label>
                            <input type="text" name="proveedor" id="proveedor"
                                class="form-control @error('proveedor') is-invalid @enderror" value="{{$adelanto->proveedor ?? old('proveedor') }}"
                                placeholder="Ingrese proveedor">
                            @error('proveedor')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="row">
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
                            <input type="text" name="descripcion" id="descripcion"
                                class="form-control @error('descripcion') is-invalid @enderror" value="{{$adelanto->descripcion ?? old('descripcion') }}"
                                placeholder="Ingrese descripcion">
                            @error('descripcion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                            <div class="col-md-12 text-end g-3">
                            <button type="submit" class="btn btn-secondary btn-sm">
                                {{ __('ACTUALIZAR REGISTRO') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            $('.editar-muestra').submit(function(e){
                e.preventDefault();
                Swal.fire({
                    title: '¿actualizar muestra?',
                    icon: 'warning',
                    ShowCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Si, confirmar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if(result.isConfirmed){
                        this.submit();
                    }
                })
            });
        </script>
    @endpush
    
    
@endsection