@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('CLIENTES') }}
                        </h6>
                    </div>
                    <div class="col-md-6 text-end">
                        <a class="btn btn-danger btn-sm" href="{{ route('clientes.index') }}">
                            {{ __('VOLVER') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="crear-cliente" action="{{ route('clientes.store') }}" method="POST">
                    @csrf


                    <div class="row">
                    <div class="form-group col-md-4 g-3">
                        <label for="documento_cliente" class="text-success">
                            {{ __('DNI CLIENTE') }}
                        </label>
                        <div class="input-group">
                            <input type="text" name="documento_cliente" id="documento_cliente"
                                class="form-control @error('documento_cliente') is-invalid @enderror"
                                value="{{ old('documento_cliente') }}" placeholder="Ingrese DNI">
                            <button class="btn btn-primary" type="button" id="buscar_cliente_btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 25 25"
                                    style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                    <path
                                        d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                        @error('documento_cliente')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-8 g-3">
                        <label for="datos_cliente" class="text-muted">
                            {{ __('NOMBRE CLIENTE') }}
                        </label>
                        <input type="text" name="datos_cliente" id="datos_cliente"
                            class="form-control @error('datos_cliente') is-invalid @enderror"
                            value="{{ old('datos_cliente') }}" placeholder="Datos obtenidos automáticamente...">
                        @error('datos_cliente')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4 g-3">
                        <label for="ruc_empresa" class="text-success">
                            {{ __('RUC EMPRESA') }}
                        </label>
                        <div class="input-group">
                            <input type="text" name="ruc_empresa" id="ruc_empresa"
                                class="form-control @error('ruc_empresa') is-invalid @enderror"
                                value="{{ old('ruc_empresa') }}" placeholder="Ingrese RUC">
                            <button class="btn btn-primary" type="button" id="buscar_empresa_btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 25 25"
                                    style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                    <path
                                        d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                        @error('ruc_empresa')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-8 g-3">
                        <label for="razon_social" class="text-muted">
                            {{ __('RAZON SOCIAL') }}
                        </label>
                        <input type="text" name="razon_social" id="razon_social"
                            class="form-control @error('razon_social') is-invalid @enderror"
                            value="{{ old('razon_social') }}" placeholder="Datos obtenidos automáticamente...">
                        @error('razon_social')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 g-3">
                        <label for="direccion" class="text-muted">
                            {{ __('DIRECCIÓN') }}
                        </label>
                        <input type="text" name="direccion" id="direccion"
                            class="form-control @error('direccion') is-invalid @enderror" value="{{ old('direccion') }}"
                            placeholder="Ingrese su dirección">
                        @error('direccion')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 g-3">
                        <label for="telefono" class="text-muted">
                            {{ __('TELÉFONO') }}
                        </label>
                        <input type="text" name="telefono" id="telefono"
                            class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}"
                            placeholder="Ingrese su teléfono">
                        @error('telefono')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    
                    <div class="col-md-12 text-end g-3">
                        <button type="submit" class="btn btn-secondary btn-sm">
                            {{ __('GUARDAR CLIENTE') }}
                        </button>
                    </div>

                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    @push('js')
        <script>
            $('.crear-cliente').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Crear cliente?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Si, confirmar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                })
            });
        </script>
        
    @endpush
    
    
@endsection
