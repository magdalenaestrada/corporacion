@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('LIQUIDACIONES') }}
                        </h6>
                    </div>
                    <div class="col-md-6 text-end">
                        <a class="btn btn-danger btn-sm" href="{{ route('liquidaciones.index') }}">
                            {{ __('VOLVER') }}
                        </a>
                    </div>
                </div>
            </div>
            <head>
                <style>
                     /* Estilo para todos los campos de entrada
                   .form-control {
                        border: 2px solid #34db8a;  /*  Color del borde (en este caso azul)
                    } */
                    /* Estilo específico para el campo con id 'telefono' */
                   /* #total_au {
                        border-color: #e74c3c; /* Color del borde (en este caso rojo) 
                    }*/
                    #peso {
                        border: 2px solid #b2d9f7; 
                    } 
                    #lote {
                        border: 2px solid #b2d9f7; 
                    } 
                     #descripcion {
                        border: 2px solid #b2d9f7; 
                    } 
                    #cotizacion_au {
                        border: 2px solid #b2d9f7; 
                    } 
                    #cotizacion_ag {
                        border: 2px solid #b2d9f7; 
                    } 
                    #cotizacion_cu {
                        border: 2px solid #b2d9f7; 
                    } 
                    #producto {
                        border: 2px solid #b2d9f7; 
                    } 
                    #proteccion_au2 {
                        border: 2px solid #1d568471;
                    } 
                    #proteccion_ag2 {
                        border: 2px solid #1d568471;
                    } 
                    #proteccion_cu2 {
                        border: 2px solid #1d568471;
                    } 
                    #pagable_au2 {
                        border: 2px solid #1d568471;
                    } 
                    #pagable_ag2 {
                        border: 2px solid #1d568471;
                    } 
                    #pagable_cu2 {
                        border: 2px solid #1d568471;
                    } 
                    #deduccion_au2 {
                        border: 2px solid #1d568471;
                    } 
                    #deduccion_ag2 {
                        border: 2px solid #1d568471;
                    } 
                    #deduccion_cu2 {
                        border: 2px solid #1d568471;
                    } 
                    #refinamiento_au2 {
                        border: 2px solid #1d568471;
                    } 
                    #refinamiento_ag2 {
                        border: 2px solid #1d568471;
                    } 
                    #refinamiento_cu2 {
                        border: 2px solid #1d568471;
                    } 
                    #maquila2 {
                        border: 2px solid #1d568471;
                    } 
                    #analisis2 {
                        border: 2px solid #1d568471;
                    } 
                    #estibadores2 {
                        border: 2px solid #1d568471;
                    } 
                    #molienda2 {
                        border: 2px solid #1d568471;
                    } 
                    #penalidad_as2 {
                        border: 2px solid #1d568471;
                    } 
                    #penalidad_sb2 {
                        border: 2px solid #1d568471;
                    } 
                    #penalidad_bi2 {
                        border: 2px solid #1d568471;
                    } 
                    #penalidad_pb2 {
                        border: 2px solid #1d568471;
                    } 
                    #penalidad_hg2 {
                        border: 2px solid #1d568471;
                    } 
                    #penalidad_s2 {
                        border: 2px solid #1d568471;
                    } 
                    #igv2 {
                        border: 2px solid #1d568471;
                    } 


                    
                    #cliente_id {
                        width: 100%;
                        background-color: #b2d9f7;
                        font-weight: bold;
                    }
                    #muestra_id{
                        width: 100%;
                        background-color: #b2d9f7;
                        font-weight: bold;
                    }
                    #tmns{
                        width: 100%;
                        background-color: #b2d9f7;
                        font-weight: bold;
                    }
                    #total{
                        width: 100%;
                        background-color: #b2d9f7;
                        font-weight: bold;
                    }
                    #val_au{
                        border: 2px solid #b2d9f7; 
                    }
                    #val_ag{
                        border: 2px solid #b2d9f7; 
                    }
                    #val_cu{
                        border: 2px solid #b2d9f7; 
                    }
                    #text{
                        width: 100%;
                        background-color: #b2d9f7;
                        font-weight: bold;
                    }
                    #total_valores{
                        width: 100%;
                        background-color: #b2d9f7;
                        font-weight: bold;
                    }
                    #total_deducciones{
                        width: 100%;
                        background-color: #b2d9f7;
                        font-weight: bold;
                    }
                    #total_penalidades{
                        width: 100%;
                        background-color: #b2d9f7;
                        font-weight: bold;
                    }
                    #resumen_id{
                        width: 100%;
                        background-color: #b2d9f7;
                        font-weight: bold;
                    }
                </style>
            </head>
            <div class="card-body">
                <form class="editar-liquidaciones" action="{{ route('liquidaciones.update' , $liquidacion->id) }}" method="POST">
                    @csrf
                    @method('PUT') 
                  
                    
                    <h6><strong>SELECCIONE MUESTRA</strong></h6>
                    <div class="row">
                        <div class="form-group col-md-7">
                            <label for="muestra_id">COD. LABORATORIO</label>
                            <input type="text" name="muestra_id" id="muestra_id"  class="form-control" value = "{{ $liquidacion->muestra->codigo }}" readonly>
                        </div> 
                        <div class="form-group col-md-5">
                            <label for="obs">OBSERVACION</label>
                            <input type="text" name="obs" id="obs" class="form-control" value="{{ old('obs', $muestra->obs) }}" >
                        </div>
                       
                    </div>
                
                        <h6><strong>INGRESE DATOS SECCION RESALTADA</strong></h6>          
                        <div class="row">
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <label for="NroSalida">NRO SALIDA - TICKET</label>
                                    <input type="text" name="NroSalida" id="NroSalida"  class="form-control" value = "{{ $liquidacion->NroSalida }}" readonly>
                                </div> 
                                <div class="form-group col-md-2">
                                    <label for="fechai">FECHA INGRESO</label>
                                    <input type="text" name="fechai" id="fechai" class="form-control" placeholder="" value="{{ old('fechai', $liquidacion->fechai) }}" oninput="calcularTMS()" readonly>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="peso">PESO</label>
                                <input type="text" name="peso" id="peso" class="form-control" placeholder="Ingrese peso" value="{{ old('peso', $liquidacion->peso) }}" oninput="calcularTMS()" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="lote">LOTE</label>
                                <input type="text" name="lote" id="lote" class="form-control" placeholder="Ingrese lote" value="{{ old('lote', $liquidacion->lote) }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="producto">PRODUCTO</label>
                                <input type="text" name="producto" id="producto" class="form-control" placeholder="Ingrese producto" value="{{ old('producto', $liquidacion->producto) }}">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Descripción de Ingreso</label>
                                <input type="text" class="form-control modern-input" value="{{ $descripcionIngreso ?? 'Sin descripción' }}" disabled>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="cotizacion_au">COTIZACION ORO</label>
                                <input type="text" name="cotizacion_au" id="cotizacion_au" class="form-control" placeholder="Ingrese valor" value="{{ old('cotizacion_au', $liquidacion->cotizacion_au) }}" oninput="calcularformulaau()">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="cotizacion_ag">COTIZACION PLATA</label>
                                <input type="text" name="cotizacion_ag" id="cotizacion_ag" class="form-control" placeholder="Ingrese valor" value="{{ old('cotizacion_ag', $liquidacion->cotizacion_ag) }}" oninput="calcularformulaag()">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="cotizacion_cu">COTIZACION COBRE</label>
                                <input type="text" name="cotizacion_cu" id="cotizacion_cu" class="form-control" placeholder="Ingrese valor" value="{{ old('cotizacion_cu', $liquidacion->cotizacion_cu) }}" oninput="calcularformulacu()">
                            </div>
                        </div>
                       <!-- <P>
                            <h6><strong>SECCION ADELANTO</strong></h6>  
                                 <div class="form-group col-md-10">
                                     <label for="resumen_id">RESUMEN ADELANTO</label>
                                     <select name="resumen_id" id="resumen_id" class="form-control select" style="width: 100%;" data-placeholder="Buscar resumen" data-dropdownAutoWidth="true">
                                         <option value="">SELECCIONAR ADELANTO</option>
                                         @foreach($resumens as $resumen)
                                             <option value="{{ $resumen->id }}"
                                                     data-fecha_resumen="{{ $resumen->fecha_resumen }}"
                                                     data-cliente_id="{{ $resumen->cliente_id }}"
                                                     data-usuario_id="{{ $resumen->usuario_id }}"
                                                     data-factura="{{ $resumen->factura }}"
                                                     data-total="{{ $resumen->total }}">
                                                     {{ $resumen->id}}  --  {{ $resumen->cliente->documento_cliente }}    {{ $resumen->cliente->datos_cliente }}      
                                                     @foreach ($resumen->adelantos as $adelanto)
                                                     -- Factura: {{ $adelanto->nrofactura }}
                                                 @endforeach
                                                 --  TOTAL = {{ $resumen->total }}
                                             </option>
                                         @endforeach
                                     </select>
                                 </div> -->
   
                    <P>
                        <h6><strong>CLIENTE A MOSTRAR</strong></h6> 
                        <div class="row"> 
                            <!-- Campo para seleccionar cliente -->
                            

                            <div class="form-group col-md-5">
                                <label for="datos_cliente">DATOS CLIENTES</label>
                                <input type="text" name="datos_cliente" id="datos_cliente" class="form-control" readonly value="{{ $cliente->datos_cliente ?? '' }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="ruc_empresa">RUC EMPRESA</label>
                                <input type="text" name="ruc_empresa" id="ruc_empresa" class="form-control"  value="{{ $cliente->ruc_empresa ?? '' }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="telefono">TELEFONO</label>
                                <input type="text" name="telefono" id="telefono" class="form-control" readonly value="{{ $cliente->telefono ?? '' }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="razon_social">RAZÓN SOCIAL</label>
                                <input type="text" name="razon_social" id="razon_social" class="form-control"  value="{{ $cliente->razon_social ?? '' }}">
                            </div>

                            <div class="form-group col-md-5">
                                <label for="direccion">DIRECCION</label>
                                <input type="text" name="direccion" id="direccion" class="form-control" readonly value="{{ $cliente->direccion ?? '' }}">
                            </div>
                        </div>
<p>
                        <div class="row">
                            <div class="col-md-4">
                                <h6><strong>OBTENIENDO EL TOTAL TMNS</strong></h6>
                                <div class="form-group">
                                    <label for="humedad">HUMEDAD</label>
                                    <div class="input-group">
                                        <input type="text" name="humedad" id="humedad" class="form-control" value="{{ old('humedad', $muestra->humedad) }}" oninput="calcularTMS()">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                
                                <div class="form-group">
                                    <label for="tms">TMS</label>
                                    <input type="text" name="tms" id="tms" class="form-control" value="{{ old('tms', $liquidacion->tms) }}" readonly>
                                </div>
                
                                <div class="form-group">
                                    <label for="merma">MERMA</label>
                                    <div class="d-flex justify-content-between">
                                        <div class="input-group" style="flex: 1; margin-right: 5px;">
                                            <input type="text" name="merma" id="merma" class="form-control" value="{{ old('merma', $liquidacion->cliente->requerimientos->merma) }}" readonly>
                                            <span class="input-group-text">%</span>
                                        </div>
                                        <div class="input-group" style="flex: 1;">
                                            <input type="text" name="merma2" id="merma2" class="form-control" value="{{ old('merma2', $liquidacion->merma2 ?? old('merma', $liquidacion->cliente->requerimientos->merma)) }}" oninput="calcularTMS()">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <label for="tmns"><strong>TONELADAS MÉTRICAS NETAS SECAS</strong></label>
                                    <input type="text" name="tmns" id="tmns" class="form-control text-center"  value="{{ old('tmns', $liquidacion->tmns) }}" readonly>
                                </div>
                            </div>
                
                            <div class="col-md-4">
                                <h6><strong>VALORES</strong></h6>
                                <div class="form-group">
                                    <label for="cu">COBRE</label>
                                    <div class="input-group">
                                        <input type="text" name="cu" id="cu" class="form-control" value="{{ old('cu', $muestra->cu) }}" oninput="calcularLeyes()" >
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                
                                <div class="form-group">
                                    <label for="ag">PLATA</label>
                                    <input type="text" name="ag" id="ag" class="form-control" value="{{ old('ag', $muestra->ag) }}" oninput="calcularLeyes()">
                                </div>
                
                           
                                <div class="form-group">
                                    <label for="au">ORO</label>
                                    <input type="text" name="au" id="au" class="form-control" value="{{ old('au', $muestra->au) }}" oninput="calcularLeyes()" >
                                </div>
                
                                <div class="d-flex justify-content-between">
                                    <!-- Decimales Oro -->
                                    <div class="form-group" style="margin-right: 10px;">
                                        <label for="decimal_count_au"><strong>DECIMALES ORO</strong></label>
                                        <select name="decimal_count_au" id="decimal_count_au" class="form-control" onchange="calcularFormulaAu()">
                                            <option value="2">2 Decimales</option>
                                            <option value="3" selected>3 Decimales</option>
                                        </select>
                                    </div>
                                
                                    <!-- Decimales Plata -->
                                    <div class="form-group">
                                        <label for="decimal_count_ag"><strong>DECIMALES PLATA</strong></label>
                                        <select name="decimal_count_ag" id="decimal_count_ag" class="form-control" onchange="calcularFormulaAg()">
                                            <option value="2">2 Decimales</option>
                                            <option value="3" selected>3 Decimales</option>
                                        </select>
                                    </div>
                                     <!-- Decimales Cobre -->
                                     <div class="form-group">
                                        <label for="decimal_count_cu"><strong>DECIMALES COBRE</strong></label>
                                        <select name="decimal_count_cu" id="decimal_count_cu" class="form-control" onchange="calcularFormulaCu()">
                                            <option value="2"selected>2 Decimales</option>
                                            <option value="3">3 Decimales</option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                
                            <div class="col-md-4">
                                <h6><strong>PROTECCIÓN</strong></h6>
                            
                                <div class="form-group">
                                    <label for="proteccion_cu">PROTECCIÓN COBRE</label>
                                    <div class="d-flex justify-content-between">
                                        <input type="text" name="proteccion_cu" id="proteccion_cu" class="form-control me-2" value="{{ old('proteccion_cu', $cliente->requerimientos->proteccion_cu)}}" style="flex: 1;" readonly>
                                        
                                        <input type="text" name="proteccion_cu2" id="proteccion_cu2" class="form-control" value="{{ old('proteccion_cu2', $liquidacion->proteccion_cu2 ?? old('proteccion_cu', $cliente->requerimientos->proteccion_cu))}}" style="flex: 1;" oninput="calcularformulacu()">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="proteccion_ag">PROTECCIÓN PLATA</label>
                                    <div class="d-flex justify-content-between">
                                        <input type="text" name="proteccion_ag" id="proteccion_ag" class="form-control me-2" value="{{ old('proteccion_ag', $cliente->requerimientos->proteccion_ag)}}" style="flex: 1;" readonly>
                                        
                                        <input type="text" name="proteccion_ag2" id="proteccion_ag2" class="form-control" value="{{ old('proteccion_ag2', $liquidacion->proteccion_ag2 ?? old('proteccion_ag', $cliente->requerimientos->proteccion_ag))}}" style="flex: 1;" oninput="calcularformulaag()">
                                    </div>
                                </div>
                            
                                <div class="form-group">
                                    <label for="proteccion_au">PROTECCIÓN ORO</label>
                                    <div class="d-flex justify-content-between">
                                        <input type="text" name="proteccion_au" id="proteccion_au" class="form-control me-2" value="{{ old('proteccion_au', $cliente->requerimientos->proteccion_au)}}" readonly style="flex: 1;">
                            
                                        <input type="text" name="proteccion_au2" id="proteccion_au2" class="form-control" value="{{ old('proteccion_au2', $liquidacion->proteccion_au2 ?? old('proteccion_au', $cliente->requerimientos->proteccion_au)) }}" style="flex: 1;" oninput="calcularformulaau()">
                                    </div>
                                </div>
                            
                                <h6><strong>OPCIONAL</strong></h6>
                                <div class="d-flex">
                                    <!-- CU -->
                                    <div class="form-group d-flex align-items-center me-3">
                                        <label class="me-1">
                                            <input type="checkbox" id="checkbox_cu" onchange="toggleTextbox(this, 'textbox_cu')"> CU
                                        </label>
                                        <input type="text" id="textbox_cu" name="textbox_cu" class="form-control" disabled style="width: 50px; height: 30px; font-size: 15px; padding: 1px;">
                                    </div>
                                
                                    <!-- AG -->
                                    <div class="form-group d-flex align-items-center me-3">
                                        <label class="me-1">
                                            <input type="checkbox" id="checkbox_ag" onchange="toggleTextbox(this, 'textbox_ag')"> AG
                                        </label>
                                        <input type="text" id="textbox_ag" name="textbox_ag" class="form-control" disabled style="width: 50px; height: 30px; font-size: 15px; padding: 1px;">
                                    </div>
                                
                                    <!-- AU -->
                                    <div class="form-group d-flex align-items-center">
                                        <label class="me-1">
                                            <input type="checkbox" id="checkbox_au" onchange="toggleTextbox(this, 'textbox_au')"> AU
                                        </label>
                                        <input type="text" id="textbox_au" name="textbox_au" class="form-control" disabled style="width: 50px; height: 30px; font-size: 15px; padding: 1px;">
                                    </div>
                                </div>
                            
                            </div>

<script>
    function toggleTextbox(checkbox, textboxId) {
        let textbox = document.getElementById(textboxId);
        textbox.disabled = !checkbox.checked;
    }
</script>
                            
                            <p>   <p>
                                <label for="medio_factor_au"><strong>Medio Factor Au:</strong></label>
                                <input type="checkbox" id="medio_factor_au" name="medio_factor_au">

                                <label for="aplicar_factor_au"><strong>Sin Factor Au:</strong></label>
                                <input type="checkbox" id="aplicar_factor_au" name="aplicar_factor_au">

                                <label for="medio_factor_ag"><strong>Medio Factor Ag:</strong></label>
                                <input type="checkbox" id="medio_factor_ag" name="medio_factor_ag">

                                <label for="aplicar_factor_ag"><strong>Sin Factor Ag:</strong></label>
                                <input type="checkbox" id="aplicar_factor_ag" name="aplicar_factor_ag">

                                <label for="checkboxResultadoFinaCu"><strong>Penalidad Cu:</strong></label>
                                <input type="checkbox" id="checkboxResultadoFinaCu" name="checkboxResultadoFinaCu" onchange="actualizarFinaCu()" oninput="deducciones()">
                                
                                <script>
                                    window.addEventListener('load', function() {
                                        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
                                        checkboxes.forEach(checkbox => {
                                            const checked = localStorage.getItem(checkbox.id) === 'true';
                                            checkbox.checked = checked;
                            
                                            checkbox.addEventListener('change', function() {
                                                localStorage.setItem(checkbox.id, checkbox.checked);
                                            });
                                        });
                                    });
                                </script>
                                <row>
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="ley_cu">LEY COBRE</label>
                                            <div class="input-group">
                                                <input type="text" name="ley_cu" id="ley_cu" class="form-control" value="{{ old('ley_cu', $liquidacion->ley_cu)}}" oninput="calcularformulacu()"> 
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    
                                        <div class="form-group col-md-2">
                                            <label for="pagable_cu"><strong>% PAGABLE COBRE</strong></label>
                                            <div class="d-flex">
                                                <div class="input-group" style="flex: 1;">
                                                    <input type="text" name="pagable_cu" id="pagable_cu" class="form-control" value="{{ old('pagable_cu', $cliente->requerimientos->pagable_cu)}}" readonly >
                                                    <span class="input-group-text small-percent">%</span>
                                                </div>
                                                <div class="input-group" style="flex: 1;">
                                                    <input type="text" name="pagable_cu2" id="pagable_cu2" class="form-control" value="{{ old('pagable_cu2', $liquidacion->pagable_cu2 ?? old('pagable_cu', $cliente->requerimientos->pagable_cu))}}"  oninput="calcularformulacu()" >
                                                    <span class="input-group-text small-percent">%</span>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                    
                                        <div class="form-group col-md-2">
                                            <label for="deduccion_cu"><strong>DED. COBRE</strong></label>
                                            <div class="d-flex">
                                                <div class="input-group me-2" style="flex: 1;">
                                                    <input type="text" name="deduccion_cu" id="deduccion_cu" class="form-control" value="{{ old('deduccion_cu', $cliente->requerimientos->deduccion_cu)}}" readonly >
                                                </div>
                                                <div class="input-group" style="flex: 1;">
                                                    <input type="text" name="deduccion_cu2" id="deduccion_cu2" class="form-control" value="{{ old('deduccion_cu2', $liquidacion->deduccion_cu2 ?? old('deduccion_cu', $cliente->requerimientos->deduccion_cu))}}"  oninput="calcularformulacu()">
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <div class="form-group col-md-2">
                                            <label for="formula_cu"><strong>FÓRMULA</strong></label>
                                            <div class="input-group"> 
                                                <input type="text" name="formula_cu" id="formula_cu" class="form-control" value="{{ old('formula_cu', $liquidacion->formula_cu)}}" oninput="calcularformulacu()">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    
                                        <div class="form-group col-md-2">
                                            <label for="precio_cu"><strong>PRECIO COBRE</strong></label>
                                            <input type="text" name="precio_cu" id="precio_cu" class="form-control" value="{{ old('precio_cu', $liquidacion->precio_cu)}}" oninput="calcularformulacu()">
                                        </div>
                                    
                                        <div class="form-group col-md-2">
                                            <label for="val_cu"><strong>VALOR COBRE</strong></label>
                                            <input type="text" name="val_cu" id="val_cu" class="form-control" value="{{ old('val_cu', $liquidacion->val_cu)}}" oninput="calcularformulacu()">
                                        </div>
                                    </div>
                                    
                             <div class="row">
                                <style>
                                    .small-percent {
                                        font-size: 0.5rem; /* Hacer el porcentaje aún más pequeño */
                                        padding: 0.1rem 0.2rem; /* Reducir el padding para un ajuste más compacto */
                                    }
                                </style>
                            <div class="form-group col-md-2">
                                <label for="ley_ag"><strong>LEY PLATA</strong></label>
                                <input type="text" name="ley_ag" id="ley_ag" class="form-control" value="{{ old('ley_ag', $liquidacion->ley_ag)}}" oninput="calcularformulaag()">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="pagable_ag"><strong>% PAGABLE PLATA</strong></label>
                                <div class="d-flex">
                                    <div class="input-group" style="flex: 1;">
                                        <input type="text" name="pagable_ag" id="pagable_ag" class="form-control" value="{{ old('pagable_ag', $cliente->requerimientos->pagable_ag)}}" readonly  >
                                        <span class="input-group-text small-percent">%</span>
                                    </div>
                                    <div class="input-group" style="flex: 1;">
                                        <input type="text" name="pagable_ag2" id="pagable_ag2" class="form-control" value="{{ old('pagable_ag2', $liquidacion->pagable_ag2 ??  old('pagable_ag', $cliente->requerimientos->pagable_ag)) }}" oninput="calcularformulaag()"  >
                                        <span class="input-group-text small-percent">%</span>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-group col-md-2">
                                <label for="deduccion_ag"><strong>DED. PLATA</strong></label>
                                <div class="d-flex">
                                    <div class="input-group me-2" style="flex: 1;">
                                        <input type="text" name="deduccion_ag" id="deduccion_ag" class="form-control" value="{{ old('deduccion_ag', $cliente->requerimientos->deduccion_ag)}}" readonly>
                                    </div>
                                    <div class="input-group" style="flex: 1;">
                                        <input type="text" name="deduccion_ag2" id="deduccion_ag2" class="form-control" value="{{ old('deduccion_ag2', $liquidacion->deduccion_ag2 ?? old('deduccion_ag', $cliente->requerimientos->deduccion_ag))}}" oninput="calcularformulaag()">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="formula_ag"><strong>FÓRMULA</strong></label>
                                <input type="text" name="formula_ag" id="formula_ag" class="form-control" value="{{ old('formula_ag', $liquidacion->formula_ag)}}" oninput="calcularformulaag()">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="precio_ag"><strong>PRECIO PLATA</strong></label>
                                <input type="text" name="precio_ag" id="precio_ag" class="form-control" value="{{ old('precio_ag', $liquidacion->precio_ag)}}" oninput="calcularformulaag()">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="val_ag"><strong>VALOR PLATA</strong></label>
                                <input type="text" name="val_ag" id="val_ag" class="form-control" value="{{ old('val_ag', $liquidacion->val_ag)}}" oninput="calcularformulaag()">
                            </div>
                        </div>
       
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label for="ley_au"><strong>LEY ORO</strong></label>
                                <input type="text" name="ley_au" id="ley_au" class="form-control" value="{{ old('ley_au', $liquidacion->ley_au)}}" oninput="calcularformulaau()">
                            </div>
                            <div class="form-group col-md-2">   
                                <label for="pagable_au"><strong>% PAGABLE ORO</strong></label>
                                <div class="d-flex">
                                    <div class="input-group" style="flex: 1;">
                                        <input type="text" name="pagable_au" id="pagable_au" class="form-control" value="{{ old('pagable_au', $cliente->requerimientos->pagable_au)}}" readonly  >
                                        <span class="input-group-text small-percent">%</span>
                                    </div>
                                    <div class="input-group" style="flex: 1;">
                                        <input type="text" name="pagable_au2" id="pagable_au2" class="form-control" value="{{ old('pagable_au2', $liquidacion->pagable_au2 ?? old('pagable_au', $cliente->requerimientos->pagable_au))}}" oninput="calcularformulaau()">
                                        <span class="input-group-text small-percent">%</span>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-group col-md-2">
                                <label for="deduccion_au"><strong>DED. ORO</strong></label>
                                <div class="d-flex">
                                    <div class="input-group" style="flex: 1;">
                                        <input type="text" name="deduccion_au" id="deduccion_au" class="form-control" value="{{ old('deduccion_au', $cliente->requerimientos->deduccion_au)}}" readonly >
                                    </div>
                                    <div class="input-group" style="flex: 1;">
                                        <input type="text" name="deduccion_au2" id="deduccion_au2" class="form-control" value="{{ old('deduccion_au2', $liquidacion->deduccion_au2 ?? old('deduccion_au', $cliente->requerimientos->deduccion_au))}}" oninput="calcularformulaau()" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="formula_au"><strong>FÓRMULA</strong></label>
                                <input type="text" name="formula_au" id="formula_au" class="form-control" value="{{ old('formula_au', $liquidacion->formula_au)}}" oninput="calcularformulaau()">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="precio_au"><strong>PRECIO ORO</strong></label>
                                <input type="text" name="precio_au" id="precio_au" class="form-control" value="{{ old('precio_au', $liquidacion->precio_au)}}" oninput="calcularformulaau()">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="val_au"><strong>VALOR ORO</strong></label>
                                <input type="text" name="val_au" id="val_au" class="form-control" value="{{ old('val_au', $liquidacion->val_au)}}" oninput="calcularformulaau()">
                            </div>
                        </div>
                           
                      <div class="row">
                            <div class="form-group col-md-10">
                                <label for="text"><strong></strong></label>
                                <input type="text" name="text" id="text" value= "TOTAL PAGABLE / TM " class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-2" >
                                <label for="total_valores"><strong></strong></label>
                                <input type="text" name="total_valores" id="total_valores" class="form-control" value="{{ old('total_valores', $liquidacion->total_valores)}}" oninput="sumafinal()">
                            </div>
                            <P>
                            <h4><strong>DEDUCCIONES</strong></h4>
                        </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="text"></label>
                                        <input type="text" name="text" id="text" value="REFINACION DE COBRE (CU)" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row justify-content-end">
                                        <div class="form-group col-md-3">
                                            <label for="formula_fi_cu"><strong>FORMULA</strong></label>
                                            <div class="input-group"> 
                                            <input type="text" name="formula_fi_cu" id="formula_fi_cu" class="form-control" value="{{ old('formula_fi_cu', $liquidacion->formula_fi_cu)}}" oninput="deducciones()">
                                            <span class="input-group-text">%</span> 
                                        </div>
                                        </div>
                                        <div class="form-group col-md-3">   
                                            <label for="refinamiento_cu"><strong>REF. COBRE</strong></label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" name="refinamiento_cu" id="refinamiento_cu" class="form-control" value="{{ old('refinamiento_cu', $cliente->requerimientos->refinamiento_cu)}}" oninput="deducciones()" readonly >
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="refinamiento_cu2" id="refinamiento_cu2" class="form-control" value="{{ old('refinamiento_cu2', $liquidacion->refinamiento_cu2 ?? old('refinamiento_cu', $cliente->requerimientos->refinamiento_cu) )}}" oninput="deducciones()"  >
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group col-md-3">
                                            <label for="fina_cu"><strong>$</strong></label>
                                            <input type="text" name="fina_cu" id="fina_cu" class="form-control" value="{{ old('fina_cu', $liquidacion->fina_cu)}}" oninput="deducciones()"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Segunda sección -->
                            <div class="row">
                                <!-- Primer div a la izquierda -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="text"></label>
                                        <input type="text" name="text" id="text" value="REFINACION DE PLATA (AG)" class="form-control" readonly>
                                    </div>
                                </div>
                                <!-- Segunda sección con elementos alineados a la derecha -->
                                <div class="col-md-8">
                                    <div class="row justify-content-end">
                                        <div class="form-group col-md-3">
                                            <label for="formula_fi_ag"><strong>FORMULA</strong></label>
                                            <input type="text" name="formula_fi_ag" id="formula_fi_ag" class="form-control" value="{{ old('formula_fi_ag', $liquidacion->formula_fi_ag)}}" oninput="deducciones()" >
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="refinamiento_ag"><strong>REF. PLATA</strong></label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" name="refinamiento_ag" id="refinamiento_ag" class="form-control" value="{{ old('refinamiento_ag', $cliente->requerimientos->refinamiento_ag)}}" oninput="deducciones()" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="refinamiento_ag2" id="refinamiento_ag2" class="form-control" value="{{ old('refinamiento_ag2', $liquidacion->refinamiento_ag2 ?? old('refinamiento_ag', $cliente->requerimientos->refinamiento_ag))}}" oninput="deducciones()"  >
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group col-md-3">
                                            <label for="fina_ag"><strong>$</strong></label>
                                            <input type="text" name="fina_ag" id="fina_ag" class="form-control" value="{{ old('fina_ag', $liquidacion->fina_ag)}}" oninput="deducciones()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="text"></label>
                                        <input type="text" name="text" id="text" value="REFINACION DE ORO (AU)" class="form-control" readonly>
                                    </div>
                                </div>
                                <!-- Segunda sección con elementos alineados a la derecha -->
                                <div class="col-md-8">
                                    <div class="row justify-content-end">
                                        <div class="form-group col-md-3">
                                            <label for="formula_fi_au"><strong>FORMULA</strong></label>
                                            <input type="text" name="formula_fi_au" id="formula_fi_au" class="form-control" value="{{ old('formula_fi_au', $liquidacion->formula_fi_au)}}" oninput="deducciones()">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="refinamiento_au"><strong>REF. ORO</strong></label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" name="refinamiento_au" id="refinamiento_au" class="form-control" value="{{ old('refinamiento_au', $cliente->requerimientos->refinamiento_au)}}" oninput="deducciones()" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="refinamiento_au2" id="refinamiento_au2" class="form-control" value="{{ old('refinamiento_au2', $liquidacion->refinamiento_au2 ?? old('refinamiento_au', $cliente->requerimientos->refinamiento_au) )}}" oninput="deducciones()" >
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group col-md-3">
                                            <label for="fina_au"><strong>$</strong></label>
                                            <input type="text" name="fina_au" id="fina_au" class="form-control" value="{{ old('fina_au', $liquidacion->fina_au)}}" oninput="deducciones()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                               
                            
                           
                            <div class="row">
                           
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="text"></label>
                                        <input type="text" name="text" id="text" value="MAQUILA" class="form-control" readonly>
                                    </div>
                                </div>
                         
                                <div class="col-md-8">
                                    <div class="row justify-content-end">
                                        <div class="form-group col-md-3">
                                            <label for="maquila"><strong>$</strong></label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" name="maquila" id="maquila" class="form-control" value="{{ old('maquila', $cliente->requerimientos->maquila)}}" oninput="deducciones()" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="maquila2" id="maquila2" class="form-control" value="{{ old('maquila2', $liquidacion->maquila2 ?? old('maquila', $cliente->requerimientos->maquila))}}" oninput="deducciones()"  >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                        </div>
                            
                           <!-- Tercera sección -->
                           <div class="row">
                            <!-- Primer div a la izquierda -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="text"></label>
                                    <input type="text" name="text" id="text" value="ANALISIS" class="form-control" readonly>
                                </div>
                            </div>
                            <!-- Segunda sección con elementos alineados a la derecha -->
                            <div class="col-md-8">
                                <div class="row justify-content-end">

                                    <div class="form-group col-md-3">
                                        <label for="analisis"><strong>VALOR</strong></label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="analisis" id="analisis" class="form-control" value="{{ old('analisis', $cliente->requerimientos->analisis)}}" oninput="deducciones()" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="analisis2" id="analisis2" class="form-control" value="{{ old('analisis2', $liquidacion->analisis2 ?? old('analisis', $cliente->requerimientos->analisis) )}}" oninput="deducciones()" >
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group col-md-3">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="division"><strong>$</strong></label>
                                        <input type="text" name="division" id="division" class="form-control" value="{{ old('division', $liquidacion->division)}}" oninput="deducciones()" >

                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        <div class="row"> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="text"></label>
                                    <input type="text" name="text" id="text" value="ESTIBADORES" class="form-control" readonly>
                                </div>
                            </div>

                            
                            <div class="col-md-8">
                                <div class="row justify-content-end">
                                    <div class="form-group col-md-3">
                                        <label for="estibadores"><strong>VALOR</strong></label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="estibadores" id="estibadores" class="form-control" value="{{ old('estibadores', $cliente->requerimientos->estibadores)}}" oninput="deducciones()" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="estibadores2" id="estibadores2" class="form-control" value="{{ old('estibadores2', $liquidacion->estibadores2 ??  old('estibadores', $cliente->requerimientos->estibadores))}}" oninput="deducciones()"  >
                                            </div>
                                        </div>                           
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="dolar"><strong>TIPO CAMBIO</strong></label>
                                        <input type="text" name="dolar" id="dolar" class="form-control" value="{{ old('dolar', $liquidacion->dolar)}}" oninput="deducciones()">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="resultadoestibadores"><strong>$</strong></label>
                                        <input type="text" name="resultadoestibadores" id="resultadoestibadores" class="form-control" value="{{ old('resultadoestibadores', $liquidacion->resultadoestibadores)}}" oninput="deducciones()">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row"> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="text"></label>
                                    <input type="text" name="text" id="text" value="MOLIENDA" class="form-control" disabled>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="row justify-content-end">
                                    <div class="form-group col-md-3">
                                        <label for="molienda"><strong>VALOR</strong></label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="molienda" id="molienda" class="form-control" value="{{ old('molienda', $cliente->requerimientos->molienda)}}" oninput="deducciones()" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="molienda2" id="molienda2" class="form-control" value="{{ old('molienda2', $liquidacion->molienda2 ?? old('molienda', $cliente->requerimientos->molienda))}}" oninput="deducciones()" >
                                            </div>
                                        </div>
      
                                    </div>
                                    <div class="form-group col-md-3">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="resultadomolienda"><strong>$</strong></label>
                                        <input type="text" name="resultadomolienda" id="resultadomolienda" class="form-control" value="{{ old('resultadomolienda', $liquidacion->resultadomolienda)}}" oninput="deducciones()">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row"> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="text"></label>
                                    <input type="text" name="text" id="text" value="TRANSPORTE" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row justify-content-end">
                                    <div class="form-group col-md-3">
                                        <label for="trans"><strong>VALOR</strong></label>
                                        <div class="input-group"> 
                                        <input type="text" name="trans" id="trans" class="form-control" value="{{ old('trans', $liquidacion->trans)}}" oninput="deducciones()">
                                    </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                    </div>
                                   
                                    <div class="form-group col-md-3">
                                        <label for="transporte"><strong>$</strong></label>
                                        <input type="text" name="transporte" id="transporte" class="form-control" value="{{ old('transporte', $liquidacion->transporte)}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="row">
                                <div class="form-group col-md-10">
                                    <label for="text" style="min-height: 17px;"></label>
                                    <input type="text" name="text" id="text" class="form-control" value="TOTAL DEDUCCIONES" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="total_deducciones"><strong>$</strong></label>
                                    <input type="text" name="total_deducciones" id="total_deducciones" class="form-control" value="{{ old('total_deducciones', $liquidacion->total_deducciones)}}" oninput="sumafinal()" readonly > 
                                </div>
                            </div>
                        <P>
                            <h4><strong>PENALIDADES</strong></h4>
                            <div class="row">
                            
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="text" style="min-height: 17px;"></label>
                                        <input type="text" name="text" id="text" value="AS:" class="form-control" readonly>
                                    </div>
                                </div>
                    <div class="form-group col-md-2">
                        <label for="as">LAB. ARSENICO</label>
                        <input type="text" name="as" id="as" class="form-control" value="{{ old('as', $muestra->as)}}" oninput="penalidades()">
                    </div>
                    <div class="form-group col-md-1">
                        <label for="val_as" style="min-height: 17px;"></label>
                        <input type="text" name="val_as" id="val_as" class="form-control" VALUE="0.100"  oninput="penalidades()" style=" width: 70px;">
                    </div>
    
                    <div class="form-group col-md-2">
                        <label for="penalidad_as">PEN. ARSENICO</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="penalidad_as" id="penalidad_as" class="form-control" value="{{ old('penalidad_as', $cliente->requerimientos->penalidad_as)}}" oninput="penalidades()" style=" width: 70px;">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="penalidad_as2" id="penalidad_as2" class="form-control" value="{{ old('penalidad_as2', $liquidacion->penalidad_as2 ?? old('penalidad_as', $cliente->requerimientos->penalidad_as))}}" oninput="penalidades()" readonly style=" width: 70px;">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-1">
                        <label for="text" style="min-height: 17px;"></label>
                        <input type="text" name="text" id="text" value="$/TMS" class="form-control" readonly style=" width: 80px;">
                    </div>
                    <div class="form-group col-md-1">
                        <label for="pre_as" style="min-height: 17px;"></label>
                        <input type="text" name="pre_as" id="pre_as" class="form-control" VALUE="0.100" oninput="penalidades()" style=" width: 70px;">
                    </div>
                    <div class="col-md-4">
                        <div class="row justify-content-end">
                            <div class="form-group col-md-6">
                        <label for="total_as"><strong>$</strong></label>
                        <input type="text" name="total_as" id="total_as" class="form-control" value="{{ old('total_as', $liquidacion->total_as)}}" oninput="penalidades()">
                    </div>
                </div>      
            </div>   
        </div>   
                    <div class="row">
                        <!-- Primer div a la izquierda -->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="text" style="min-height: 17px;"></label>
                                <input type="text" name="text" id="text" value="SB:" class="form-control" readonly>
                            </div>
                        </div>
                    <div class="form-group col-md-2">
                        <label for="sb">LAB. ANTIMONIO</label>
                        <input type="text" name="sb" id="sb" class="form-control"  value="{{ old('sb', $muestra->sb)}}" oninput="penalidades()">
                    </div>
                    <div class="form-group col-md-1">
                        <label for="val_sb" style="min-height: 17px;"></label>
                        <input type="text" name="val_sb" id="val_sb" class="form-control" VALUE="0.100" oninput="penalidades()" style="width: 70px;">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="penalidad_sb">PEN. ANTIMONIO</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="penalidad_sb" id="penalidad_sb" class="form-control" value="{{ old('penalidad_sb', $cliente->requerimientos->penalidad_sb)}}" oninput="penalidades()" style="width: 70px;">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="penalidad_sb2" id="penalidad_sb2" class="form-control" value="{{ old('penalidad_sb2', $liquidacion->penalidad_sb2 ?? old('penalidad_sb', $cliente->requerimientos->penalidad_sb))}}" oninput="penalidades()" readonly style="width: 70px;">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-1">
                        <label for="text" style="min-height: 17px;"></label>
                        <input type="text" name="text" id="text" value="$/TMS" class="form-control" readonly style="width: 80px;">
                    </div>
                    <div class="form-group col-md-1">
                        <label for="pre_sb" style="min-height: 17px;"></label>
                        <input type="text" name="pre_sb" id="pre_sb" class="form-control" VALUE="0.100" oninput="penalidades()" style="width: 70px;">
                    </div>
                    <div class="col-md-4">
                        <div class="row justify-content-end">
                            <div class="form-group col-md-6">
                        <label for="total_sb"><strong>$</strong></label>
                        <input type="text" name="total_sb" id="total_sb" class="form-control" value="{{ old('total_sb', $liquidacion->total_sb)}}" oninput="penalidades()">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Primer div a la izquierda -->
            <div class="col-md-1">
                <div class="form-group">
                    <label for="text" style="min-height: 17px;"></label>
                    <input type="text" name="text" id="text" value="BI:" class="form-control" readonly>
                </div>
            </div>
            <div class="form-group col-md-2">
                <label for="bi">LAB. BISMUTO</label>
                <input type="text" name="bi" id="bi" class="form-control" value="{{ old('bi', $muestra->bi)}}" oninput="penalidades()">
            </div>
            <div class="form-group col-md-1">
                <label for="val_bi" style="min-height: 17px;"></label>
                <input type="text" name="val_bi" id="val_bi" class="form-control" VALUE="0.050" oninput="penalidades()" style="width: 70px;">
            </div>
            <div class="form-group col-md-2">
                <label for="penalidad_bi">PEN. BISMUTO</label>
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="penalidad_bi" id="penalidad_bi" class="form-control" value="{{ old('penalidad_bi', $cliente->requerimientos->penalidad_bi)}}" oninput="penalidades()" style="width: 70px;">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="penalidad_bi2" id="penalidad_bi2" class="form-control" value="{{ old('penalidad_bi2', $liquidacion->penalidad_bi2 ?? old('penalidad_bi', $cliente->requerimientos->penalidad_bi))}}" oninput="penalidades()" readonly style="width: 70px;">
                    </div>
                </div>
            </div>
            
            <div class="form-group col-md-1">
                <label for="text" style="min-height: 17px;"></label>
                <input type="text" name="text" id="text" value="$/TMS" class="form-control" readonly style="width: 80px;">
            </div>
            <div class="form-group col-md-1">
                <label for="pre_bi" style="min-height: 17px;"></label>
                <input type="text" name="pre_bi" id="pre_bi" class="form-control" VALUE="0.010" oninput="penalidades()" style="width: 70px;">
            </div>
            <div class="col-md-4">
                <div class="row justify-content-end">
                    <div class="form-group col-md-6">
                <label for="total_bi"><strong>$</strong></label>
                <input type="text" name="total_bi" id="total_bi" class="form-control" value="{{ old('total_bi', $liquidacion->total_bi)}}" oninput="penalidades()" > 
            </div>
        </div>
    </div>
    </div>
                <div class="row">
                    <!-- Primer div a la izquierda -->
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="text" style="min-height: 17px;"></label>
                            <input type="text" name="text" id="text" value="PB + ZN:" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="pb">LAB. PB + ZN</label>
                        <input type="text" name="pb" id="pb" class="form-control" value="{{ old('pb', $muestra->pb)}}" oninput="penalidades()">
                    </div>
                    <div class="form-group col-md-1">
                        <label for="val_pb" style="min-height: 17px;"></label>
                        <input type="text" name="val_pb" id="val_pb" class="form-control" VALUE="8.000" oninput="penalidades()" style="width: 70px;">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="penalidad_pb">PEN. PB + ZN</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="penalidad_pb" id="penalidad_pb" class="form-control" value="{{ old('penalidad_pb', $cliente->requerimientos->penalidad_pb)}}" oninput="penalidades()" style="width: 70px;">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="penalidad_pb2" id="penalidad_pb2" class="form-control" value="{{ old('penalidad_pb2', $liquidacion->penalidad_pb2 ?? old('penalidad_pb', $cliente->requerimientos->penalidad_pb) )}}" oninput="penalidades()" readonly style="width: 70px;">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-1">
                        <label for="text" style="min-height: 17px;"></label>
                        <input type="text" name="text" id="text" value="$/TMS" class="form-control" readonly style="width: 80px;">
                    </div>
                    <div class="form-group col-md-1">
                        <label for="pre_pb" style="min-height: 17px;"></label>
                        <input type="text" name="pre_pb" id="pre_pb" class="form-control" VALUE="1.000" oninput="penalidades()" style="width: 70px;">
                    </div>
                    <div class="col-md-4">
                        <div class="row justify-content-end">
                            <div class="form-group col-md-6">
                        <label for="total_pb"><strong>$</strong></label>
                        <input type="text" name="total_pb" id="total_pb" class="form-control" value="{{ old('total_pb', $liquidacion->total_pb)}}" oninput="penalidades()">
                    </div>
                </div>
            </div>
        </div>
                    <div class="row">

        </div>          
                    <div class="row">
                        <!-- Primer div a la izquierda -->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="text" style="min-height: 17px;"></label>
                                <input type="text" name="text" id="text" value="HG:" class="form-control" readonly>
                            </div>
                        </div>
                    <div class="form-group col-md-2">
                        <label for="hg">LAB. MERCURIO</label>
                        <input type="text" name="hg" id="hg" class="form-control" value="{{ old('hg', $muestra->hg)}}" oninput="penalidades()">
                    </div>
                    <div class="form-group col-md-1">
                        <label for="val_hg" style="min-height: 17px;"></label>
                        <input type="text" name="val_hg" id="val_hg" class="form-control" VALUE="30.000" oninput="penalidades()" style="width: 70px;">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="penalidad_hg">PEN. MERCURIO</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="penalidad_hg" id="penalidad_hg" class="form-control" value="{{ old('penalidad_hg', $cliente->requerimientos->penalidad_hg)}}" oninput="penalidades()" style="width: 70px;">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="penalidad_hg2" id="penalidad_hg2" class="form-control" value="{{ old('penalidad_hg2', $liquidacion->penalidad_hg2 ?? old('penalidad_hg', $cliente->requerimientos->penalidad_hg) )}}" oninput="penalidades()" readonly style="width: 70px;">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-1">
                        <label for="text" style="min-height: 17px;"></label>
                        <input type="text" name="text" id="text" value="$/TMS" class="form-control" readonly style="width: 80px;">
                    </div>
                    <div class="form-group col-md-1">
                        <label for="pre_hg" style="min-height: 17px;"></label>
                        <input type="text" name="pre_hg" id="pre_hg" class="form-control" VALUE="20.000" oninput="penalidades()" style="width: 70px;">
                    </div>
                    <div class="col-md-4">
                        <div class="row justify-content-end">
                            <div class="form-group col-md-6">
                        <label for="total_hg"><strong>$</strong></label>
                        <input type="text" name="total_hg" id="total_hg" class="form-control" value="{{ old('total_hg', $liquidacion->total_hg)}}" oninput="penalidades()">
                    </div>
                </div>
            </div>
        </div> 
        <!--azufre obtiene valor de h2o-->
                    <div class="row">
                        <!-- Primer div a la izquierda -->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="text" style="min-height: 17px;"></label>
                                <input type="text" name="text" id="text" value="H2O:" class="form-control" readonly>
                            </div>
                        </div>
                        <!--AZUFRE PANTALLA DE H2O-->
                    <div class="form-group col-md-2">
                        <label for="s" >LAB. H2O</label>
                        <input type="text" name="s" id="s" class="form-control" value="{{ old('s', $muestra->s)}}" oninput="penalidades()">
                    </div>
                    <div class="form-group col-md-1">
                        <label for="val_s" style="min-height: 17px;"></label>
                        <input type="text" name="val_s" id="val_s" class="form-control" VALUE="0.000" oninput="penalidades()" style="width: 70px;">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="penalidad_s">PENALIDAD H2O</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="penalidad_s" id="penalidad_s" class="form-control" value="{{ old('penalidad_s', $cliente->requerimientos->penalidad_s)}}" oninput="penalidades()" style="width: 70px;">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="penalidad_s2" id="penalidad_s2" class="form-control" value="{{ old('penalidad_s2', $liquidacion->penalidad_s2 ?? old('penalidad_s', $cliente->requerimientos->penalidad_s))}}" oninput="penalidades()" readonly style="width: 70px;">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-1">
                        <label for="text" style="min-height: 17px;"></label>
                        <input type="text" name="text" id="text" value="$/TMS" class="form-control" readonly style="width: 80px;">
                    </div>
                    <div class="form-group col-md-1">
                        <label for="pre_s" style="min-height: 17px;"></label>
                        <input type="text" name="pre_s" id="pre_s" class="form-control" VALUE="1.000" oninput="penalidades()" style="width: 70px;">
                    </div>
                    <div class="col-md-4">
                        <div class="row justify-content-end">
                            <div class="form-group col-md-6">
                        <label for="total_s"><strong>$</strong></label>
                        <input type="text" name="total_s" id="total_s" class="form-control" value="{{ old('total_s', $liquidacion->total_s)}}" oninput="penalidades()"> 
                    </div>
                </div>
            </div>
        </div>
                <div class="row">
                </div>  

                <div class="row">
                    <div class="form-group col-md-10  ">
                        <label for="text" style="min-height: 17px;"></label>
                        <input type="text" name="text" id="text" class="form-control" value="TOTAL PENALIDADES" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="total_penalidades"><strong>$</strong></label>
                        <input type="text" name="total_penalidades" id="total_penalidades" class="form-control" value="{{ old('total_penalidades', $liquidacion->total_penalidades)}}" oninput="sumafinal()">
                    </div>
                </div>
                        <div class="row justify-content-end">
                            <div class="form-group col-md-2">
                                <label for="text" style="min-height: 17px;"></label>
                                <input type="text" name="text" id="text" class="form-control text-right" value="TOTAL US$/TM" readonly >
                            </div>
                            <div class="form-group col-md-2">
                                <label for="total_us" style="min-height: 17px;"><strong>$</strong></label>
                                <input type="text" name="total_us" id="total_us" class="form-control text-right" value="{{ old('total_us', $liquidacion->total_us)}}" >
                            </div></div>
                        <div class="row justify-content-end">
                            <div class="form-group col-md-2">
                                <label for="text" style="min-height: 17px;"></label>
                                <input type="text" name="text" id="text" class="form-control text-right" value="VALOR POR LOTE US$" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="valorporlote"><strong>$</strong></label>
                                <input type="text" name="valorporlote" id="valorporlote" class="form-control text-right" value="{{ old('valorporlote', $liquidacion->valorporlote)}}">
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="form-group col-md-1">
                                <label for="text" style="min-height: 17px;"></label>
                                <input type="text" name="text" id="text" class="form-control text-right" value="IGV" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="igv" style="min-height: 17px;"><strong></strong></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="text" name="igv" id="igv" class="form-control text-right" value="{{ old('igv', $cliente->requerimientos->igv)}}" oninput="sumafinal()" readonly>
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input 
                                                type="text" 
                                                name="igv2" 
                                                id="igv2" 
                                                class="form-control text-right" 
                                                value="{{ old('igv2', $liquidacion->igv2  ?? old('igv', $cliente->requerimientos->igv ))}}" 
                                                oninput="validarIGV(); sumafinal()" 
                                            >
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="form-group col-md-2">
                                <label for="valor_igv"><strong>$</strong></label>
                                <input type="text" name="valor_igv" id="valor_igv" class="form-control text-right" value="{{ old('valor_igv', $liquidacion->valor_igv)}}" oninput="sumafinal()">
                            </div>
                        </div>
                        
                        <!-- Mensaje de error -->
                        <div class="row justify-content-end">
                            <div class="col-md-6 offset-md-4">
                                <small id="igv2-error" class="text-danger" style="display: none;">El valor del IGV debe ser 18 o 0.</small>
                            </div>
                        </div>
                        

                        <div class="row justify-content-end">
                            <div class="form-group col-md-2">
                                <label for="text" style="min-height: 17px;"></label>
                                <input type="text" name="text" id="text" class="form-control text-right" value="TOTAL DE LIQUIDACION %" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="total_porcentajeliqui"><strong>$</strong></label>
                                <input type="text" name="total_porcentajeliqui" id="total_porcentajeliqui" class="form-control text-right" value="{{ old('total_porcentajeliqui', $liquidacion->total_porcentajeliqui)}}" oninput="sumafinal()">
                            </div>
                        </div>
                        <input type="hidden" name="adelantosData" id="adelantosData">
                                <div class="row justify-content-end">
                                    <div class="form-group col-md-2">
                                        <label for="text" style="min-height: 17px;"></label>
                                        <input type="text" name="text" id="text" class="form-control text-right" value="ADELANTOS" readonly>
                                    </div>
                                
                                    <div class="form-group col-md-2">
                                        <label for="adelantos"><strong>$</strong></label>
                                        <div class="input-group">
                                            <input type="text" name="adelantos" id="adelantos" class="form-control text-right"
                                            value="{{ old('adelantos', $liquidacion->adelantos) }}" oninput="sumafinal()">
                        
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#adelantosModal">+</button>
                                            </div>
                                        </div>
                           
                        </div>
                       
                        <!-- Modal -->
                        <div class="modal fade" id="adelantosModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel">Agregar Adelantos</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Formulario para agregar adelantos -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="referencia" class="form-label">Factura</label>
                                                <input type="text" class="form-control" id="referencia">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="monto" class="form-label">Monto</label>
                                                <input type="number" class="form-control" id="monto">
                                            </div>
                                            <div class="col-md-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-success w-100" onclick="agregarAdelanto()">Agregar</button>
                                            </div>
                                        </div>
                        
                                       
                                        <!-- Tabla dentro del modal -->
                                        <h5 class="mt-3">Lista de Adelantos</h5>
                                        <table class="table table-bordered mt-2">
                                            <thead>
                                                <tr>
                                                    <th>Referencia</th>
                                                    <th>Monto</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tablaAdelantos">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            document.querySelector('.editar-liquidaciones').addEventListener('submit', function() {
                                let inputHidden = document.getElementById('adelantosData');
                                if (inputHidden) {
                                    inputHidden.value = JSON.stringify(adelantos);
                                    console.log('Formulario enviado con adelantosData:', inputHidden.value);
                                } else {
                                    console.error('Error: Input adelantosData no encontrado antes de enviar el formulario.');
                                }
                            });
                        </script>
                    </div>
                        <div class="row justify-content-end">
                            <div class="form-group col-md-2">
                                <label for="text" style="min-height: 17px;"></label>
                                <input type="text" name="text" id="text" class="form-control text-right" value="SALDO" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="saldo"><strong>$</strong></label>
                                <input type="text" name="saldo" id="saldo" class="form-control text-right" value="{{ old('saldo', $liquidacion->saldo)}}" oninput="sumafinal()">
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="form-group col-md-2">
                                <label for="text" style="min-height: 17px;"></label>
                                <input type="text" name="text" id="text" class="form-control text-right" value="DETRACCION 10%" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="detraccion"><strong>$</strong></label>
                                <input type="text" name="detraccion" id="detraccion" class="form-control text-right" value="{{ old('detraccion', $liquidacion->detraccion)}}" oninput="sumafinal()">
                            </div>
                        </div>
                        
                        <div class="row justify-content-end">
                            <div class="form-group col-md-2">
                                <label for="text"style="min-height: 17px;" ></label>
                                <input type="text" name="text" id="text" class="form-control text-right" value="TOTAL LIQUIDACION " readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="total_liquidacion"><strong>$</strong></label>
                                <input type="text" name="total_liquidacion" id="total_liquidacion" class="form-control text-right" value="{{ old('total_liquidacion', $liquidacion->total_liquidacion)}}" oninput="sumafinal()">
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="form-group col-md-4">
                                <label for="text1" style="min-height: 17px;"></label>
                                <input type="text" name="text1" id="text1" class="form-control text-center" value="DESCUENTOS ADICIONALES" readonly>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="form-group col-md-2">
                                <label for="text" style="min-height: 17px;"></label>
                                <input type="text" name="text" id="text" class="form-control text-right" value="SALDO NEGATIVO" style="color: red; font-weight: bold;" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="pendientes"><strong>$</strong></label>
                                <input type="text" name="pendientes" id="pendientes" class="form-control text-danger text-right" value="{{ old('pendientes', $liquidacion->pendientes)}}" oninput="sumafinal()">
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="form-group col-md-2">
                                <label for="text" style="min-height: 17px;"></label>
                                <input type="text" name="text" id="text" class="form-control text-right" value="PROCESO DE PLANTA" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="procesoplanta"><strong>$</strong></label>
                                <input type="text" name="procesoplanta" id="procesoplanta" class="form-control" placeholder="" value="{{ old('procesoplanta', $liquidacion->procesoplanta)}}" oninput="sumafinal()">
                            </div>
                        </div>

                    <div class="row justify-content-end">
                        <div class="form-group col-md-2">
                            <label for="text" style="min-height: 17px;"></label>
                            <input type="text" name="text" id="text" class="form-control text-right" value="ADELANTOS" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="adelantosextras"><strong>$</strong></label>
                            <input type="text" name="adelantosextras" id="adelantosextras" class="form-control" placeholder="" value="{{ old('adelantosextras', $liquidacion->adelantosextras)}}" oninput="sumafinal()">
                        </div>
                    </div>

                        <div class="row justify-content-end">
                            <div class="form-group col-md-2">
                                <label for="text" style="min-height: 17px;"></label>
                                <input type="text" name="text" id="text" class="form-control text-right" value="PRESTAMOS" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="prestamos"><strong>$</strong></label>
                                <input type="text" name="prestamos" id="prestamos" class="form-control" placeholder="" value="{{ old('prestamos', $liquidacion->prestamos)}}" oninput="sumafinal()"> 
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="form-group col-md-2">
                                <label for="text" style="min-height: 17px;"></label>
                                <input type="text" name="text" id="text" class="form-control text-right" value="OTROS DESCUENTOS" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="otros_descuentos"><strong>$</strong></label>
                                <input type="text" name="otros_descuentos" id="otros_descuentos" class="form-control" placeholder="" value="{{ old('otros_descuentos', $liquidacion->otros_descuentos)}}" oninput="sumafinal()"> 
                        </div>
                    </div>
                        <div class="row justify-content-end">
                            <div class="form-group col-md-2">
                                <label for="text" style="min-height: 17px;"></label>
                                <input type="text" name="text" id="text" class="form-control text-right" value="TOTAL" readonly>
                            </div>
                            
                            <div class="form-group col-md-2">
                                <label for="total"><strong>$</strong></label>
                                <input type="text" name="total" id="total" class="form-control text-right" value="{{ old('total', $liquidacion->total)}}"> 
                            </div>
                       
                        <div class="row justify-content-end">
            
                            <div class="form-group col-md-2">
                                <label for="text " style="min-height: 17px;"></label>
                                <input type="text" name="text" id="text" class="form-control text-right" value="OBSERVACION" readonly>
                            </div>       
            
                            <div class="form-group col-md-10">
                                <label for="comentario">COMENTARIO</label>
                                <textarea name="comentario" id="comentario" class="form-control" rows="3" >{{ old('comentario', $liquidacion->comentario)}} </textarea>
                            </div>
                                               


                    <div class="form-group col-md-12 text-center g-3">
                        <button type="submit" class="btn btn-primary" id="confirmarCierre">
                            {{ __('CREAR CIERRE LIQUIDACION') }}
                        </button>
                    </div>    
                   
                    

                    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                
    
    <script>
        document.getElementById('confirmarCierre').addEventListener('click', function(e) {
            e.preventDefault(); // Prevenir el envío inmediato del formulario
            const form = this.closest('form'); // Obtener el formulario más cercano

            Swal.fire({
                title: '¿Crear cierre de liquidación?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, confirmar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Envía el formulario si se confirma
                }   
            });
        });
    </script>
<script>
    $(document).ready(function() {
        $('#resumen_id').change(function() {
            var selectedOption = $(this).find(':selected');
            var total = selectedOption.data('total');
            $('#adelantos').val(total);
        });
    });
</script>

    <script>
        //OBTENIENDO TMS Y TMNS
        function calcularTMS() {
            const pesoInput = document.getElementById('peso');
            const humedadInput = document.getElementById('humedad');
            const merma2Input = document.getElementById('merma2');
            const tmsInput = document.getElementById('tms');
            const tmnsInput = document.getElementById('tmns');

            const peso = parseFloat(pesoInput.value) || 0; 
            const humedad = parseFloat(humedadInput.value) || 0;
            const tms = peso - (peso * humedad / 100);
            const tmsRedondeado = Math.round(tms * 1000) / 1000;
            tmsInput.value = tmsRedondeado === '' ? '' : tmsRedondeado.toFixed(3);

            const merma2 = parseFloat(merma2Input.value) || 0;
            const merma = merma2;
            document.getElementById('merma').value = merma;
            const tmns = tmsRedondeado - (tmsRedondeado * merma2 / 100);
            const tmnsRedondeado = Math.round(tmns * 1000 ) / 1000;
            tmnsInput.value = tmnsRedondeado === '' ? '' : tmnsRedondeado.toFixed(3);
            deducciones();
        }
    </script>
       <script>
        document.addEventListener('DOMContentLoaded', function() {
            function calcularLeyes() {
                // Obtener valores de los inputs
                var au = parseFloat(document.getElementById('au').value) || 0;
                var ag = parseFloat(document.getElementById('ag').value) || 0;
                var cu = parseFloat(document.getElementById('cu').value) || 0;
        
                // Obtener estados de los checkboxes
                var aplicarFactorAu = document.getElementById('aplicar_factor_au').checked;
                var medioFactorAu = document.getElementById('medio_factor_au').checked;
                
                var aplicarFactorAg = document.getElementById('aplicar_factor_ag').checked;
                var medioFactorAg = document.getElementById('medio_factor_ag').checked;
        
                // Calcular ley AU
                let factorAu = 1.1023; // Factor completo por defecto
                if (medioFactorAu) factorAu = 1.0511; // Medio factor
                if (aplicarFactorAu) factorAu = 1; // Sin factor
        
                var ley_au = au * factorAu;
                document.getElementById('ley_au').value = ley_au.toFixed(3);
        
                // Calcular ley AG
                let factorAg = 1.1023; // Factor completo por defecto
                if (medioFactorAg) factorAg = 1.0511; // Medio factor
                if (aplicarFactorAg) factorAg = 1; // Sin factor
        
                var ley_ag = ag * factorAg;
                document.getElementById('ley_ag').value = ley_ag.toFixed(3);
        
                // Calcular ley CU (sin factor)
                var ley_cu = cu;
                document.getElementById('ley_cu').value = ley_cu.toFixed(2);
        
                // Llamar a las funciones adicionales
                calcularformulaau();
                calcularformulaag();
                calcularformulacu();
            }
        
            // Manejar cambios en los inputs y checkboxes
            document.getElementById('au').addEventListener('input', calcularLeyes);
            document.getElementById('ag').addEventListener('input', calcularLeyes);
            document.getElementById('cu').addEventListener('input', calcularLeyes);
        
            document.getElementById('aplicar_factor_au').addEventListener('change', calcularLeyes);
            document.getElementById('medio_factor_au').addEventListener('change', calcularLeyes);
        
            document.getElementById('aplicar_factor_ag').addEventListener('change', calcularLeyes);
            document.getElementById('medio_factor_ag').addEventListener('change', calcularLeyes);
        });
        </script>
      <script>
        let manualFormulaAU = false; // Variable para detectar si el usuario ingresó manualmente
    
        function calcularformulaau() {
            var ley_au = parseFloat(document.getElementById('ley_au').value) || 0;
            var cotizacion_au = parseFloat(document.getElementById('cotizacion_au').value) || 0;
            var pagable_au2 = parseFloat(document.getElementById('pagable_au2').value) || 0;
            var deduccion_au2 = parseFloat(document.getElementById('deduccion_au2').value) || 0;
            var proteccion_au2 = parseFloat(document.getElementById('proteccion_au2').value) || 0;
    
            var textbox_au = parseFloat(document.getElementById('textbox_au').value) || 0;
            var decimalCount = parseInt(document.getElementById('decimal_count_au').value) || 3;
    
            function redondear(valor, decimales) {
                const factor = Math.pow(10, decimales);
                return Math.round(valor * factor) / factor;
            }
            function truncar(valor, decimales) {
                    const factor = Math.pow(10, decimales);
                    return Math.floor(valor * factor) / factor;
                }
    
            var formula_au;
            if (!manualFormulaAU) { // Solo recalcular si el usuario no ingresó manualmente
                if (cotizacion_au > 0) {
                    formula_au = truncar(((ley_au * pagable_au2 / 100) - deduccion_au2), decimalCount);
                    if (textbox_au > ley_au) {
                        formula_au = 0;
                    }
                    document.getElementById('formula_au').value = formula_au.toFixed(decimalCount);
                } else {
                    formula_au = 0;
                    document.getElementById('formula_au').value = '0.000';
                }
            } else {
                formula_au = parseFloat(document.getElementById('formula_au').value) || 0;
            }
    
            var proteccion_au = proteccion_au2;
            document.getElementById('proteccion_au').value = proteccion_au;
            var pagable_au = pagable_au2;
            document.getElementById('pagable_au').value = pagable_au;
            var deduccion_au = deduccion_au2;
            document.getElementById('deduccion_au').value = deduccion_au;
    
            var formula_fi_au = formula_au;
            document.getElementById('formula_fi_au').value = formula_fi_au.toFixed(decimalCount);
    
            var precio_au;
            if (cotizacion_au > 0 && proteccion_au2 > 0) {
                precio_au = redondear((cotizacion_au - proteccion_au2), decimalCount);
                document.getElementById('precio_au').value = precio_au.toFixed(decimalCount);
            } else {
                precio_au = 0;
                document.getElementById('precio_au').value = '0.000';
            }
    
            var val_au = (precio_au > 0 && formula_au > 0) ? redondear(precio_au * formula_au, decimalCount) : 0;
            if (textbox_au > ley_au) {
                val_au = 0;
            }
    
            document.getElementById('val_au').value = val_au.toFixed(decimalCount);
    
            totalpagableleyes();
            deducciones();
            sumafinal();
        }
    
        // Evento para detectar cuando el usuario ingresa manualmente en formula_au
        document.getElementById('formula_au').addEventListener('input', function() {
            manualFormulaAU = true;
        });
    
        // Eventos para recalcular cuando otros valores cambien
        document.getElementById('cotizacion_au').addEventListener('input', calcularformulaau);
        document.getElementById('proteccion_au2').addEventListener('input', calcularformulaau);
        document.getElementById('textbox_au').addEventListener('input', calcularformulaau);
        document.getElementById('decimal_count_au').addEventListener('change', calcularformulaau);
    </script>
    
        <script>
            function calcularformulaag() {
                var ley_ag = parseFloat(document.getElementById('ley_ag').value) || 0;
                var cotizacion_ag = parseFloat(document.getElementById('cotizacion_ag').value) || 0;
                var pagable_ag2 = parseFloat(document.getElementById('pagable_ag2').value) || 0;
                var deduccion_ag2 = parseFloat(document.getElementById('deduccion_ag2').value) || 0;
                var proteccion_ag2 = parseFloat(document.getElementById('proteccion_ag2').value) || 0;

                // Obtener el valor del textbox_ag
                var textbox_ag = parseFloat(document.getElementById('textbox_ag').value) || 0;

                var decimalCount = parseInt(document.getElementById('decimal_count_ag').value) || 3;

                // Función para redondear a los decimales especificados
                function redondear(valor, decimales) {
                    const factor = Math.pow(10, decimales);
                    return Math.round(valor * factor) / factor;
                }
                function truncar(valor, decimales) {
                    const factor = Math.pow(10, decimales);
                    return Math.floor(valor * factor) / factor;
                }

                var formula_ag;
                if (cotizacion_ag > 0) {
                    formula_ag = truncar(((ley_ag * pagable_ag2 / 100) - deduccion_ag2), decimalCount);
                    
                    // Si textbox_ag es mayor que ley_ag, el resultado debe ser 0.000
                    if (textbox_ag > ley_ag) {
                        formula_ag = 0;
                    }

                    document.getElementById('formula_ag').value = formula_ag.toFixed(decimalCount);
                } else {
                    formula_ag = 0;
                    document.getElementById('formula_ag').value = '0.000';
                }

                var proteccion_ag = proteccion_ag2;
                document.getElementById('proteccion_ag').value = proteccion_ag;
                var pagable_ag = pagable_ag2;
                document.getElementById('pagable_ag').value = pagable_ag;
                var deduccion_ag = deduccion_ag2;
                document.getElementById('deduccion_ag').value = deduccion_ag;

                var formula_fi_ag = formula_ag;
                document.getElementById('formula_fi_ag').value = formula_fi_ag.toFixed(decimalCount);

                var precio_ag;
                if (cotizacion_ag > 0 && proteccion_ag >= 0) {
                    precio_ag = redondear((cotizacion_ag - proteccion_ag), decimalCount);
                    document.getElementById('precio_ag').value = precio_ag.toFixed(decimalCount);
                } else {
                    precio_ag = 0;
                    document.getElementById('precio_ag').value = '0.000';
                }

                var val_ag = (precio_ag > 0 && formula_ag > 0) ? redondear(precio_ag * formula_ag, decimalCount) : 0;

                // Si textbox_ag es mayor que ley_ag, val_ag debe ser 0.000
                if (textbox_ag > ley_ag) {
                    val_ag = 0;
                }

                document.getElementById('val_ag').value = val_ag.toFixed(decimalCount);

                totalpagableleyes();
                deducciones();
                sumafinal();
            }

            // Agregar eventos para recalcular cuando textbox_ag cambie
            document.getElementById('cotizacion_ag').addEventListener('input', calcularformulaag);
            document.getElementById('proteccion_ag2').addEventListener('input', calcularformulaag);
            document.getElementById('textbox_ag').addEventListener('input', calcularformulaag); // Nuevo evento
            document.getElementById('decimal_count_ag').addEventListener('change', calcularformulaag);
        </script>
<script>
    function calcularformulacu() {
     var ley_cu = parseFloat(document.getElementById('ley_cu').value) || 0;
     var cotizacion_cu = parseFloat(document.getElementById('cotizacion_cu').value) || 0;
     var pagable_cu2 = parseFloat(document.getElementById('pagable_cu2').value) || 0;
     var deduccion_cu2 = parseFloat(document.getElementById('deduccion_cu2').value) || 0;
     var proteccion_cu2 = parseFloat(document.getElementById('proteccion_cu2').value) || 0;
 
     // Obtener el valor del textbox_cu
     var textbox_cu = parseFloat(document.getElementById('textbox_cu').value) || 0;
 
     var decimalCount = parseInt(document.getElementById('decimal_count_cu').value) || 2;
 
     // Función para redondear a los decimales especificados
     function redondear(valor, decimales) {
         const factor = Math.pow(10, decimales);
         return Math.floor(valor * factor) / factor;
     }
 
     var formula_cu;
     if (cotizacion_cu > 0) {
         formula_cu = (((ley_cu * pagable_cu2 / 100) - deduccion_cu2));
 
         // Si textbox_cu es mayor que ley_cu, el resultado debe ser 0.000
         if (textbox_cu > ley_cu) {
             formula_cu = 0;
         }
 
         document.getElementById('formula_cu').value = formula_cu.toFixed(decimalCount);
     } else {
         formula_cu = 0; 
         document.getElementById('formula_cu').value = '0.000';
     }
 
     var proteccion_cu = proteccion_cu2;
     document.getElementById('proteccion_cu').value = proteccion_cu;
     var pagable_cu = pagable_cu2;
     document.getElementById('pagable_cu').value = pagable_cu;
     var deduccion_cu = deduccion_cu2;
     document.getElementById('deduccion_cu').value = deduccion_cu;
 
     var formula_fi_cu = formula_cu;
     document.getElementById('formula_fi_cu').value = formula_fi_cu.toFixed(decimalCount);
 
     var precio_cu;
     if (cotizacion_cu > 0 && proteccion_cu2 > 0) {
         precio_cu = redondear((cotizacion_cu - proteccion_cu2) * 2204.62, decimalCount);
         document.getElementById('precio_cu').value = precio_cu.toFixed(decimalCount);
     } else {
         precio_cu = 0; 
         document.getElementById('precio_cu').value = '0.000';
     }
 
     var val_cu = (precio_cu > 0 && formula_cu > 0) ? redondear(precio_cu * formula_cu / 100, decimalCount) : 0;
 
     // Si textbox_cu es mayor que ley_cu, val_cu debe ser 0.000
     if (textbox_cu > ley_cu) {
         val_cu = 0;
     }
 
     document.getElementById('val_cu').value = val_cu.toFixed(decimalCount);
 
     totalpagableleyes();
     deducciones();
     sumafinal();
 }
 
 // Agregar eventos para recalcular cuando textbox_cu cambie
 document.getElementById('cotizacion_cu').addEventListener('input', calcularformulacu);
 document.getElementById('proteccion_cu2').addEventListener('input', calcularformulacu);
 document.getElementById('textbox_cu').addEventListener('input', calcularformulacu); // Nuevo evento
 document.getElementById('decimal_count_cu').addEventListener('change', calcularformulacu);
 
         </script>
    <script>
    function totalpagableleyes(){
        var val_au = parseFloat(document.getElementById('val_au').value) || 0;
        var val_ag = parseFloat(document.getElementById('val_ag').value) || 0;
        var val_cu = parseFloat(document.getElementById('val_cu').value) || 0;
    
        var total_valores = val_au + val_ag + val_cu;
        document.getElementById('total_valores').value = total_valores.toFixed(3);
        sumafinal();
    }
    </script>
<!--
<script>
function deducciones() {
    // Obtener los valores de cotización y refinamiento
    var cotizacion_au = parseFloat(document.getElementById('cotizacion_au').value) || 0;
    var cotizacion_ag = parseFloat(document.getElementById('cotizacion_ag').value) || 0;
    var cotizacion_cu = parseFloat(document.getElementById('cotizacion_cu').value) || 0;

    var formula_fi_au = parseFloat(document.getElementById('formula_fi_au').value) || 0;
    var refinamiento_au2 = parseFloat(document.getElementById('refinamiento_au2').value) || 0;

    var fina_au = (formula_fi_au > 0 && refinamiento_au2 > 0) ? Math.round(formula_fi_au * refinamiento_au2 * 1000) / 1000 : 0;
    document.getElementById('fina_au').value = fina_au.toFixed(3);

    // Para AG
    var formula_fi_ag = parseFloat(document.getElementById('formula_fi_ag').value) || 0;
    var refinamiento_ag2 = parseFloat(document.getElementById('refinamiento_ag2').value) || 0;

    var fina_ag = (formula_fi_ag > 0 && refinamiento_ag2 > 0) ? Math.round(formula_fi_ag * refinamiento_ag2 * 1000) / 1000 : 0;
    document.getElementById('fina_ag').value = fina_ag.toFixed(3);

    // Para CU
    var formula_fi_cu = parseFloat(document.getElementById('formula_fi_cu').value) || 0;
    var refinamiento_cu2 = parseFloat(document.getElementById('refinamiento_cu2').value) || 0;
    var checkboxEstado = document.getElementById('checkboxResultadoFinaCu').checked;

    // Si cotizacion_cu es 0 y el checkbox está marcado, asignamos 69 a fina_cu
    if (cotizacion_cu === 0 && checkboxEstado) {
        document.getElementById('fina_cu').value = 69.90;
    } else {
        // Si cotizacion_cu no es 0 o el checkbox está desmarcado, calculamos fina_cu
        if (formula_fi_cu > 0 && refinamiento_cu2 > 0) {
            var fina_cu = Math.round(formula_fi_cu * 2204.62 / 100 * refinamiento_cu2 * 1000) / 1000;
            document.getElementById('fina_cu').value = fina_cu.toFixed(3);
        } else {
            document.getElementById('fina_cu').value = 0; // Si no se cumplen las condiciones, asignamos 0
        }
    }

    // Otros cálculos
    var maquila2 = parseFloat(document.getElementById('maquila2').value) || 0;
    var analisis2 = parseFloat(document.getElementById('analisis2').value) || 0;

    var tmns = parseFloat(document.getElementById('tmns').value) || 0;
    var division = (tmns > 1) ? analisis2 / tmns : analisis2;  
    
    document.getElementById('division').value = division.toFixed(2);

    var estibadores2 = parseFloat(document.getElementById('estibadores2').value) || 0;
    var molienda2 = parseFloat(document.getElementById('molienda2').value) || 0;
    var dolar = parseFloat(document.getElementById('dolar').value) || 0;
    var peso = parseFloat(document.getElementById('peso').value) || 0;

    var resultadoestibadores = (estibadores2 > 0 && peso > 0 && dolar > 0 && tmns > 0) ? (estibadores2 * peso / dolar / tmns) : 0;
    document.getElementById('resultadoestibadores').value = resultadoestibadores.toFixed(2);
//
    var resultadomolienda = (molienda2 > 0 && peso > 0 && dolar > 0 && tmns > 0) ? (molienda2 * peso / dolar / tmns) : 0;
    document.getElementById('resultadomolienda').value = resultadomolienda.toFixed(2);


    var trans = parseFloat(document.getElementById('trans').value) || 0;
    var transporte = (trans > 0 && dolar > 0) ? (trans / dolar / tmns) : 0;

    document.getElementById('transporte').value = transporte.toFixed(2);

    // Verificación de las variables para asegurarse de que no sean NaN
    fina_au = isNaN(fina_au) ? 0 : fina_au;
    fina_ag = isNaN(fina_ag) ? 0 : fina_ag;
    fina_cu = isNaN(parseFloat(document.getElementById('fina_cu').value)) ? 0 : parseFloat(document.getElementById('fina_cu').value);
    maquila2 = isNaN(maquila2) ? 0 : maquila2;
    division = isNaN(division) ? 0 : division;
    resultadoestibadores = isNaN(resultadoestibadores) ? 0 : resultadoestibadores;
    resultadomolienda = isNaN(resultadomolienda) ? 0 : resultadomolienda;
    transporte = isNaN(transporte) ? 0 : transporte;

    // Calcular el total de deducciones
    var total_deducciones = fina_au + fina_ag + fina_cu + maquila2 + division + resultadoestibadores + resultadomolienda + transporte;
    
    // Si el resultado es NaN, asignar 0
    if (isNaN(total_deducciones)) {
        total_deducciones = 0;
    }

    // Mostrar el total en el campo correspondiente
    document.getElementById('total_deducciones').value = total_deducciones.toFixed(3);

    // Llamar a la función que actualiza la suma final (si es necesario)
    sumafinal();
}
</script>
-->
<script>
    let transManual = false;

    function deducciones() {
        // Obtener valores base
        const cotizacion_au = parseFloat(document.getElementById('cotizacion_au')?.value) || 0;
        const cotizacion_ag = parseFloat(document.getElementById('cotizacion_ag')?.value) || 0;
        const cotizacion_cu = parseFloat(document.getElementById('cotizacion_cu')?.value) || 0;

        const formula_fi_au = parseFloat(document.getElementById('formula_fi_au')?.value) || 0;
        const refinamiento_au2 = parseFloat(document.getElementById('refinamiento_au2')?.value) || 0;
        const formula_fi_ag = parseFloat(document.getElementById('formula_fi_ag')?.value) || 0;
        const refinamiento_ag2 = parseFloat(document.getElementById('refinamiento_ag2')?.value) || 0;
        const formula_fi_cu = parseFloat(document.getElementById('formula_fi_cu')?.value) || 0;
        const refinamiento_cu2 = parseFloat(document.getElementById('refinamiento_cu2')?.value) || 0;

        const maquila2 = parseFloat(document.getElementById('maquila2')?.value) || 0;
        const analisis2 = parseFloat(document.getElementById('analisis2')?.value) || 0;
        const tmns = parseFloat(document.getElementById('tmns')?.value) || 0;
        const dolar = parseFloat(document.getElementById('dolar')?.value) || 0;
        const peso = parseFloat(document.getElementById('peso')?.value) || 0;
        const estibadores2 = parseFloat(document.getElementById('estibadores2')?.value) || 0;
        const molienda2 = parseFloat(document.getElementById('molienda2')?.value) || 0;

        function truncar(valor, decimales) {
            const factor = Math.pow(10, decimales);
            return Math.floor(valor * factor) / factor;
        }
        // Calcular refinación oro (valor sin redondear)
        const fina_au_val = (formula_fi_au > 0 && refinamiento_au2 > 0)
            ? truncar(formula_fi_au * refinamiento_au2, 3)
            : 0;
        document.getElementById('fina_au').value = fina_au_val.toFixed(3);

        // Plata
        const fina_ag_val = (formula_fi_ag > 0 && refinamiento_ag2 > 0)
            ? truncar(formula_fi_ag * refinamiento_ag2, 3)
            : 0;
        document.getElementById('fina_ag').value = fina_ag_val.toFixed(3);

        // Cobre
        const checkboxEstado = document.getElementById('checkboxResultadoFinaCu')?.checked;
        const fina_cu_input = document.getElementById('fina_cu');
        let fina_cu_val = 0;

        if (checkboxEstado) {
            fina_cu_input.removeAttribute('readonly');
            fina_cu_val = parseFloat(fina_cu_input.value) || 0;
        } else {
            fina_cu_input.setAttribute('readonly', true);
            if (formula_fi_cu > 0 && refinamiento_cu2 > 0) {
                const fina_cu_raw = formula_fi_cu * 2204.62 / 100 * refinamiento_cu2;
                fina_cu_val = truncar(fina_cu_raw, 3); // aplicar truncado
                fina_cu_input.value = fina_cu_val.toFixed(3); // mostrar mismo redondeo
            } else {
                fina_cu_val = 0;
                fina_cu_input.value = '0.000';
            }
}


       // División análisis
const division_raw = (tmns > 1) ? analisis2 / tmns : analisis2;
const division = parseFloat(division_raw.toFixed(2));
document.getElementById('division').value = division.toFixed(2);

// Estibadores
let resultadoestibadores = 0;
if (estibadores2 > 0 && peso > 0 && dolar > 0 && tmns > 0) {
    const resultado_raw = estibadores2 * peso / dolar / tmns;
    resultadoestibadores = parseFloat(resultado_raw.toFixed(2));
}
document.getElementById('resultadoestibadores').value = resultadoestibadores.toFixed(2);

// Molienda
let resultadomolienda = 0;
if (molienda2 > 0 && peso > 0 && dolar > 0 && tmns > 0) {
    const molienda_raw = molienda2 * peso / dolar / tmns;
    resultadomolienda = parseFloat(molienda_raw.toFixed(2));
}
document.getElementById('resultadomolienda').value = resultadomolienda.toFixed(2);

// Transporte
const transInput = document.getElementById('trans');
let trans = parseFloat(transInput.value) || 0;

if (!transManual) {
    const transporteVal = parseFloat(document.getElementById('transporte')?.value) || 0;
    const trans_calc = (dolar > 0 && tmns > 0) ? transporteVal * dolar * tmns : 0;
    trans = parseFloat(trans_calc.toFixed(2));
    transInput.value = trans.toFixed(2);
}

let transporte = 0;
if (trans > 0 && dolar > 0 && tmns > 0) {
    const transporte_raw = trans / dolar / tmns;
    transporte = parseFloat(transporte_raw.toFixed(2));
}
document.getElementById('transporte').value = transporte.toFixed(2);
        // TOTAL DEDUCCIONES usando valores sin redondear
        const total_deducciones = (
            fina_au_val +
            fina_ag_val +
            fina_cu_val +
            maquila2 +
            division +
            resultadoestibadores +
            resultadomolienda +
            transporte
        );

        document.getElementById('total_deducciones').value = total_deducciones.toFixed(3);

        // Llama suma final si existe
        if (typeof sumafinal === 'function') sumafinal();
    }

    // === Listeners ===
    document.getElementById('checkboxResultadoFinaCu')?.addEventListener('change', deducciones);

    document.getElementById('fina_cu')?.addEventListener('input', function () {
        if (document.getElementById('checkboxResultadoFinaCu')?.checked) {
            deducciones();
        }
    });

    document.getElementById('trans')?.addEventListener('input', function () {
        transManual = true;
    });

    ['dolar', 'tmns'].forEach(id => {
        document.getElementById(id)?.addEventListener('input', function () {
            transManual = false;
            deducciones();
        });
    });
</script>
        <script>
                function penalidades() { 
                    var as = parseFloat(document.getElementById('as').value) || 0;
                    var val_as = parseFloat(document.getElementById('val_as').value) || 0;
                    var pre_as = parseFloat(document.getElementById('pre_as').value) || 0;
                    var penalidad_as = parseFloat(document.getElementById('penalidad_as').value) || 0;

                    // Condición para asignar 0 si as es menor que val_as
                    var total_as = (as < val_as) ? 0 : (as > 0 && val_as > 0 && pre_as > 0 && penalidad_as > 0) 
                        ? ((as - val_as) * penalidad_as) / pre_as 
                        : 0;

                    document.getElementById('total_as').value = total_as.toFixed(3);

                    var penalidad_as2 = penalidad_as;
                    document.getElementById('penalidad_as2').value = penalidad_as2;
                    

                    var sb = parseFloat(document.getElementById('sb').value) || 0;
                    var val_sb = parseFloat(document.getElementById('val_sb').value) || 0;
                    var pre_sb = parseFloat(document.getElementById('pre_sb').value) || 0;
                    var penalidad_sb = parseFloat(document.getElementById('penalidad_sb').value) || 0;

                    // Condición para asignar 0 si sb es menor que val_sb
                    var total_sb = (sb < val_sb) ? 0 : (sb > 0 && val_sb > 0 && pre_sb > 0 && penalidad_sb > 0) 
                        ? ((sb - val_sb) * penalidad_sb) / pre_sb 
                        : 0;

                    document.getElementById('total_sb').value = total_sb.toFixed(3);

                    var penalidad_sb2 = penalidad_sb;
                    document.getElementById('penalidad_sb2').value = penalidad_sb2;

                    var bi = parseFloat(document.getElementById('bi').value) || 0;
                    var val_bi = parseFloat(document.getElementById('val_bi').value) || 0;
                    var pre_bi = parseFloat(document.getElementById('pre_bi').value) || 0;
                    var penalidad_bi = parseFloat(document.getElementById('penalidad_bi').value) || 0;

                    // Condición para asignar 0 si bi es menor que val_bi
                    var total_bi = (bi < val_bi) ? 0 : (bi > 0 && val_bi > 0 && pre_bi > 0 && penalidad_bi > 0) 
                        ? ((bi - val_bi) * penalidad_bi) / pre_bi 
                        : 0;

                    document.getElementById('total_bi').value = total_bi.toFixed(3);

                    var penalidad_bi2 = penalidad_bi;
                    document.getElementById('penalidad_bi2').value = penalidad_bi2;

                    

                    var pb = parseFloat(document.getElementById('pb').value) || 0;
                    var val_pb = parseFloat(document.getElementById('val_pb').value) || 0;
                    var pre_pb = parseFloat(document.getElementById('pre_pb').value) || 0;
                    var penalidad_pb = parseFloat(document.getElementById('penalidad_pb').value) || 0;

                    // Condición para asignar 0 si pb es menor que val_pb
                    var total_pb = (pb < val_pb) ? 0 : (pb > 0 && val_pb > 0 && pre_pb > 0 && penalidad_pb > 0) 
                        ? ((pb - val_pb) * penalidad_pb) / pre_pb 
                        : 0;

                    document.getElementById('total_pb').value = total_pb.toFixed(3);

                    var penalidad_pb2 = penalidad_pb;
                    document.getElementById('penalidad_pb2').value = penalidad_pb2;


                    var hg = parseFloat(document.getElementById('hg').value) || 0;
                    var val_hg = parseFloat(document.getElementById('val_hg').value) || 0;
                    var pre_hg = parseFloat(document.getElementById('pre_hg').value) || 0;
                    var penalidad_hg = parseFloat(document.getElementById('penalidad_hg').value) || 0;

                    // Condición para asignar 0 si hg es menor que val_hg
                    var total_hg = (hg < val_hg) ? 0 : (hg > 0 && val_hg > 0 && pre_hg > 0 && penalidad_hg > 0) 
                        ? ((hg - val_hg) * penalidad_hg) / pre_hg 
                        : 0;

                    document.getElementById('total_hg').value = total_hg.toFixed(3);

                    var penalidad_hg2 = penalidad_hg;
                    document.getElementById('penalidad_hg2').value = penalidad_hg2;

                    var s = parseFloat(document.getElementById('s').value) || 0;
                    var val_s = parseFloat(document.getElementById('val_s').value) || 0;
                    var pre_s = parseFloat(document.getElementById('pre_s').value) || 0;
                    var penalidad_s = parseFloat(document.getElementById('penalidad_s').value) || 0;

                    // Condición para asignar 0 si s es menor que val_s
                    var total_s = (s < val_s) ? 0 : (s > 0 && val_s > 0 && pre_s > 0 && penalidad_s > 0) 
                        ? ((s - val_s) * penalidad_s) / pre_s 
                        : 0;

                    document.getElementById('total_s').value = total_s.toFixed(3);

                    var penalidad_s2 = penalidad_s;
                    document.getElementById('penalidad_s2').value = penalidad_s2;


                    // Sumar los totales
                    var total_penalidades = total_as + total_sb + total_bi + total_pb + total_hg + total_s;
                    document.getElementById('total_penalidades').value = total_penalidades.toFixed(3);
                    sumafinal()
                }
        </script>
        <script> 
            function sumafinal() {
                    var total_valores = parseFloat(document.getElementById('total_valores').value) || 0;
                    var total_deducciones = parseFloat(document.getElementById('total_deducciones').value) || 0;
                    var total_penalidades = parseFloat(document.getElementById('total_penalidades').value) || 0;
                    var total_us = (total_valores - total_deducciones - total_penalidades);
                    document.getElementById('total_us').value = total_us.toFixed(3);

                    var tmns = parseFloat(document.getElementById('tmns').value) || 0;
                    var valorporlote = total_us * tmns;
                    document.getElementById('valorporlote').value = valorporlote.toFixed(2);

                    var igv2 = parseFloat(document.getElementById('igv2').value) || 0;
                    var valor_igv = 0;
                    if (igv2 === 18) {
                        valor_igv = valorporlote * igv2 / 100;
                        document.getElementById('valor_igv').value = valor_igv.toFixed(2);
                    } else {
                        document.getElementById('valor_igv').value = '';
                    }

                    var total_liqui = valor_igv + valorporlote;
                    document.getElementById('total_porcentajeliqui').value = total_liqui.toFixed(2);

                    var adelantos = parseFloat(document.getElementById('adelantos').value) || 0;
                    console.log("Valor de adelantos:", adelantos);

                    var saldo = total_liqui - adelantos;
                    document.getElementById('saldo').value = saldo.toFixed(2);

                    if (igv2 === 18) {
                        var detraccion = saldo * 0.10;
                        document.getElementById('detraccion').value = detraccion.toFixed(2);
                    } else {
                        document.getElementById('detraccion').value = '';
                    }
                    

                    var total_liquidacion = saldo - (parseFloat(document.getElementById('detraccion').value) || 0) ;

                    document.getElementById('total_liquidacion').value = total_liquidacion.toFixed(2);
                    var pendientes = parseFloat(document.getElementById('pendientes').value) || 0;
                    var procesoplanta = parseFloat(document.getElementById('procesoplanta').value) || 0;
                    var adelantosextras = parseFloat(document.getElementById('adelantosextras').value) || 0;
                    var prestamos = parseFloat(document.getElementById('prestamos').value) || 0;
                    var otros_descuentos = parseFloat(document.getElementById('otros_descuentos').value) || 0;

                    var total = total_liquidacion - pendientes - procesoplanta - adelantosextras - prestamos - otros_descuentos;
                    document.getElementById('total').value = total.toFixed(2);

            }    
        </script>   
     <script>
    let adelantos = {!! json_encode($liquidacion->facturas->map(function($factura) {
        return [
            'id' => $factura->id, // ✅ Mantener el ID original
            'referencia' => $factura->factura_numero,
            'monto' => (float) $factura->monto
        ];
    })) !!} || []; // ✅ Asegurar que siempre sea un array

    console.log('Adelantos cargados desde el backend:', adelantos); // 🚀 VERIFICAR EN CONSOLA

    document.addEventListener("DOMContentLoaded", function() {
        let form = document.querySelector('.editar-liquidaciones');
        let inputHidden = document.getElementById('adelantosData');

        if (form && inputHidden) {
            form.addEventListener('submit', function() {
                inputHidden.value = adelantos.length > 0 ? JSON.stringify(adelantos) : '[]'; // ✅ Permitir formulario sin adelantos
                console.log('Formulario enviado con adelantosData:', inputHidden.value);
            });
        } else {
            console.error('Error: No se encontró el formulario o el input oculto adelantosData.');
        }

        actualizarTabla();
        actualizarSumaTotal();
        sumafinal();
    });

    function actualizarTabla() {
    let tabla = document.getElementById('tablaAdelantos');
    tabla.innerHTML = ''; 

    adelantos.forEach((adelanto, index) => {
        let fila = `
            <tr>
                <td><input type="text" class="form-control" value="${adelanto.referencia}" onchange="editarReferencia(${index}, this.value)"></td>
                <td><input type="number" class="form-control" value="${adelanto.monto}" step="0.01" onchange="editarMonto(${index}, this.value)"></td>
                <td>
                    <button class="btn btn-danger btn-sm" onclick="eliminarAdelanto(${index})">Eliminar</button>
                </td>
            </tr>
        `;
        tabla.innerHTML += fila;
    });

    let inputHidden = document.getElementById('adelantosData');
    if (inputHidden) {
        inputHidden.value = adelantos.length > 0 ? JSON.stringify(adelantos) : ''; // ✅ Solución aquí
        console.log('Adelantos guardados en el input:', inputHidden.value);
    }
}

    function actualizarSumaTotal() {
        let total = adelantos.reduce((sum, adelanto) => sum + adelanto.monto, 0);
        document.getElementById('adelantos').value = total.toFixed(2);
    }

    function agregarAdelanto() {
        let referencia = document.getElementById('referencia').value;
        let monto = parseFloat(document.getElementById('monto').value) || 0;

        if (referencia && monto > 0) {
            adelantos.push({ referencia, monto });

            document.getElementById('referencia').value = '';
            document.getElementById('monto').value = '';

            actualizarTabla();
            actualizarSumaTotal();
            sumafinal();
        }
    }

    function eliminarAdelanto(index) {
        adelantos.splice(index, 1);
        actualizarTabla();
        actualizarSumaTotal();
        sumafinal();
    }

    function editarReferencia(index, nuevaReferencia) {
        adelantos[index].referencia = nuevaReferencia;
        actualizarTabla();
        sumafinal();
    }

    function editarMonto(index, nuevoMonto) {
        adelantos[index].monto = parseFloat(nuevoMonto) || 0;
        actualizarTabla();
        actualizarSumaTotal();
        sumafinal();
    }

    // 🚀 CONFIRMACIÓN ANTES DE CERRAR EL MODAL
    $('#adelantosModal').on('hide.bs.modal', function (e) {
        let confirmacion = confirm("¿Seguro que quieres cerrar? Se guardaran los cambios realizados.");
        if (!confirmacion) {
            e.preventDefault(); // Evita que el modal se cierre
        }
    });

    // Cargar Adelantos al abrir el Modal
    $('#adelantosModal').on('shown.bs.modal', function () {
        console.log('Modal abierto, recargando adelantos.');
        actualizarTabla();
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Recuperar valores guardados en localStorage
    function recuperarValor(id) {
        let valorGuardado = localStorage.getItem(id);
        if (valorGuardado) {
            document.getElementById(id).value = valorGuardado;
        }
    }

    // Guardar valores cuando se cambian
    function guardarValor(id) {
        document.getElementById(id).addEventListener("change", function () {
            localStorage.setItem(id, this.value);
        });
    }

    // Lista de selectores a manejar
    const selectores = ["decimal_count_au", "decimal_count_ag", "decimal_count_cu"];

    // Aplicar funciones a cada selector
    selectores.forEach(id => {
        recuperarValor(id);
        guardarValor(id);
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    function recuperarEstadoCheckbox(idCheckbox, idTextbox) {
        let estadoCheckbox = localStorage.getItem(idCheckbox);
        let valorTextbox = localStorage.getItem(idTextbox);

        if (estadoCheckbox === "true") {
            document.getElementById(idCheckbox).checked = true;
            document.getElementById(idTextbox).disabled = false;
        }

        if (valorTextbox) {
            document.getElementById(idTextbox).value = valorTextbox;
        }
    }

    function guardarEstadoCheckbox(idCheckbox, idTextbox) {
        document.getElementById(idCheckbox).addEventListener("change", function () {
            localStorage.setItem(idCheckbox, this.checked);
            document.getElementById(idTextbox).disabled = !this.checked;
        });

        document.getElementById(idTextbox).addEventListener("input", function () {
            localStorage.setItem(idTextbox, this.value);
        });
    }

    // Lista de IDs de los checkbox y textboxes
    const elementos = [
        { checkbox: "checkbox_cu", textbox: "textbox_cu" },
        { checkbox: "checkbox_ag", textbox: "textbox_ag" },
        { checkbox: "checkbox_au", textbox: "textbox_au" }
    ];

    // Aplicar funciones a cada par de checkbox y textbox
    elementos.forEach(el => {
        recuperarEstadoCheckbox(el.checkbox, el.textbox);
        guardarEstadoCheckbox(el.checkbox, el.textbox);
    });
});
</script>
<script>
function validarIGV() {
    const igv2 = document.getElementById('igv2');
    const mensaje = document.getElementById('igv2-error');
    const valor = parseFloat(igv2.value);

    if (igv2.value.trim() === '' || (valor !== 18 && valor !== 0)) {
        mensaje.style.display = 'block';
        igv2.classList.add('is-invalid');
    } else {
        mensaje.style.display = 'none';
        igv2.classList.remove('is-invalid');
    }
}
</script>
        @endsection
        