@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">{{ __('CREAR NUEVO DESPACHO PARA BLENDING') }}</h6>
                    <a class="btn btn-danger btn-sm" href="{{ route('despachos.index') }}">
                        {{ __('VOLVER') }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h5>{{ __('DATOS DEL BLENDING') }}</h5>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
                        <p><strong>{{ __('CÓDIGO:') }}</strong> {{ $blending->cod }}</p>
                        <p><strong>{{ __('TIPO DE MATERIAL:') }}</strong> {{ $blending->lista }}</p>
                        <p><strong>{{ __('NOTAS:') }}</strong> {{ $blending->notas }}</p>
                    </div>
                </div>

                <div class="mt-2">
                    @if($blending->ingresos->isEmpty())
                        <p>{{ __('No hay ingresos asociados a este blending.') }}</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Fecha de Ingreso') }}</th>
                                    <th>{{ __('Cliente') }}</th>
                                    <th>{{ __('Ticket') }}</th>
                                    <th>{{ __('Lote') }}</th>
                                    <th>{{ __('Peso') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blending->ingresos as $ingreso)
                                    <tr>
                                        <td>{{ $ingreso->fecha_ingreso }}</td>
                                        <td>{{ $ingreso->nom_iden }}</td>
                                        <td>{{ $ingreso->NroSalida }}</td>
                                        <td>{{ $ingreso->ref_lote }}</td>
                                        <td>{{ $ingreso->peso_total }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <div class="mb-3 d-flex justify-content-end">
                        <strong>{{ __('TMH TOTAL') }}:</strong>
                        <span class="ms-2">{{ $blending->pesoblending }} </span>
                    </div>
                </div>

                <!-- Botón para abrir el modal de registro de ingresos -->
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-success" onclick="abrirModal()">REGISTRAR INFORMACION DESPACHO</button>
                </div>

                <!-- Tabla principal -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-sm mt-3" id="tablaDespacho">
                        <thead class="thead-azul">
                            <tr>
                                <th>{{ __('N° Ticket') }}</th>
                                <th>{{ __('Precinto') }}</th>
                                <th>{{ __('N° Guia Remision') }}</th>
                                <th>{{ __('Peso Bruto') }}</th>
                                <th>{{ __('Peso Tara') }}</th>
                                <th>{{ __('Peso Neto') }}</th>
                                <th>{{ __('Placa Tracto') }}</th>
                                <th>{{ __('Placa Carreta') }}</th>
                                <th>{{ __('N° Guia Transporte ') }}</th>
                                <th>{{ __('Ruc') }}</th>
                                <th>{{ __('Empresa') }}</th>
                                <th>{{ __('N° Licencia') }}</th>
                                <th>{{ __('Conductor') }}</th>
                                <th style="min-width:120px">{{ __('Acción') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Filas dinámicas -->
                        </tbody>
                    </table>
                    
                    <style>
                        #tablaDespacho { font-size: 0.9rem; }
                        #tablaDespacho tbody tr:nth-child(even) { background-color: #E3F2FD; }
                        #tablaDespacho tbody tr:hover { background-color: #BBDEFB; }
                        #tablaDespacho td:last-child { text-align: center; }
                        #tablaDespacho td, #tablaDespacho th { vertical-align: middle; }
                        .thead-azul th { background-color: #007BFF; color: white; font-weight: bold; }
                        .btn-sm { padding: 0.25rem 0.5rem; font-size: 0.8rem; }
                        /* Centrar el form-switch de Bootstrap */
.switch-centered{
  display: flex;
  justify-content: center;
  align-items: center;
  gap: .5rem;      /* espacio entre el toggle y el texto */
  padding-left: 0; /* quita el padding por defecto del .form-check */
}
.switch-centered .form-check-input{
  float: none;     /* evita el flotado que rompe el centrado */
  margin-left: 0;  /* elimina el desplazamiento negativo */
}
.switch-centered .form-check-label{
  margin: 0;       /* alinea verticalmente con el toggle */
}
                    </style>
                     
            </div>

            <!-- Modal -->
            <div id="modalRetiro" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="cerrarModal()">&times;</span>
                    <h2 style="text-align: center;">{{ __('INFORMACION DEL DESPACHO') }}</h2>

                    <!-- Checkbox para activar edición manual -->
                    <!-- Switch centrado -->
                <div class="form-check form-switch mb-3 switch-centered">
                <input class="form-check-input" type="checkbox" id="activarEdicion">
                <label class="form-check-label" for="activarEdicion">
                    Editar N° Salida y Pesos manualmente
                </label>
                </div>


                    <form id="formRetiro">
                        <!-- Select NroSalida -->
                        <div class="form-group" id="grpNroSalidaSelect">
                            <label for="NroSalida" class="text-muted">{{ __('N° SALIDA') }}</label>
                            <select name="NroSalida" id="NroSalida" class="form-control" required>
                                <option value="">Seleccionar N° Salida</option>
                                @foreach($NroSalida as $nro)
                                    <option value="{{ $nro->NroSalida }}" 
                                            data-bruto="{{ $nro->Bruto }}" 
                                            data-neto="{{ $nro->Neto }}" 
                                            data-tara="{{ $nro->Tara }}">
                                        {{ $nro->NroSalida }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Input NroSalida manual -->
                        <div class="form-group d-none" id="grpNroSalidaInput">
                            <label for="NroSalida_manual" class="text-muted">{{ __('N° SALIDA (manual)') }}</label>
                            <input type="text" id="NroSalida_manual" class="form-control" placeholder="Escribe el N° Salida">
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="bruto" class="text-muted">{{ __('PESO BRUTO') }}</label>
                                <input type="text" class="form-control" id="bruto" name="bruto" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="tara" class="text-muted">{{ __('PESO TARA') }}</label>
                                <input type="text" class="form-control" id="tara" name="tara" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="neto" class="text-muted">{{ __('PESO NETO (TMH)') }}</label>
                                <input type="text" class="form-control" id="neto" name="neto" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="precinto" class="text-muted">{{ __('PRECINTO') }}</label>
                                <input type="text" class="form-control" id="precinto" name="precinto">
                            </div>
                            <div class="col-md-3">
                                <label for="guia" class="text-muted">{{ __('GUIA REMISION ') }}</label>
                                <input type="text" class="form-control" id="guia" name="guia">
                            </div>
                            <div class="col-md-3">
                                <label for="tracto" class="text-muted">{{ __('PLACA TRACTO') }}</label>
                                <input type="text" class="form-control" id="tracto" name="tracto">
                            </div>
                            <div class="col-md-3">
                                <label for="carreta" class="text-muted">{{ __('PLACA CARRETA') }}</label>
                                <input type="text" class="form-control" id="carreta" name="carreta">
                            </div> 
                        </div>

                        <h2 style="text-align: center;">{{ __('INFORMACION DEL TRANSPORTE') }}</h2>
                        <div class="form-group row">
                            <div class="form-group col-md-4 g-3">
                                <label for="ruc_empresa" class="text-success">{{ __('RUC EMPRESA') }}</label>
                                <div class="input-group">
                                    <input type="text" name="ruc_empresa" id="ruc_empresa" class="form-control" value="{{ old('ruc_empresa') }}" placeholder="Ingrese RUC">
                                    <button class="btn btn-primary" type="button" id="buscar_empresa_btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 25 25" style="fill:#fff">
                                            <path d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group col-md-8 g-3">
                                <label for="razon_social" class="text-muted">{{ __('RAZON SOCIAL') }}</label>
                                <input type="text" name="razon_social" id="razon_social" class="form-control" value="{{ old('razon_social') }}" placeholder="Datos obtenidos automáticamente...">
                            </div>
                            <div class="col-md-3">
                                <label for="guia_transporte" class="text-muted">{{ __('N° GUIA TRANSP.') }}</label>
                                <input type="text" class="form-control" id="guia_transporte" name="guia_transporte">
                            </div>
                            <div class="col-md-3">
                                <label for="licencia" class="text-muted">{{ __('N° LICENCIA') }}</label>    
                                <input type="text" class="form-control" id="licencia" name="licencia">
                            </div> 
                            <div class="col-md-6">
                                <label for="conductor" class="text-muted">{{ __('CONDUCTOR') }}</label>
                                <input type="text" class="form-control" id="conductor" name="conductor">
                            </div> 
                        </div>

                        <div class="form-group">
                            <button type="button" id="agregarRetiro" class="btn btn-primary btn-block">
                                {{ __('Agregar a la tabla') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <style>
                .modal { display:none; position:fixed; z-index:1; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,.4); }
                .modal-content { background:#fff; margin:10% auto; padding:20px; border:1px solid #888; width:80%; max-width:700px; border-radius:8px; }
                .close { color:#aaa; float:right; font-size:28px; font-weight:bold; }
                .close:hover,.close:focus { color:#000; text-decoration:none; cursor:pointer; }
            </style>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function() {
                    // ===== Helpers =====
                    function toNum(v){ if(v===null||v===undefined) return NaN; return parseFloat(String(v).replace(/\./g,'').replace(',', '.')); }
                    function formatNumber(n){ if(n===null||n===undefined||n==='') return ''; const x=Number(n); if(Number.isNaN(x)) return String(n); return x.toLocaleString('es-CL'); }

                    // ===== Estado global en cliente =====
                    let retirosArray = [];      // objetos { uid, ...campos }
                    let usados = new Set();     // NroSalida usados para evitar duplicados
                    let editingUid = null;      // si no es null, estamos editando esa fila

                    // Exponer abrir/cerrar modal
                    window.abrirModal = function(){ $("#modalRetiro").show(); };
                    window.cerrarModal = function(){ $("#modalRetiro").hide(); limpiarForm(); desactivarEdicion(false); };

                    // Refs
                    const $chk   = $('#activarEdicion');
                    const $grpSel= $('#grpNroSalidaSelect');
                    const $grpInp= $('#grpNroSalidaInput');
                    const $sel   = $('#NroSalida');
                    const $inp   = $('#NroSalida_manual');
                    const $pesos = $('#bruto,#tara,#neto');
                    const $btnAdd= $('#agregarRetiro');

                    // Toggle edición manual
                    function desactivarEdicion(on){
                        $chk.prop('checked', on);
                        $pesos.prop('readonly', !on);
                        if(on){
                            $grpSel.addClass('d-none'); $sel.prop('required', false).val('');
                            $grpInp.removeClass('d-none'); $inp.focus();
                            if(!$inp.val()) $pesos.val('');
                        }else{
                            $grpInp.addClass('d-none'); $inp.val('');
                            $grpSel.removeClass('d-none'); $sel.prop('required', true);
                            $sel.trigger('change');
                        }
                    }
                    $chk.on('change', function(){ desactivarEdicion($(this).is(':checked')); });

                    // Auto-llenado desde select (si no está modo manual)
                    $sel.on('change', function(){
                        if($chk.is(':checked')) return;
                        const opt = $(this).find('option:selected');
                        const b = opt.data('bruto'), n = opt.data('neto'), t = opt.data('tara');
                        if(b!==undefined && n!==undefined && t!==undefined){
                            $('#bruto').val(formatNumber(b));
                            $('#neto').val(formatNumber(n));
                            $('#tara').val(formatNumber(t));
                        }
                    });

                    // Limpiar formulario modal
                    function limpiarForm(){
                        $('#formRetiro')[0].reset();
                        $sel.prop('required', true);
                        $grpInp.addClass('d-none');
                        $grpSel.removeClass('d-none');
                        $pesos.prop('readonly', true);
                        editingUid = null;
                        $btnAdd.text('{{ __("Agregar a la tabla") }}');
                    }

                    // Total TMH y +/- contra pesoblending
                    function actualizarTotalTMH() {
                        let totalTMH = 0;
                        $('#tablaDespacho tbody tr').each(function(){
                            const pesoNeto = toNum($(this).find('td').eq(5).text());
                            if(!isNaN(pesoNeto)) totalTMH += pesoNeto;
                        });
                        $('#totalTMH').val(formatNumber(totalTMH));
                        let pesoblending = toNum('{{ $blending->pesoblending }}'); if(isNaN(pesoblending)) pesoblending = 0;
                        const diferencia = totalTMH - pesoblending;
                        $('input[name="masomenos"]').val(formatNumber(diferencia));
                    }

                    // Deshabilitar / habilitar opción de select por valor exacto
                    function disableOption(value, disabled){
                        $('#NroSalida option').filter(function(){ return $(this).val() === value; }).prop('disabled', !!disabled);
                    }

                    // Renderizar fila en tabla
                    function renderFila(data){
                        // data: { uid, NroSalida, precinto, guia, bruto, tara, neto, tracto, carreta, guia_transporte, ruc_empresa, razon_social, licencia, conductor }
                        const tr = `
                          <tr data-uid="${data.uid}">
                            <td>${data.NroSalida}</td>
                            <td>${data.precinto}</td>
                            <td>${data.guia}</td>
                            <td>${data.bruto}</td>
                            <td>${data.tara}</td>
                            <td>${data.neto}</td>
                            <td>${data.tracto}</td>
                            <td>${data.carreta}</td>
                            <td>${data.guia_transporte}</td>
                            <td>${data.ruc_empresa}</td>
                            <td>${data.razon_social}</td>
                            <td>${data.licencia}</td>
                            <td>${data.conductor}</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm editar">Editar</button>
                                <button type="button" class="btn btn-danger btn-sm eliminar">Eliminar</button>
                            </td>
                          </tr>`;
                        $('#tablaDespacho tbody').append(tr);
                    }

                    // Click Agregar / Actualizar
                    $btnAdd.on('click', function(){
                        const NroSalida = $chk.is(':checked') ? $inp.val().trim() : $sel.val();
                        const precinto = $('#precinto').val();
                        const guia = $('#guia').val();
                        const bruto = $('#bruto').val();
                        const tara = $('#tara').val();
                        const neto = $('#neto').val();
                        const tracto = $('#tracto').val();
                        const carreta = $('#carreta').val();
                        const guia_transporte = $('#guia_transporte').val();
                        const ruc_empresa = $('#ruc_empresa').val();
                        const razon_social = $('#razon_social').val();
                        const licencia = $('#licencia').val();
                        const conductor = $('#conductor').val();

                        // Validación mínima
                        if(!NroSalida || !precinto || !guia || !bruto || !tara || !neto || !tracto || !carreta || !guia_transporte || !ruc_empresa || !razon_social || !licencia || !conductor){
                            return;
                        }

                        // Si estamos creando, evitar duplicados
                        if(!editingUid && usados.has(NroSalida)){
                            // ya existe en la tabla
                            return;
                        }

                        if(editingUid){
                            // ====== Actualizar fila existente ======
                            const idx = retirosArray.findIndex(r => r.uid === editingUid);
                            if(idx !== -1){
                                const oldNro = retirosArray[idx].NroSalida;

                                // actualizar objeto
                                retirosArray[idx] = { uid: editingUid, NroSalida, precinto, guia, bruto, tara, neto, tracto, carreta, guia_transporte, ruc_empresa, razon_social, licencia, conductor };

                                // actualizar DOM
                                const $tr = $('#tablaDespacho tbody tr[data-uid="'+editingUid+'"]');
                                const tds = $tr.find('td');
                                tds.eq(0).text(NroSalida);
                                tds.eq(1).text(precinto);
                                tds.eq(2).text(guia);
                                tds.eq(3).text(bruto);
                                tds.eq(4).text(tara);
                                tds.eq(5).text(neto);
                                tds.eq(6).text(tracto);
                                tds.eq(7).text(carreta);
                                tds.eq(8).text(guia_transporte);
                                tds.eq(9).text(ruc_empresa);
                                tds.eq(10).text(razon_social);
                                tds.eq(11).text(licencia);
                                tds.eq(12).text(conductor);

                                // gestionar set de usados y opciones del select
                                if(oldNro !== NroSalida){
                                    usados.delete(oldNro);
                                    disableOption(oldNro, false);
                                    usados.add(NroSalida);
                                    disableOption(NroSalida, true);
                                }else{
                                    // volvemos a marcar como usado si es igual
                                    usados.add(NroSalida);
                                    disableOption(NroSalida, true);
                                }
                            }
                            $('#retiros_data').val(JSON.stringify(retirosArray));
                            actualizarTotalTMH();
                            limpiarForm(); // resetea estado edición
                            cerrarModal();
                            return;
                        }

                        // ====== Agregar nueva fila ======
                        const uid = Date.now().toString(36) + '-' + Math.random().toString(36).slice(2,8);
                        const data = { uid, NroSalida, precinto, guia, bruto, tara, neto, tracto, carreta, guia_transporte, ruc_empresa, razon_social, licencia, conductor };
                        retirosArray.push(data);
                        $('#retiros_data').val(JSON.stringify(retirosArray));

                        // Marcar NroSalida como usado y deshabilitar opción (si existe)
                        usados.add(NroSalida);
                        disableOption(NroSalida, true);

                        renderFila(data);
                        actualizarTotalTMH();

                        // limpiar formulario del modal pero mantener modo del checkbox
                        const keepManual = $chk.is(':checked');
                        $('#formRetiro')[0].reset();
                        if(keepManual){
                            desactivarEdicion(true);
                        }else{
                            desactivarEdicion(false);
                        }
                    });

                    // Eliminar fila
                    $('#tablaDespacho').on('click', '.eliminar', function(){
                        const $tr = $(this).closest('tr');
                        const uid = $tr.data('uid');
                        const nro = $tr.find('td').eq(0).text();

                        // quitar del array y del hidden
                        retirosArray = retirosArray.filter(r => r.uid !== uid);
                        $('#retiros_data').val(JSON.stringify(retirosArray));

                        // liberar NroSalida
                        usados.delete(nro);
                        disableOption(nro, false);

                        // quitar de la tabla y actualizar totales
                        $tr.remove();
                        actualizarTotalTMH();
                    });

                    // Editar fila
                    $('#tablaDespacho').on('click', '.editar', function(){
                        const $tr = $(this).closest('tr');
                        const uid = $tr.data('uid');
                        const item = retirosArray.find(r => r.uid === uid);
                        if(!item) return;

                        // Abrimos modal y prellenamos
                        abrirModal();

                        // Para permitir reusar el mismo NroSalida, temporalmente liberar su uso
                        usados.delete(item.NroSalida);
                        disableOption(item.NroSalida, false);

                        // Activamos edición manual por defecto (puedes apagarla si deseas usar el select)
                        desactivarEdicion(true);
                        $('#NroSalida_manual').val(item.NroSalida);

                        $('#precinto').val(item.precinto);
                        $('#guia').val(item.guia);
                        $('#bruto').val(item.bruto);
                        $('#tara').val(item.tara);
                        $('#neto').val(item.neto);
                        $('#tracto').val(item.tracto);
                        $('#carreta').val(item.carreta);
                        $('#guia_transporte').val(item.guia_transporte);
                        $('#ruc_empresa').val(item.ruc_empresa);
                        $('#razon_social').val(item.razon_social);
                        $('#licencia').val(item.licencia);
                        $('#conductor').val(item.conductor);

                        editingUid = uid;
                        $btnAdd.text('{{ __("Actualizar fila") }}');
                    });

                });
            </script>

            <!-- Formulario de despacho -->
            <form action="{{ route('despachos.store') }}" method="POST" id="despachoForm">
                @csrf
                <input type="hidden" name="blending_id" value="{{ $blending->id }}">
                <input type="hidden" name="retiros_data" id="retiros_data" value="">
                <div class="mb-3">
                    <label for="totalTMH" class="form-label"><strong>{{ __('TONELAJE TOTAL DESPACHADO TMH') }}</strong></label>
                    <input type="text" class="form-control" id="totalTMH" name="totalTMH" readonly >
                </div>
                    
                <div class="row mt-4">
                    <div class="form-group col-md-4">
                        <label for="masomenos" class="text-muted">{{ __('FALTA (-) Y EXEDE  (+)') }}</label>
                        <input type="text" class="form-control" name="masomenos" readonly >
                    </div>
                    <div class="form-group col-md-4">
                        <label for="fecha" class="text-muted">{{ __('FECHA DESPACHO') }}</label>
                        <input type="date" name="fecha" id="fecha" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="deposito" class="text-muted">{{ __('DEPÓSITO') }}</label>
                        <input type="text" class="form-control" name="deposito" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="destino" class="text-muted">{{ __('DESTINO') }}</label>
                        <input type="text" class="form-control" name="destino" required >
                    </div>  
                    <div class="form-group col-md-8 ">
                        <label for="observacion" class="text-muted">{{ __('OBSERVACION') }}</label>
                        <input type="text" class="form-control" name="observacion">
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ __('GUARDAR DESPACHO') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
