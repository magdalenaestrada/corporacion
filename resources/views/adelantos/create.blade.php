@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('ADELANTOS') }}
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
                <form class="crear-adelantos" action="{{ route('adelantos.store') }}" method="POST">
                    @csrf      

                <div class="row">
                    <div class="form-group">
                        <label for="cliente_id">CLIENTE</label>
                        <select name="cliente_id" id="cliente_id" class="form-control">
                            <option value="">{{ __('SELECCIONE UN CLIENTE') }}</option>
                            @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->documento_cliente }} - {{ $cliente->datos_cliente }} - {{ $cliente->ruc_empresa }} - {{ $cliente->razon_social }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                    <div class="form-group col-md-2 g-3">
                        <label for="fecha" class="text-muted">{{ __('FECHA') }}</label>
                        <input type="date" name="fecha" id="fecha"
                               class="form-control @error('fecha') is-invalid @enderror"
                               value="{{ old('fecha') }}" placeholder="Seleccione fecha">
                        @error('fecha')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>              
                    <div class="form-group col-md-4 g-3">
                        <label for="nrofactura" class="text-muted"> 
                            {{ __('NRO FACTURA') }}
                        </label>
                        <input type="text" name="nrofactura" id="nrofactura"
                            class="form-control @error('nrofactura') is-invalid @enderror" value="{{ old('nrofactura') }}"
                            placeholder="Ingrese numero de la factura">
                        @error('nrofactura')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                <div class="form-group col-md-6 g-3">
                        <label for="proveedor" class="text-muted">
                            {{ __('PROVEEDOR') }}
                        </label>
                        <input type="text" name="proveedor" id="proveedor"
                            class="form-control @error('proveedor') is-invalid @enderror" value="{{ old('proveedor') }}"
                            placeholder="Ingrese proveedor">
                        @error('proveedor')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>    
                    <div class="row">
                    <div class="form-group col-md-4 g-3">
                        <label for="total" class="text-muted">
                            {{ __('TOTAL') }}
                        </label>
                        <input type="text" name="total" id="total"
                            class="form-control @error('total') is-invalid @enderror" value="{{ old('total') }}"
                            placeholder="Ingrese total adelanto">
                        @error('total')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
            
                    <div class="form-group col-md-4 g-3">
                        <label for="detraccion">DETRACCION</label>
                        <input type="text" name="detraccion" id="detraccion" class="form-control" readonly>
                    </div> 
                   
                    <div class="form-group col-md-4 g-3">
                        <label for="deposito">DEPOSITO</label>
                        <input type="text" name="deposito" id="deposito" class="form-control" readonly>
                    </div> 
                    <div class="form-group col-md-12 g-3">
                        <label for="descripcion" class="text-muted">
                            {{ __('DESCRIPCION') }}
                        </label>
                        <input type="text" name="descripcion" id="descripcion"
                            class="form-control @error('descripcion') is-invalid @enderror" value="{{ old('descripcion') }}"
                            placeholder="Ingrese descripcion">
                        @error('descripcion')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="col-md-12 text-end g-3">
                        <button type="submit" class="btn btn-secondary btn-sm">
                            {{ __('GUARDAR ADELANTO') }}
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
            $('.crear-adelanto').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Crear adelanto?',
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
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Capturamos el campo de total_adelanto
                const totalAdelanto = document.getElementById('total');
                // Capturamos el campo de detraccion
                const detraccionField = document.getElementById('detraccion');
        
                // Agregamos un event listener para detectar cambios en total_adelanto
                totalAdelanto.addEventListener('input', function() {
                    // Obtenemos el valor ingresado en total_adelanto
                    let total = parseFloat(totalAdelanto.value);
        
                    // Verificamos si el valor es un número válido
                    if (!isNaN(total)) {
                        // Calculamos la detracción (10% de total_adelanto)
                        let detraccion = total * 0.10;
        
                        // Mostramos el resultado en el campo detraccion
                        detraccionField.value = detraccion.toFixed(2); // Limitamos a 2 decimales
                    } else {
                        // Si el valor ingresado no es válido, mostramos un mensaje o limpiamos el campo detraccion
                        detraccionField.value = ''; // Limpiamos el campo detraccion
                    }
                });
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Capturamos los campos relevantes
                const totalAdelanto = document.getElementById('total');
                const detraccionField = document.getElementById('detraccion');
                const adelantoField = document.getElementById('deposito');
        
                // Agregamos un event listener para detectar cambios en total_adelanto
                totalAdelanto.addEventListener('input', function() {
                    // Obtenemos el valor ingresado en total_adelanto
                    let total = parseFloat(totalAdelanto.value);
        
                    // Verificamos si el valor es un número válido
                    if (!isNaN(total)) {
                        // Calculamos la detracción (10% de total_adelanto)
                        let detraccion = total * 0.10;
        
                        // Mostramos el resultado en el campo detraccion
                        detraccionField.value = detraccion.toFixed(2); // Limitamos a 2 decimales
        
                        // Calculamos el adelanto (total_adelanto - detraccion)
                        let adelanto = total - detraccion;
        
                        // Mostramos el resultado en el campo adelanto
                        adelantoField.value = adelanto.toFixed(2); // Limitamos a 2 decimales
                    } else {
                        // Si el valor ingresado no es válido, limpiamos los campos detraccion y adelanto
                        detraccionField.value = '';
                        adelantoField.value = '';
                    }
                });
            });
        </script>
        
    @endpush
    
    
@endsection

