@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('MÓDULO PARA EDITAR CLIENTES') }}
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
                <form class="editar-cliente" action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="form-group col-md-4 g-3">
                            <label for="documento_cliente">{{ __('DNI / RUC CLIENTE') }}</label>
                            <div class="input-group">
                                <input type="text" name="documento_cliente" id="documento_cliente"
                                    class="form-control" 
                                    value="{{ $cliente->documento_cliente }}" placeholder="Ingrese DNI ó RUC" disabled>
                                <button class="btn btn-secondary" type="button" id="buscar_cliente_btn" disabled>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 25 25"
                                        style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                        <path
                                            d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                           
                        </div>
                        <div class="form-group col-md-8 g-3">
                            <label for="datos_cliente">{{ __('NOMBRE DEL CLIENTE') }}</label>
                            <input type="text" name="datos_cliente" id="datos_cliente"
                                class="form-control"
                                value="{{ $cliente->datos_cliente }}" placeholder="Datos obtenidos automáticamente..." disabled>
                           
                        </div>
    
    
                        <div class="form-group col-md-4 g-3">
                            <label for="ruc_empresa">{{ __('DNI / RUC CLIENTE') }}</label>
                            <div class="input-group">
                                <input type="text" name="ruc_empresa" id="ruc_empresa"
                                    class="form-control"
                                    value="{{ $cliente->ruc_empresa }}" placeholder="Ingrese DNI ó RUC" disabled>
                                <button class="btn btn-secondary" type="button" id="buscar_empresa_btn" disabled>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 25 25"
                                        style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                        <path
                                            d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                          
                        </div>
                        <div class="form-group col-md-8 g-3">
                            <label for="razon_social">{{ __('RAZÓN SOCIAL DE LA EMPRESA EMPRESA') }}</label>
                            <input type="text" name="razon_social" id="razon_social"
                                class="form-control"
                                value="{{ $cliente->razon_social }}" placeholder="Datos obtenidos automáticamente..." disabled>
                            
                        </div>
    
    
    
    
                        <div class="form-group col-md-6 g-3">
                            <label for="direccion">{{ __('DIRECCIÓN') }}</label>
                            <input type="text" name="direccion" id="direccion"
                                class="form-control @error('direccion') is-invalid @enderror"
                                value="{{ $cliente->direccion ?? old('direccion') }}"
                                placeholder="Ingrese la dirección del cliente">
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
    
                        
    
                        <div class="form-group col-md-6 g-3">
                            <label for="telefono">{{ __('TELÉFONO') }}</label>
                            <input type="text" name="telefono" id="telefono"
                                class="form-control @error('telefono') is-invalid @enderror"
                                value="{{ $cliente->telefono ?? old('telefono') }}"
                                placeholder="Ingrese el teléfono del cliente">
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                         <!-- Añade más opciones según sea necesario 
                        <div class="form-group col-md-6 g-3">
                            <label for="producto" >
                                {{ __('PRODUCTO') }}
                            </label>
                            <select name="producto" id="producto" class="form-control @error('producto') is-invalid @enderror">
                                <option value="">Seleccione un producto</option>
                                <option value="Mineral Concentrado" {{ old('producto') == 'Mineral Concentrado' ? 'selected' : '' }}>Mineral Concentrado</option>
                                <option value="Mineral a granel" {{ old('producto') == 'Mineral a granel' ? 'selected' : '' }}>Mineral a granel</option>
                                <option value="Mineral molido" {{ old('producto') == 'Mineral molido' ? 'selected' : '' }}>Mineral molido</option>
                                <option value="Mineral chancado" {{ old('producto') == 'Mineral chancado' ? 'selected' : '' }}>Mineral chancado</option>
                               
                            </select>
                            @error('producto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>-->
    
                        <div class="form-group col-md-12 text-end g-3">
                            <button type="submit" class="btn btn-secondary btn-sm">
                                {{ __('ACTUALIZAR CLIENTE') }}
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
            $('.editar-registro').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿actualizar registro?',
                    icon: 'warning',
                    ShowCancelButton: true,
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
        @if ($errors->has('guia_remision') || $errors->has('guia_transportista'))
            <script>
                let errorMessage = '';

                @if ($errors->has('guia_remision'))
                    errorMessage += '<p>{{ $errors->first('guia_remision') }}</p>';
                @endif

                @if ($errors->has('guia_transportista'))
                    errorMessage += '<p>{{ $errors->first('guia_transportista') }}</p>';
                @endif

                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    html: errorMessage,
                });
            </script>
        @endif
    @endpush
@endsection
