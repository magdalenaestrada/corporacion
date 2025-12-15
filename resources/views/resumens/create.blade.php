@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('RESUMEN DE ADELANTOS') }}
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
                <form method="POST" action="{{ route('resumens.store') }}">
                    @csrf

                    <div class="form-group col-md-3 g-3">
                        <label for="fecha_resumen" class="text-muted">
                            {{ __('FECHA DE RESUMEN') }}
                        </label>
                        <span class="text-danger">(*)</span>
                        <input type="datetime-local" name="fecha_resumen"
                            placeholder="Ingrese la fecha de resumen de adelantos" class="form-control">
                    </div>
                    <P>
                    <div class="form-group col-md-12 g-3 mb-2">
                        <label for="seleccion_cliente" class="text-muted">{{ __('SELECCIONE CLIENTE PARA RESUMEN DE  ADELANTO') }}</label>
                        <select id="seleccion_cliente" name="seleccion_cliente" class="form-control">
                            <option value="">Seleccione un cliente</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}" data-total="{{ $cliente->adelantos_sum_total }}">
                                    {{ $cliente->documento_cliente }} - {{ $cliente->datos_cliente }} - {{ $cliente->ruc_empresa }} - {{ $cliente->razon_social }}
                                </option>
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-12 g-3 mb-2" id="adelantos_container" style="display: none;">
                        <label class="text-muted">{{ __('ADELANTOS DEL CLIENTE SELECCIONADO') }}</label><br>
                                @foreach ($adelantosDisponibles as $adelanto)
            <div class="adelanto-item" data-cliente-id="{{ $adelanto->cliente_id }}">
                <input type="checkbox" id="adelanto_{{ $adelanto->id }}" name="adelantos[]" value="{{ $adelanto->id }}"
                    data-total="{{ $adelanto->total }}" data-factura="{{ $adelanto->nrofactura }}">
                <label for="adelanto_{{ $adelanto->id }}">
                    CLIENTE: {{ $adelanto->cliente->datos_cliente }} --- FACTURA: {{ $adelanto->nrofactura }} ---- TOTAL: {{ $adelanto->total }}
                </label>
            </div>
        @endforeach
                        <div class="form-group col-md-12 g-3 mb-2">
                            <button type="button" class="btn btn-sm btn-primary seleccionar-todo">Seleccionar Todo</button>
                        </div>
                    </div>

                    <div class="form-group col-md-12 g-3">
                        <label for="suma_total" class="text-muted">
                            {{ __('SUMA TOTAL SELECCIONADA') }}
                        </label>
                        <input type="text" id="suma_total" name="suma_total" class="form-control" readonly>
                        <div class="col-md-12 text-end g-3 mt-3">
                            <button type="submit" class="btn btn-primary text-end mt-2">GUARDAR RESUMEN</button>
                        </div>
        </div>
    </div>
    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Capturar el formulario por su atributo 'action'
            const form = document.querySelector('form[action="{{ route('resumens.store') }}"]');

            // Agregar evento al formulario
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevenir el envío automático del formulario

                Swal.fire({
                    title: '¿CREAR RESUMEN?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Si, confirmar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Envía el formulario si se confirma
                        form.submit();
                    }
                });
            });
        });
    </script>
    <script>

function actualizarAdelantosMostrados(adelantosSeleccionados) {
    adelantosSeleccionados.forEach(function(adelantoId) {
        const adelantoElement = document.querySelector('.adelanto-item[data-cliente-id="' + adelantoId + '"]');
        if (adelantoElement) {
            adelantoElement.style.display = 'none';
        }
    });
}
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener elementos DOM
        const seleccionCliente = document.getElementById('seleccion_cliente');
        const adelantosContainer = document.getElementById('adelantos_container');
        const adelantos = adelantosContainer.querySelectorAll('.adelanto-item');
        const sumaTotalInput = document.getElementById('suma_total');

        // Función para seleccionar todos los checkboxes del cliente seleccionado
        function seleccionarTodo() {
            adelantos.forEach(function(adelanto) {
                const clienteId = seleccionCliente.value;
                const adelantoClienteId = adelanto.getAttribute('data-cliente-id');
                const checkbox = adelanto.querySelector('input[type="checkbox"]');
                if (clienteId && clienteId == adelantoClienteId) {
                    checkbox.checked = true;
                } else {
                    checkbox.checked = false;
                }
            });

            // Calcular y actualizar la suma total
            calcularSumaTotal();
        }

        // Escuchar cambios en la selección de cliente
        seleccionCliente.addEventListener('change', function() {
            // Mostrar u ocultar adelantos según el cliente seleccionado
            const clienteId = seleccionCliente.value;
            adelantosContainer.style.display = clienteId ? 'block' : 'none';
            adelantos.forEach(function(adelanto) {
                const adelantoClienteId = adelanto.getAttribute('data-cliente-id');
                adelanto.style.display = clienteId == adelantoClienteId ? 'block' : 'none';
            });

            // Resetear la suma total al seleccionar un cliente nuevo
            sumaTotalInput.value = '0.00';
        });

        // Escuchar cambios en los checkboxes para actualizar la suma total
        adelantos.forEach(function(adelanto) {
            const checkbox = adelanto.querySelector('input[type="checkbox"]');
            checkbox.addEventListener('change', function() {
                calcularSumaTotal();
            });
        });

        // Escuchar clics en el botón "Seleccionar Todo"
        const seleccionarTodoBtn = adelantosContainer.querySelector('.seleccionar-todo');
        seleccionarTodoBtn.addEventListener('click', function() {
            seleccionarTodo();
        });

        // Función para calcular y actualizar la suma total
        function calcularSumaTotal() {
            let sumaTotal = 0;
            adelantos.forEach(function(item) {
                const isChecked = item.querySelector('input[type="checkbox"]').checked;
                if (isChecked) {
                    sumaTotal += parseFloat(item.querySelector('input[type="checkbox"]').getAttribute('data-total'));
                }
            });
            sumaTotalInput.value = sumaTotal.toFixed(2); // Formatea la suma total a dos decimales si es necesario
        }
    });
</script>
<script>
    function actualizarAdelantosMostrados(adelantosSeleccionados) {
        adelantosSeleccionados.forEach(function(adelantoId) {
            const adelantoElement = document.querySelector('.adelanto-item[data-cliente-id="' + adelantoId + '"]');
            if (adelantoElement) {
                adelantoElement.style.display = 'none';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Obtener elementos DOM y funciones existentes
        const adelantosContainer = document.getElementById('adelantos_container');
        const adelantos = adelantosContainer.querySelectorAll('.adelanto-item');
        const sumaTotalInput = document.getElementById('suma_total');

        // Función para calcular y actualizar la suma total
        function calcularSumaTotal() {
            let sumaTotal = 0;
            const adelantosSeleccionados = [];

            adelantos.forEach(function(item) {
                const checkbox = item.querySelector('input[type="checkbox"]');
                if (checkbox.checked) {
                    sumaTotal += parseFloat(checkbox.getAttribute('data-total'));
                    adelantosSeleccionados.push(item.getAttribute('data-cliente-id'));
                }
            });

            sumaTotalInput.value = sumaTotal.toFixed(2); // Formatea la suma total a dos decimales si es necesario
            actualizarAdelantosMostrados(adelantosSeleccionados);
        }

        
        
    });
    
</script>
@endpush
@endsection
