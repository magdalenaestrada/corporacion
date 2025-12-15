    @extends('layouts.app')

    @section('content')
    <style>
        @media (min-width: 768px) {
    .col-md-2_4 {
        flex: 0 0 20%;
        max-width: 20%;
    }
}
</style>

        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-between">
                        <div class="col-md-6">
                            <h6 class="mt-2">
                                {{ __('INGRESOS') }}
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
                    <form class="crear-ingresos" action="{{ route('ingresos.store') }}" method="POST">
                        @csrf   
                        <div class="row">
                        <div class="form-group col-md-3 g-3">
                            <label for="codigo" class="text-muted">CODIGO</label>
                            <input type="text" name="codigo" id="codigo" class="form-control" >
                        </div>
                        <div class="form-group col-md-3 g-3">
                            <label for="fecha_ingreso" class="text-muted">{{ __('FECHA DE INGRESO') }}</label>
                            <span class="text-danger">(*)</span>
                            <input type="datetime-local" id="fecha_ingreso" name="fecha_ingreso" class="form-control" placeholder="Ingrese la fecha de resumen de ingresos">
                        </div>
                        <div class="form-group col-md-3 g-3">
                            <label for="estado" class="text-muted">{{ __('ESTADO') }}</label>
                            <select name="estado" id="estado" class="form-control @error('estado') is-invalid @enderror">
                                <option value="">Seleccione estado producto</option>
                                @foreach(['CONCENTRADO', 'BLENDING', 'POLVEADO', 'MOLIDO','FALCON', 'CHANCADO','LLAMPO', 'RELAVE', 'MARTILLADO', 'GRANEL' , 'SOBRANTE'] as $estado)
                                    <option value="{{ $estado }}" {{ old('estado') == $estado ? 'selected' : '' }}>{{ $estado }}</option>
                                @endforeach
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                            <div class="form-group col-md-3 g-3" >
                            <label for="ref_lote" class="text-muted">REFERENCIA LOTE</label>
                            <input type="text" name="ref_lote" id="ref_lote" class="form-control" required>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-3 g-3">
                                <label for="identificador" class="text-success">{{ __('DNI / RUC') }}</label>
                                <div class="input-group">
                                    <input type="text" name="identificador" id="identificador" class="form-control @error('identificador') is-invalid @enderror" value="{{ old('identificador') }}" placeholder="Ingrese documentos">
                                    <button class="btn btn-primary" type="button" id="buscar_identificador_btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 25 25" style="fill: rgba(255, 255, 255, 1);">
                                            <path d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z"></path>
                                        </svg>
                                    </button>
                                </div>
                                @error('identificador')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-9 g-3">
                                <label for="nom_iden" class="text-muted">{{ __('NOMBRE / RAZON SOCIAL') }}</label>
                                <input type="text" name="nom_iden" id="nom_iden" class="form-control @error('nom_iden') is-invalid @enderror" value="{{ old('nom_iden') }}" placeholder="Datos obtenidos automáticamente...">
                                @error('nom_iden')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <p>
                            <div class="form-group">
                                <label>Seleccionar Pesos</label>
                                <input type="text" id="searchPesos" class="form-control mb-3" placeholder="Buscar pesos...">
                                <div id="pesos-list" class="row">
                                    @foreach($pesos as $peso)
                                        <div class="col-6 col-md-2_4 mb-2 peso-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="{{ $peso->NroSalida }}" id="peso_{{ $peso->NroSalida }}" data-neto="{{ $peso->Neto }}" data-placa="{{ $peso->Placa }}">
                                                <label class="form-check-label" for="peso_{{ $peso->NroSalida }}">
                                                    {{ $peso->NroSalida }} - Neto: {{ $peso->Neto }} - Placa {{ $peso->Placa }}
                                                </label>
                                            </div>
                                        </div>
                                @endforeach
                                <div class="d-flex justify-content-center mt-2">
                                    <ul class="pagination">
                                        <li class="page-item {{ $pesos->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $pesos->previousPageUrl() }}" aria-label="Previous">Anterior</a>
                                        </li>
                                        @php
                                        $currentPage = $pesos->currentPage();
                                        $lastPage = $pesos->lastPage();
                                        $range = 2; // Mostrar 2 páginas antes y 2 páginas después
                                        $start = max(1, $currentPage - $range);
                                        $end = min($lastPage, $currentPage + $range);
                                    @endphp
                        
                                    <!-- Números de página -->
                                    @for ($i = $start; $i <= $end; $i++)
                                        <li class="page-item {{ $pesos->currentPage() == $i ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $pesos->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor
                                        <li class="page-item {{ $pesos->hasMorePages() ? '' : 'disabled' }}">
                                            <a class="page-link" href="{{ $pesos->nextPageUrl() }}" aria-label="Next">Siguiente</a>
                                        </li>
                                    </ul>
                                </div>
                            </div> 
                            <script>
                                document.getElementById('searchPesos').addEventListener('input', function() {
                                    const searchTerm = this.value.toLowerCase();
                                    const items = document.querySelectorAll('.peso-item');
                            
                                    items.forEach(item => {
                                        const label = item.textContent.toLowerCase();
                                        if (label.includes(searchTerm)) {
                                            item.style.display = '';
                                        } else {
                                            item.style.display = 'none';
                                        }
                                    });
                                });
                            </script>
                            
                        <div class="form-group row g-3 align-items-end">
                            <div class="col-md-2">
                                <label for="pesoexterno">PESO EXTERNO</label>
                                <input type="text" name="pesoexterno" id="pesoexterno" class="form-control" value="" readonly>
                            </div>
                        
                            <div class="col-md-3 d-flex">
                                <button type="button" id="activarPesoExterno" class="btn btn-secondary me-2">
                                    {{ __('Activar Peso Externo') }}
                                </button>
                            </div>
                        
                            <div class="col-md-2">
                                <label for="descuento" class="text-muted">DESCUENTO</label>
                                <input type="text" name="descuento" id="descuento" class="form-control" value="" readonly>
                            </div>
                        
                            <div class="col-md-3 d-flex">
                                <button type="button" id="toggleDescuento" class="btn btn-secondary">
                                    {{ __('Activar Descuento') }}
                                </button>
                            </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-12 g-1">
                            <label for="descripcion">DESCRIPCION</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control" value="">
                        </div>
                    </div>
                        <div class="row">
                            <div class="form-group col-md-3 g-1">
                                <label for="peso_total">PESO TOTAL</label>
                                <input type="text" name="peso_total" id="peso_total" class="form-control" value="" readonly>
                            </div>
                            <div class="form-group col-md-3 g-1">
                                <label for="NroSalida" class="text-muted">NUMERO DE TICKET</label>
                                <input type="text" name="NroSalida" id="NroSalida" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-3 g-1">
                                <label for="placa" class="text-muted">PLACA</label>
                                <input type="text" name="placa" id="placa" class="form-control" >
                            </div>
                            <div class="form-group col-md-3 g-1">
                                <label for="procedencia" class="text-muted">PROCEDENCIA</label>
                                <input type="text" name="procedencia" id="procedencia" class="form-control" required>
                            </div>
                            <div class="form-group col-md-3 g-1">
                                <label for="deposito" class="text-muted">DEPOSITO</label>
                                <input type="text" name="deposito" id="deposito" value="ALFA LOZA 2" class="form-control" >
                            </div>
                            <div class="form-group col-md-3 g-1">
                                <label for="balanza" class="text-muted">BALANZA</label>
                                <input type="text" name="balanza" id="balanza" value="ALFA" class="form-control" >
                            </div>
                            <div class="form-group col-md-3 g-1">
                                <label for="tolva" class="text-muted">TOLVA</label>
                                <input type="text" name="tolva" id="tolva" class="form-control" >
                            </div>
                            <div class="form-group col-md-3 g-1">
                                <label for="guia_transporte" class="text-muted">GUIA TRANSPORTE</label>
                                <input type="text" name="guia_transporte" id="guia_transporte" class="form-control" >
                            </div>
                            <div class="form-group col-md-3 g-1">
                                <label for="guia_remision" class="text-muted">GUIA REMISION</label>
                                <input type="text" name="guia_remision" id="guia_remision" class="form-control" >
                            </div>
                            <div class="form-group col-md-3 g-1">
                                <label for="muestreo" class="text-muted">MUESTREO</label>
                                <input type="text" name="muestreo" id="muestreo" value="MIGUEL" class="form-control" >
                            </div>
                            <div class="form-group col-md-3 g-1">
                                <label for="preparacion" class="text-muted">PREPARACION</label>
                                <input type="text" name="preparacion" id="preparacion" value="DAVID" class="form-control" >
                            </div>
                            <div class="form-group col-md-3 g-1">
                                <label for="req_analisis" class="text-muted">REQ. ANALISIS NASCA LAB</label>
                                <input type="text" name="req_analisis" id="req_analisis" class="form-control" >
                            </div>
                            <div class="form-group col-md-3 g-1">
                                <label for="req_analisis1" class="text-muted">REQ. ANALISIS LAB PERU </label>
                                <input type="text" name="req_analisis1" id="req_analisis1" class="form-control" >
                            </div>
                           <!-- <div class="form-group col-md-3 g-1">
                                <label for="fecha_salida" class="text-muted">FECHA SALIDA</label>
                                <input type="date" name="fecha_salida" id="fecha_salida" class="form-control" >
                            </div>
                            <div class="form-group col-md-3 g-1">
                                <label for="retiro" class="text-muted">RETIRO</label>
                                <input type="text" name="retiro" id="retiro" class="form-control" >
                            </div>-->
                            <div class="form-group col-md-3 g-1">
                                <label for="lote" class="text-muted">CAMPO</label>
                                <select name="lote" id="lote" class="form-control @error('lote') is-invalid @enderror" required>
                                    <option value="">Seleccione un espacio...</option>
                                    @for ($i = 1; $i <= 504; $i++)
                                        @if (!in_array($i, $lotesRegistrados)) <!-- Verifica si el lote ya está registrado -->
                                            <option value="{{ $i }}" {{ old('lote') == $i ? 'selected' : '' }}>Seccion {{ $i }}</option>
                                        @endif
                                    @endfor
                                </select>
                                @error('lote')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>                
                        </div>
                        
                        <div class="col-md-12 text-center g-3">
                            <button type="submit" class="btn btn-primary btn-mt-2">
                                {{ __('GUARDAR INGRESO') }}
                            </button>
                        </div>
                    </form>

    @endsection

    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        //FECHA Y HORA ACTUAL 
        document.addEventListener('DOMContentLoaded', function() {
            // Crear un nuevo objeto Date
            const now = new Date();
            // Formatear la fecha y hora en el formato requerido (YYYY-MM-DDTHH:MM)
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const formattedDate = `${year}-${month}-${day}T${hours}:${minutes}`;
            
            // Establecer el valor del input
            document.getElementById('fecha_ingreso').value = formattedDate;
        });
    </script>

    <!--SUMA DE LOS PESOS Y SELECCION -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"][id^="peso_"]');
        const pesoTotalElement = document.getElementById('peso_total');
        const nroSalidaElement = document.getElementById('NroSalida');
        const placaElement = document.getElementById('placa'); // Asegúrate de que el ID es correcto para el campo de placa
        const searchInput = document.getElementById('search');
        const pesosList = document.getElementById('pesos-list');

        // Función para formatear el total de pesos
        function formatPeso(peso) {
    let formattedPeso;

    if (peso < 1) {
        // Mostrar 3 decimales para valores menores que 1
        formattedPeso = peso.toFixed(3); 
        formattedPeso = `0.${formattedPeso.split('.')[1]}`; // Formato con cero delante
    } else if (peso < 100) {
        // Convertir valores menores a 100 a su formato correcto dividiéndolos por 1000
        formattedPeso = (peso / 1000).toFixed(3);
        formattedPeso = `0.${formattedPeso.split('.')[1]}`; // Formato con cero delante
    } else if (peso >= 100 && peso < 1000) {
        // Para valores entre 100 y 999, dividir por 1000 y formatear
        formattedPeso = (peso / 1000).toFixed(3);
        formattedPeso = `0.${formattedPeso.split('.')[1]}`; // Formato con cero delante
    } else if (peso >= 1000) {
        // Formato con separador de miles sin decimales
        formattedPeso = peso.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 }); 
    } else {
        // Formato por defecto sin decimales
        formattedPeso = peso.toFixed(0); 
    }

    // Reemplazar la coma por punto en caso de que se use un separador decimal
    return formattedPeso.replace(/,/g, '.');
}

        // Función para calcular el total de pesos netos seleccionados
        function calculateTotal() {
            let totalPeso = 0;

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const netoValue = parseFloat(checkbox.getAttribute('data-neto'));
                    if (!isNaN(netoValue)) {
                        totalPeso += netoValue;
                    }
                }
            });

            pesoTotalElement.value = formatPeso(totalPeso);
        }

        // Función para actualizar el campo NroSalida y el campo Placa con los valores seleccionados
        function updateNroSalida() {
        const selectedNroSalidas = Array.from(checkboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        const selectedPlacas = Array.from(checkboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.getAttribute('data-placa')); // Cambiar a data-placa

        nroSalidaElement.value = selectedNroSalidas.join(' / ');
        placaElement.value = selectedPlacas.join(' / '); // Mostrar placas seleccionadas
    }

        // Función para filtrar los pesos por búsqueda
        function filterPesos() {
            const searchTerm = searchInput.value.toLowerCase();
            const items = pesosList.querySelectorAll('.form-check');

            items.forEach(item => {
                const label = item.querySelector('label').textContent.toLowerCase();
                if (label.includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Event listeners
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                calculateTotal();
                updateNroSalida();
            });
        });

        searchInput.addEventListener('input', filterPesos);

        // Inicializar el cálculo de total al cargar la página (para los valores ya seleccionados)
        calculateTotal();
        updateNroSalida();
    });
    </script>
    @push('js')
    <script>
    // Código existente...

    document.addEventListener('DOMContentLoaded', function() {
        const pesoTotalElement = document.getElementById('peso_total');
        const pesoExternoElement = document.getElementById('pesoexterno');
        const activarPesoExternoButton = document.getElementById('activarPesoExterno');
        const nroSalidaElement = document.getElementById('NroSalida');
        const placaElement = document.getElementById('placa');

        // Habilitar/deshabilitar el campo pesoexterno
        activarPesoExternoButton.addEventListener('click', function() {
            if (pesoExternoElement.readOnly) {
                pesoExternoElement.readOnly = false;
                nroSalidaElement.readOnly = false;
                placaElement.readOnly = false;
                activarPesoExternoButton.textContent = '{{ __('Desactivar Peso Externo') }}';
            } else {
                pesoExternoElement.readOnly = true;
                nroSalidaElement.readOnly = true;
                placaElement.readOnly = true;
                activarPesoExternoButton.textContent = '{{ __('Activar Peso Externo') }}';
            }
        });

        // Escuchar cambios en pesoexterno para actualizar peso_total
        pesoExternoElement.addEventListener('input', function() {
            const pesoTotal = parseFloat(document.getElementById('peso_total').value) || 0;
            const pesoExterno = parseFloat(pesoExternoElement.value) || 0;

            // Calcular el nuevo peso_total
            const newPesoTotal = pesoTotal - (pesoTotalElement.lastValue || 0) + pesoExterno;
            pesoTotalElement.value = newPesoTotal.toFixed(3); // Mantener 3 decimales
            
            // Guardar el último valor de peso_total para calcular correctamente al cambiar
            pesoTotalElement.lastValue = pesoExterno;
        });
        
        // Inicializar el último valor de peso_total
        pesoTotalElement.lastValue = 0; // Valor inicial
    });
    </script>
    <script>   
    document.addEventListener('DOMContentLoaded', function() {
        const pesoTotalElement = document.getElementById('peso_total');
        const descuentoElement = document.getElementById('descuento');
        const toggleDescuentoButton = document.getElementById('toggleDescuento');

        let isDescuentoActivo = false; // Estado inicial del descuento
        let originalPesoTotal = parseFloat(pesoTotalElement.value) || 0; // Guardar el peso total original

        // Escuchar el evento de clic en el botón de activar/desactivar descuento
        toggleDescuentoButton.addEventListener('click', function() {
            isDescuentoActivo = !isDescuentoActivo; // Cambiar el estado
            descuentoElement.readOnly = !isDescuentoActivo; // Habilitar o deshabilitar el campo de descuento

            // Cambiar el texto del botón
            toggleDescuentoButton.textContent = isDescuentoActivo ? 'Desactivar Descuento' : 'Activar Descuento';

            // Si se desactiva, reiniciar el descuento
            if (!isDescuentoActivo) {
                const descuento = parseFloat(descuentoElement.value) || 0;
                // Restaurar el peso total al original
                pesoTotalElement.value = (originalPesoTotal + descuento).toFixed(3); // Sumar el descuento al peso total
                descuentoElement.value = ''; // Limpiar el campo de descuento
            } else {
                // Si se activa, guardar el valor actual del peso total
                originalPesoTotal = parseFloat(pesoTotalElement.value) || 0;
            }
        });

        // Escuchar cambios en el campo de descuento solo si está activo
        descuentoElement.addEventListener('input', function() {
            if (isDescuentoActivo) {
                const descuento = parseFloat(descuentoElement.value) || 0;
                const newPesoTotal = originalPesoTotal - descuento; // Resta el descuento del total
                pesoTotalElement.value = newPesoTotal.toFixed(3); // Mantener el formato
            }
        });
    });
    </script>
    <script>
        document.querySelector('.crear-ingresos').addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerText = 'Guardando...'; // opcional, cambia el texto del botón
        });
    </script>
    @endpush
