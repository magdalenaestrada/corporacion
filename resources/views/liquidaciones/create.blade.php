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
                <form class="crear-muestras" action="{{ route('liquidaciones.store') }}" method="POST">
                    @csrf
                    <h6><strong>SELECCIONE MUESTRA</strong></h6>
                   
                    <div class="row">
                        <div class="form-group col-md-7">
                            <label for="muestra_id">MUESTRA</label>
                            <select name="muestra_id" id="muestra_id" class="form-control select2" style="width: 100%;" data-placeholder="Buscar muestra" data-dropdownAutoWidth="true" >
                                <option value="">Seleccionar muestra</option>
                                @foreach($muestras as $muestra)
                                    <option value="{{ $muestra->id }}"
                                            data-codigo="{{ $muestra->codigo }}"
                                            data-au="{{ $muestra->au }}"
                                            data-ag="{{ $muestra->ag }}"
                                            data-cu="{{ $muestra->cu }}"
                                            data-as="{{ $muestra->as }}"
                                            data-sb="{{ $muestra->sb }}"
                                            data-pb="{{ $muestra->pb }}"
                                            data-zn="{{ $muestra->zn }}"
                                            data-bi="{{ $muestra->bi }}"
                                            data-hg="{{ $muestra->hg }}"
                                            data-s="{{ $muestra->s }}"
                                            data-humedad="{{ $muestra->humedad }}"
                                            data-obs="{{ $muestra->obs }}">
                                        {{ $muestra->codigo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
        
                        <div class="form-group col-md-4">
                            <label for="obs">OBSERVACION</label>
                            <input type="text" name="obs" id="obs" class="form-control" readonly>
                        </div> 
                        <div class="form-group col-md-1">
                            <label for="resultado_cu">CALCULO</label>
                            <input type="text" name="resultado_cu" id="resultado_cu" class="form-control" placeholder="VALOR" oninput="calcular()">
                        </div>
                        
                        <P>            
                        <h6><strong>INGRESE DATOS SECCION RESALTADA</strong></h6>     
                        <div class="row"> 
                            <div class="form-group col-md-3 g-1">
                                <label for="NroSalida" class="text-muted">NUMERO DE TICKET</label>
                                <select name="NroSalida" id="NroSalida" class="form-control">
                                    <option value="">Seleccione un NroSalida...</option>
                                    @foreach($ingresos as $ingreso)
                                        <option value="{{ $ingreso->NroSalida }}"
                                                data-fechai="{{ $ingreso->fecha_ingreso }}"
                                                data-peso="{{ $ingreso->peso_total }}" 
                                                data-lote="{{ $ingreso->ref_lote }}" 
                                                data-descripcion="{{ $ingreso->descripcion }}" 
                                                data-producto="{{ $ingreso->estado }}">   
                                            {{ $ingreso->NroSalida }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                           
                    </div>
                            <div class="form-group col-md-1">
                                <label for="peso">PESO</label>
                                <input type="text" name="peso" id="peso" class="form-control" placeholder="Ingrese peso" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="fechai">FECHA INGRESO </label>
                                <input type="text" name="fechai" id="fechai" class="form-control" readonly>      
                            </div>
                            <div class="form-group col-md-1">
                                <label for="lote">LOTE</label>
                                <input type="text" name="lote" id="lote" class="form-control" placeholder="Ingrese lote">
                            </div>
                            
                            <div class="form-group col-md-2">
                                <label for="producto">PRODUCTO</label>
                                <input type="text" name="producto" id="producto" class="form-control" placeholder="Ingrese producto">
                            </div>
                             <div class="form-group col-md-12">
                                <label for="descripcion">DESCRIPCION</label>
                                <input type="text" name="descripcion" id="descripcion" class="form-control" readonly placeholder="Informacion de descripcion">
                            </div>
               
                            <div class="form-group col-md-2">
                                <label for="cotizacion_au">COTIZACION ORO</label>
                                <input type="text" name="cotizacion_au" id="cotizacion_au" class="form-control" placeholder="Ingrese valor">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="cotizacion_ag">COTIZACION PLATA</label>
                                <input type="text" name="cotizacion_ag" id="cotizacion_ag" class="form-control" placeholder="Ingrese valor">
                            </div>
                           
                            <div class="form-group col-md-2">
                                <label for="cotizacion_cu">COTIZACION COBRE</label>
                                <input type="text" name="cotizacion_cu" id="cotizacion_cu" class="form-control" placeholder="Resultado" >
                            </div>
     
                            <script>
                            function calcular() {
                                const resultadoInput = document.getElementById('resultado_cu').value;
                                const resultado = parseFloat(resultadoInput);
                            
                                if (!isNaN(resultado)) {
                                    const cotizacionCobre = resultado / 22.0462 / 100;
                                    document.getElementById('cotizacion_cu').value = cotizacionCobre.toFixed(2);
                                } else {
                                    document.getElementById('cotizacion_cu').value = '';
                                }
                            }
                            </script>
                          
                        <P>
                      <!--      <h6><strong>SECCION ADELANTO</strong></h6>  
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
                                 </div>
                                -->
                    <P>
                    <h6><strong>SELECCIONE CLIENTE</strong></h6>  
                    <div class="row">
                        <!-- Campo para seleccionar cliente -->
                        <div class="form-group col-md-2">
                            <label for="cliente_id">CLIENTE</label>
                            <select name="cliente_id" id="cliente_id" class="form-control select2" style="width: 100%;" data-minimumInputLength="2" data-placeholder="Buscar cliente" data-dropdownAutoWidth="true" disabled>
                                <option value="">Seleccionar cliente</option>
                                @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}"
                                    data-documento="{{ $cliente->documento_cliente }}"
                                    data-datos="{{ $cliente->datos_cliente }}"
                                    data-empresa="{{ $cliente->ruc_empresa }}"
                                    data-razon-social="{{ $cliente->razon_social }}"
                                    data-direccion="{{ $cliente->direccion }}"
                                    data-telefono="{{ $cliente->telefono }}"
                                    data-producto="{{ $cliente->producto }}"
                                    data-proteccion-au="{{ $cliente->requerimientos->proteccion_au }}"
                                    data-proteccion-ag="{{ $cliente->requerimientos->proteccion_ag }}"
                                    data-proteccion-cu="{{ $cliente->requerimientos->proteccion_cu }}"
                                    data-deduccion-au="{{ $cliente->requerimientos->deduccion_au }}"
                                    data-deduccion-ag="{{ $cliente->requerimientos->deduccion_ag }}"
                                    data-deduccion-cu="{{ $cliente->requerimientos->deduccion_cu }}"
                                    data-refinamiento-au="{{ $cliente->requerimientos->refinamiento_au }}"
                                    data-refinamiento-ag="{{ $cliente->requerimientos->refinamiento_ag }}"
                                    data-refinamiento-cu="{{ $cliente->requerimientos->refinamiento_cu }}"
                                    data-maquila="{{ $cliente->requerimientos->maquila }}"
                                    data-analisis="{{ $cliente->requerimientos->analisis }}"
                                    data-estibadores="{{ $cliente->requerimientos->estibadores }}"
                                    data-molienda="{{ $cliente->requerimientos->molienda }}"
                                    data-igv="{{ $cliente->requerimientos->igv }}"
                                    data-penalidad-as="{{ $cliente->requerimientos->penalidad_as }}"
                                    data-penalidad-sb="{{ $cliente->requerimientos->penalidad_sb }}"
                                    data-penalidad-pb="{{ $cliente->requerimientos->penalidad_pb }}"
                                    data-penalidad-zn="{{ $cliente->requerimientos->penalidad_zn }}"
                                    data-penalidad-bi="{{ $cliente->requerimientos->penalidad_bi }}"
                                    data-penalidad-hg="{{ $cliente->requerimientos->penalidad_hg }}"
                                    data-penalidad-s="{{ $cliente->requerimientos->penalidad_s }}"
                                    data-penalidad-h2o="{{ $cliente->requerimientos->penalidad_h2o }}"
                                    data-merma="{{ $cliente->requerimientos->merma }}"
                                    data-pagable-au="{{ $cliente->requerimientos->pagable_au }}"
                                    data-pagable-ag="{{ $cliente->requerimientos->pagable_ag }}"
                                    data-pagable-cu="{{ $cliente->requerimientos->pagable_cu }}">
                                    {{ $cliente->documento_cliente }}  {{ $cliente->razon_social }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                       
                <div class="form-group col-md-5">
                    <label for="datos_cliente">DATOS CLIENTES
                    </label>
                    <input type="text" name="datos_cliente" id="datos_cliente" class="form-control" readonly>
                </div>

                <div class="form-group col-md-2">
                    <label for="ruc_empresa">RUC EMPRESA</label>
                    <input type="text" name="ruc_empresa" id="ruc_empresa" class="form-control" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="telefono">TELEFONO</label>
                    <input type="text" name="telefono" id="telefono" class="form-control" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label for="razon_social">RAZÓN SOCIAL</label>
                    <input type="text" name="razon_social" id="razon_social" class="form-control" readonly>
                </div>
               
                <div class="form-group col-md-5">
                    <label for="direccion">DIRECCION</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" readonly>
                </div>
               
                
                    <p>
            <!-- Otros campos de liquidaciones que ya tienes -->
                        
            <div class="row">
                <div class="col-md-4">
                    <h6><strong>OBTENIENDO EL TOTAL TMNS</strong></h6>
                    <div class="form-group">
                        <label for="humedad">HUMEDAD</label>
                        <div class="input-group"> <!-- Usamos input-group para Bootstrap 4 o superior -->
                            <input type="text" name="humedad" id="humedad" class="form-control" readonly>
                            <span class="input-group-text">%</span> <!-- Aquí agregamos el símbolo de porcentaje -->
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label for="tms">TMS</label>
                        <input type="text" name="tms" id="tms" class="form-control" readonly>
                    </div>
                    
                
                    <div class="form-group">
                        <label for="merma">MERMA</label>
                        <div class="input-group"> 
                        <input type="text" name="merma" id="merma" class="form-control" readonly>
                        <span class="input-group-text">%</span>
                    </div>
                </div>
                <P>
                    <div class="form-group">
                        <label for="tmns"><strong> TONELADAS METRICA NETAS SECAS</strong></label>
                        <input type="text" name="tmns" id="tmns" class="form-control text-center " readonly >
                        
                    </div>
                
             
                </div>
                
                <div class="col-md-4">
                    <h6><strong>VALORES</strong></h6>
                    <div class="form-group">
                        <label for="cu">COBRE</label>
                        <div class="input-group">  
                           
                        <input type="text" name="cu" id="cu" class="form-control" readonly>
                            <span class="input-group-text">%</span>
                    </div>
                </div>
                    
                    <div class="form-group">
                        <label for="ag">PLATA</label>
                        <input type="text" name="ag" id="ag" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="au">ORO</label>
                        <input type="text" name="au" id="au" class="form-control" readonly>
                    </div>
                    
                <P>
                    <div class="form-group">
                        <label for="decimal_count"><strong>DECIMALES ORO</strong></label>
                        <select name="decimal_count" id="decimal_count" class="form-control">
                            <option value="2">2 Decimales</option>
                            <option value="3" selected>3 Decimales</option>  <!-- Esto hace que 3 decimales esté seleccionado por defecto -->
                        </select>
                    </div>
                    
            </div>
                
                <div class="col-md-4">
                    <h6><strong>PROTECCION</strong></h6>
                    <div class="form-group">
                        <label for="proteccion_cu">PROTECCION COBRE</label>
                        <input type="text" name="proteccion_cu" id="proteccion_cu" class="form-control" readonly>
                    </div>
                    
                
                    <div class="form-group">
                        <label for="proteccion_ag">PROTECCION PLATA</label>
                        <input type="text" name="proteccion_ag" id="proteccion_ag" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="proteccion_au">PROTECCION ORO</label>
                        <input type="text" name="proteccion_au" id="proteccion_au" class="form-control" readonly>
                    </div>
                
                    
                        <label for="aplicar_factor_au"><strong>Sin Factor Au:</strong></label>
                        <input type="checkbox" id="aplicar_factor_au" name="aplicar_factor_au">
                        <label for="aplicar_factor_ag"><strong>Sin Factor Ag:</strong></label>
                        <input type="checkbox" id="aplicar_factor_ag" name="aplicar_factor_ag">
                        <label for="checkboxResultadoFinaCu"><strong>Penalidad Cu:</strong></label>
                        <input type="checkbox" id="checkboxResultadoFinaCu" name="checkboxResultadoFinaCu">
                        
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
                </div>
                
            </div>                
        <p> 
    <div class="container  ">
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="ley_cu">LEY COBRE</label>
                        <div class="input-group">
                        <input type="text" name="ley_cu" id="ley_cu" class="form-control" readonly>
                        <span class="input-group-text">%</span>
                    </div></div>
                    <div class="form-group col-md-2">
                        <label for="pagable_cu">% PAGABLE COBRE</label>
                        <div class="input-group">
                        <input type="text" name="pagable_cu" id="pagable_cu" class="form-control" readonly>
                        <span class="input-group-text">%</span>
                    </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="deduccion_cu">DED. COBRE</label>
                        <input type="text" name="deduccion_cu" id="deduccion_cu" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="formula_cu"><strong>FORMULA</strong></label>
                        <div class="input-group"> 
                        <input type="text" name="formula_cu" id="formula_cu" class="form-control" readonly>
                        <span class="input-group-text">%</span>
                    </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="precio_cu"><strong>PRECIO COBRE</strong></label>
                        <input type="text" name="precio_cu" id="precio_cu" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="val_cu"><strong>VALOR COBRE</strong></label>
                        <input type="text" name="val_cu" id="val_cu" class="form-control" readonly>
                    </div>
                </div>    
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="ley_ag">LEY PLATA</label>
                        <input type="text" name="ley_ag" id="ley_ag" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="pagable_ag">% PAGABLE PLATA</label>
                        <div class="input-group"> 
                        <input type="text" name="pagable_ag" id="pagable_ag" class="form-control" readonly>
                        <span class="input-group-text">%</span>
                    </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="deduccion_ag">DED. PLATA</label>
                        <input type="text" name="deduccion_ag" id="deduccion_ag" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="formula_ag"><strong>FORMULA</strong></label>
                        <input type="text" name="formula_ag" id="formula_ag" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="precio_ag"><strong>PRECIO PLATA</strong></label>
                        <input type="text" name="precio_ag" id="precio_ag" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="val_ag"><strong>VALOR PLATA</strong></label>
                        <input type="text" name="val_ag" id="val_ag" class="form-control" readonly>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="ley_au">LEY ORO</label>
                        <input type="text" name="ley_au" id="ley_au" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-2">   
                        <label for="pagable_au">% PAGABLE ORO</label>
                        <div class="input-group"> 
                        <input type="text" name="pagable_au" id="pagable_au" class="form-control" readonly>
                        <span class="input-group-text">%</span>
                    </div>
                    </div>
                    
                    <div class="form-group col-md-2">
                        <label for="deduccion_au">DED. ORO</label>
                        <input type="text" name="deduccion_au" id="deduccion_au" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="formula_au"><strong>FORMULA</strong></label>
                        <input type="text" name="formula_au" id="formula_au" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="precio_au"><strong>PRECIO ORO</strong></label>
                        <input type="text" name="precio_au" id="precio_au" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="val_au"><strong>VALOR ORO</strong></label>
                        <input type="text" name="val_au" id="val_au" class="form-control" readonly>
                    </div>
                </div>
                    
          <div class="row">
                <div class="form-group col-md-10">
                    <label for="text"><strong></strong></label>
                    <input type="text" name="text" id="text" value= "TOTAL PAGABLE / TM " class="form-control" readonly>
                </div>
                <div class="form-group col-md-2" >
                    <label for="total_valores"><strong></strong></label>
                    <input type="text" name="total_valores" id="total_valores" class="form-control"  readonly>
                </div>
            </div>
        </div>
    
            <div class="container">
            <h4><strong>DEDUCCIONES</strong></h4>
                <!-- Primera sección -->
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
                                <input type="text" name="formula_fi_cu" id="formula_fi_cu" class="form-control" readonly>
                                <span class="input-group-text">%</span>
                            </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="refinamiento_cu"><strong>REF. COBRE</strong></label>
                                <input type="text" name="refinamiento_cu" id="refinamiento_cu" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fina_cu"><strong>$</strong></label>
                                <input type="text" name="fina_cu" id="fina_cu" class="form-control" >
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
                                <input type="text" name="formula_fi_ag" id="formula_fi_ag" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="refinamiento_ag"><strong>REF. PLATA</strong></label>
                                <input type="text" name="refinamiento_ag" id="refinamiento_ag" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fina_ag"><strong>$</strong></label>
                                <input type="text" name="fina_ag" id="fina_ag" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="row"> 
                                        <!-- Primer div a la izquierda -->
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
                                                    <input type="text" name="formula_fi_au" id="formula_fi_au" class="form-control" readonly>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="refinamiento_au"><strong>REF. ORO</strong></label>
                                                    <input type="text" name="refinamiento_au" id="refinamiento_au" class="form-control" readonly>
                                                </div>
                                                <!--<div class="form-group col-md-2">
                                                    <label for="text">* PESO</label>
                                                    <input type="text" name="text" id="text" value="2204.62" class="form-control" readonly>
                                                </div> -->
                                                <div class="form-group col-md-3">
                                                    <label for="fina_au"><strong>$</strong></label>
                                                    <input type="text" name="fina_au" id="fina_au" class="form-control" readonly>
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
                            <input type="text" name="maquila" id="maquila" class="form-control" readonly>
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
                            <input type="text" name="analisis" id="analisis" class="form-control" >
                        </div>
                        <div class="form-group col-md-3">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="division"><strong>$</strong></label>
                            <input type="text" name="division" id="division" class="form-control"readonly >
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
                            <div class="input-group"> 
                            <input type="text" name="estibadores" id="estibadores" class="form-control"     >
                        </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="dolar"><strong>TIPO CAMBIO</strong></label>
                            <input type="text" name="dolar" id="dolar" class="form-control" >
                        </div>
                        <div class="form-group col-md-3">
                            <label for="resultadoestibadores"><strong>$</strong></label>
                            <input type="text" name="resultadoestibadores" id="resultadoestibadores" class="form-control" readonly >
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row"> 
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="text"></label>
                        <input type="text" name="text" id="text" value="MOLIENDA" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row justify-content-end">
                        <div class="form-group col-md-3">
                            <label for="molienda"><strong>VALOR</strong></label>
                            <div class="input-group"> 
                            <input type="text" name="molienda" id="molienda" class="form-control" >
                        </div>
                        </div>
                        <div class="form-group col-md-3">
                        </div>
                        <!--<div class="form-group col-md-3">
                            <label for="dolar"><strong>TIPO CAMBIO</strong></label>
                            <input type="text" name="dolar" id="dolar" class="form-control" >
                        </div>-->
                        <div class="form-group col-md-3">
                            <label for="resultadomolienda"><strong>$</strong></label>
                            <input type="text" name="resultadomolienda" id="resultadomolienda" class="form-control" readonly >
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
                            <input type="text" name="trans" id="trans" class="form-control" >
                        </div>
                        </div>
                        <div class="form-group col-md-3">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="transporte"><strong>$</strong></label>
                            <input type="text" name="transporte" id="transporte" class="form-control" readonly >
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
                        <input type="text" name="total_deducciones" id="total_deducciones" class="form-control" readonly>
                    </div>
                </div>
            </div>     
        
                        <div class="container ">
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
                    <input type="text" name="as" id="as" class="form-control" readonly>
                </div>
                <div class="form-group col-md-1">
                    <label for="val_as" style="min-height: 17px;"></label>
                    <input type="text" name="val_as" id="val_as" class="form-control" VALUE="0.100" readonly style="width: 70px;" > 
                </div>

                <div class="form-group col-md-2">
                    <label for="penalidad_as">PEN. ARSENICO</label>
                    <input type="text" name="penalidad_as" id="penalidad_as" class="form-control" >
                </div>
                <div class="form-group col-md-1">
                    <label for="text" style="min-height: 17px;"></label>
                    <input type="text" name="text" id="text" value="$/TMS" class="form-control" readonly style="width: 80px;">
                </div>
                <div class="form-group col-md-1">
                    <label for="pre_as" style="min-height: 17px;"></label>
                    <input type="text" name="pre_as" id="pre_as" class="form-control" VALUE="0.100" readonly style="width: 70px;">
                </div>
                <div class="col-md-4">
                    <div class="row justify-content-end">
                        <div class="form-group col-md-6">
                    <label for="total_as"><strong>$</strong></label>
                    <input type="text" name="total_as" id="total_as" class="form-control" readonly>
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
                    <input type="text" name="sb" id="sb" class="form-control" readonly>
                </div>
                <div class="form-group col-md-1">
                    <label for="val_sb" style="min-height: 17px;"></label>
                    <input type="text" name="val_sb" id="val_sb" class="form-control" VALUE="0.100" readonly style="width: 70px;">
                </div>
                <div class="form-group col-md-2">
                    <label for="penalidad_sb">PEN. ANTIMONIO</label>
                    <input type="text" name="penalidad_sb" id="penalidad_sb" class="form-control" >
                </div>
                <div class="form-group col-md-1">
                    <label for="text" style="min-height: 17px;"></label>
                    <input type="text" name="text" id="text" value="$/TMS" class="form-control" readonly style="width: 80px;">
                </div>
                <div class="form-group col-md-1">
                    <label for="pre_sb" style="min-height: 17px;"></label>
                    <input type="text" name="pre_sb" id="pre_sb" class="form-control" VALUE="0.100" readonly style="width: 70px;">
                </div>
                <div class="col-md-4">
                    <div class="row justify-content-end">
                        <div class="form-group col-md-6">
                    <label for="total_sb"><strong>$</strong></label>
                    <input type="text" name="total_sb" id="total_sb" class="form-control" readonly>
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
            <input type="text" name="bi" id="bi" class="form-control" readonly>
        </div>
        <div class="form-group col-md-1">
            <label for="val_bi" style="min-height: 17px;"></label>
            <input type="text" name="val_bi" id="val_bi" class="form-control" VALUE="0.050" readonly style="width: 70px;">
        </div>
        <div class="form-group col-md-2">
            <label for="penalidad_bi">PEN. BISMUTO</label>
            <input type="text" name="penalidad_bi" id="penalidad_bi" class="form-control" >
        </div>
        <div class="form-group col-md-1">
            <label for="text" style="min-height: 17px;"></label>
            <input type="text" name="text" id="text" value="$/TMS" class="form-control" readonly style="width: 80px;">
        </div>
        <div class="form-group col-md-1">
            <label for="pre_bi" style="min-height: 17px;"></label>
            <input type="text" name="pre_bi" id="pre_bi" class="form-control" VALUE="0.010" readonly style="width: 70px;" >
        </div>
        <div class="col-md-4">
            <div class="row justify-content-end">
                <div class="form-group col-md-6">
            <label for="total_bi"><strong>$</strong></label>
            <input type="text" name="total_bi" id="total_bi" class="form-control" readonly>
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
                    <input type="text" name="pb" id="pb" class="form-control" readonly>
                </div>
                <div class="form-group col-md-1">
                    <label for="val_pb" style="min-height: 17px;"></label>
                    <input type="text" name="val_pb" id="val_pb" class="form-control" VALUE="8.000" readonly style="width: 70px;">
                </div>
                <div class="form-group col-md-2">
                    <label for="penalidad_pb">PEN. PB + ZN </label>
                    <input type="text" name="penalidad_pb" id="penalidad_pb" class="form-control" >
                </div>
                <div class="form-group col-md-1">
                    <label for="text" style="min-height: 17px;"></label>
                    <input type="text" name="text" id="text" value="$/TMS" class="form-control" readonly style="width: 80px;">
                </div>
                <div class="form-group col-md-1">
                    <label for="pre_pb" style="min-height: 17px;"></label>
                    <input type="text" name="pre_pb" id="pre_pb" class="form-control" VALUE="1.000" readonly style="width: 70px;">
                </div>
                <div class="col-md-4">
                    <div class="row justify-content-end">
                        <div class="form-group col-md-6">
                    <label for="total_pb"><strong>$</strong></label>
                    <input type="text" name="total_pb" id="total_pb" class="form-control" readonly>
                </div>
            </div>
        </div>
    </div>
                <div class="row">
                    <!-- Primer div a la izquierda 
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="text"></label>
                            <input type="text" name="text" id="text" value="ZN:" class="form-control" readonly>
                        </div>
                    </div>
                <div class="form-group col-md-2">
                    <label for="zn">LAB. ZINC</label>
                    <input type="text" name="zn" id="zn" class="form-control" readonly>
                </div>
                <div class="form-group col-md-1">
                    <label for="val_zn"></label>
                    <input type="text" name="val_zn" id="val_zn" class="form-control" VALUE="8.000" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="penalidad_zn">PENALIDAD ZINC</label>
                    <input type="text" name="penalidad_zn" id="penalidad_zn" class="form-control" readonly>
                </div>
                <div class="form-group col-md-1">
                    <label for="text"></label>
                    <input type="text" name="text" id="text" value="$/TMS" class="form-control" readonly>
                </div>
                <div class="form-group col-md-1">
                    <label for="pre_zn"></label>
                    <input type="text" name="pre_zn" id="pre_zn" class="form-control" VALUE="1.000" readonly>
                </div>
                <div class="col-md-4">
                    <div class="row justify-content-end">
                        <div class="form-group col-md-6">
                    <label for="total_zn"><strong>$</strong></label>
                    <input type="text" name="total_zn" id="total_zn" class="form-control" readonly>
                </div>
            </div>
        </div>-->
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
                    <input type="text" name="hg" id="hg" class="form-control" readonly>
                </div>
                <div class="form-group col-md-1">
                    <label for="val_hg" style="min-height: 17px;"></label>
                    <input type="text" name="val_hg" id="val_hg" class="form-control" VALUE="30.000" readonly style="width: 70px;">
                </div>
                <div class="form-group col-md-2">
                    <label for="penalidad_hg">PEN. MERCURIO</label>
                    <input type="text" name="penalidad_hg" id="penalidad_hg" class="form-control" >
                </div>
                <div class="form-group col-md-1">
                    <label for="text" style="min-height: 17px;"></label>
                    <input type="text" name="text" id="text" value="$/TMS" class="form-control" readonly style="width: 80px;">
                </div>
                <div class="form-group col-md-1">
                    <label for="pre_hg" style="min-height: 17px;"></label>
                    <input type="text" name="pre_hg" id="pre_hg" class="form-control" VALUE="20.000" readonly style="width: 70px;">
                </div>
                <div class="col-md-4">
                    <div class="row justify-content-end">
                        <div class="form-group col-md-6">
                    <label for="total_hg"><strong>$</strong></label>
                    <input type="text" name="total_hg" id="total_hg" class="form-control" readonly>
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
                    <label for="s">LAB. H2O</label>
                    <input type="text" name="s" id="s" class="form-control" readonly>
                </div>
                <div class="form-group col-md-1">
                    <label for="val_s" style="min-height: 17px;"></label>
                    <input type="text" name="val_s" id="val_s" class="form-control" VALUE="0.000" readonly style="width: 70px;">
                </div>
                <div class="form-group col-md-2">
                    <label for="penalidad_s">PEN. H2O</label>
                    <input type="text" name="penalidad_s" id="penalidad_s" class="form-control" >
                </div>
                <div class="form-group col-md-1">
                    <label for="text" style="min-height: 17px;"></label>
                    <input type="text" name="text" id="text" value="$/TMS" class="form-control" readonly style="width: 80px;">
                </div>
                <div class="form-group col-md-1">
                    <label for="pre_s" style="min-height: 17px;"></label>
                    <input type="text" name="pre_s" id="pre_s" class="form-control" VALUE="1.000" readonly style="width: 80px;">
                </div>
                <div class="col-md-4">
                    <div class="row justify-content-end">
                        <div class="form-group col-md-6">
                    <label for="total_s"><strong>$</strong></label>
                    <input type="text" name="total_s" id="total_s" class="form-control" readonly>
                </div>
            </div>
        </div>
    </div>
            <div class="row">
                <!-- Primer div a la izquierda 
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="text"></label>
                        <input type="text" name="text" id="text" value="H2O:" class="form-control" readonly>
                    </div>
                </div>
            <div class="form-group col-md-2">
                <label for="h2o">LAB. H2O</label>
                <input type="text" name="h2o" id="h2o" class="form-control" readonly>
            </div>
            <div class="form-group col-md-1">
                <label for="val_h2o"> </label>
                <input type="text" name="val_h2o" id="val_h2o" class="form-control" VALUE="10.000" readonly>
            </div>
            <div class="form-group col-md-2">
                <label for="penalidad_h2o">PENALIDAD H2O</label>
                <input type="text" name="penalidad_h2o" id="penalidad_h2o" class="form-control" readonly>
            </div>
            <div class="form-group col-md-1">
                <label for="text"></label>
                <input type="text" name="text" id="text" value="$/TMS" class="form-control" readonly>
            </div>
            <div class="form-group col-md-1">
                <label for="pre_h2o"></label>
                <input type="text" name="pre_h2o" id="pre_h2o" class="form-control" VALUE="1.000" readonly>
            </div>
            <div class="col-md-4">
                <div class="row justify-content-end">
                    <div class="form-group col-md-6">
                <label for="total_h2o"><strong>$</strong></label>
                <input type="text" name="total_h2o" id="total_h2o" class="form-control" readonly>
            </div>-->
                </div>  
    
    
            <div class="row">
                <div class="form-group col-md-10  ">
                    <label for="text" style="min-height: 17px;"></label>
                    <input type="text" name="text" id="text" class="form-control" value="TOTAL PENALIDADES" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="total_penalidades"><strong>$</strong></label>
                    <input type="text" name="total_penalidades" id="total_penalidades" class="form-control" readonly>
                </div>
            </div>
     
            <div class="row justify-content-end">
                <div class="form-group col-md-2">
                    <label for="text" style="min-height: 17px;"></label>
                    <input type="text" name="text" id="text" class="form-control text-right" value="TOTAL US$/TM" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="total_us"><strong>$</strong></label>
                    <input type="text" name="total_us" id="total_us" class="form-control text-right" readonly>
                </div>
            </div>
        
            <div class="row justify-content-end">
                <div class="form-group col-md-2">
                    <label for="text" style="min-height: 17px;"></label>
                    <input type="text" name="text" id="text" class="form-control text-right" value="VALOR POR LOTE US$" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="valorporlote"><strong>$</strong></label>
                    <input type="text" name="valorporlote" id="valorporlote" class="form-control text-right" readonly>
                </div>
            </div>
        
            <div class="row justify-content-end">
                <div class="form-group col-md-1">
                    <label for="text" style="min-height: 17px;"></label>
                    <input type="text" name="text" id="text" class="form-control text-right" value="IGV" readonly>
                </div>
                <div class="form-group col-md-1">
                    <label for="igv " style="min-height: 17px;"><strong></strong></label>
                    <div class="input-group"> 
                    <input type="text" name="igv" id="igv" class="form-control text-right" readonly >
                    <span class="input-group-text small-percent">%</span>                
                    </div>
                </div>
                <style>
                    .small-percent {
                        font-size: 0.5rem; /* Hacer el porcentaje aún más pequeño */
                        padding: 0.1rem 0.2rem; /* Reducir el padding para un ajuste más compacto */
                    }
                </style>
            <div class="form-group col-md-2">
                <label for="valor_igv"><strong>$</strong></label>
                <input type="text" name="valor_igv" id="valor_igv" class="form-control text-right" readonly>
            </div>
            </div>
      
            <div class="row justify-content-end">
                <div class="form-group col-md-2">
                    <label for="text" style="min-height: 17px;"></label>
                    <input type="text" name="text" id="text" class="form-control text-right" value="TOTAL DE LIQUIDACION %" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="total_porcentajeliqui"><strong>$</strong></label>
                    <input type="text" name="total_porcentajeliqui" id="total_porcentajeliqui" class="form-control text-right" readonly>
                </div>
            </div>
    
            <div class="row justify-content-end">

                    <div class="form-group col-md-2">
                        <label for="text" style="min-height: 17px;"></label>
                        <input type="text" name="text" id="text" class="form-control text-right" value="ADELANTOS" readonly>
                    </div>
                <div class="form-group col-md-2">
                    <label for="adelantos"><strong>$</strong></label>
                    <input type="text" name="adelantos" id="adelantos" class="form-control text-right" readonly>
                </div>
            </div>
      
            <div class="row justify-content-end">
                <div class="form-group col-md-2">
                    <label for="text" style="min-height: 17px;"></label>
                    <input type="text" name="text" id="text" class="form-control text-right" value="SALDO" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="saldo"><strong>$</strong></label>
                    <input type="text" name="saldo" id="saldo" class="form-control text-right" readonly>
                </div>
            </div>
       
            <div class="row justify-content-end">
                <div class="form-group col-md-2">
                    <label for="text" style="min-height: 17px;"></label>
                    <input type="text" name="text" id="text" class="form-control text-right" value="DETRACCION 10%" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="detraccion"><strong>$</strong></label>
                    <input type="text" name="detraccion" id="detraccion" class="form-control text-right" readonly>
                </div>
            </div>
        
            <div class="row justify-content-end">
                <div class="form-group col-md-2">
                    <label for="text" style="min-height: 17px;"></label>
                    <input type="text" name="text" id="text" class="form-control text-right" value="TOTAL LIQUIDACION " readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="total_liquidacion"><strong>$</strong></label>
                    <input type="text" name="total_liquidacion" id="total_liquidacion" class="form-control text-right" readonly>
                </div>
            </div>
        
            <div class="row justify-content-end">
                <div class="form-group col-md-4">
                    <label for="text1" ></label>
                    <input type="text" name="text1" id="text1" class="form-control text-center" value="DESCUENTOS ADICIONALES" readonly>
                </div>
            </div>
     
            <div class="row justify-content-end">
                <div class="form-group col-md-2">
                    <label for="text" style="min-height: 17px;"></label>
                    <input type="text" name="text" id="text" class="form-control text-right" value="PROCESO DE PLANTA" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="procesoplanta"><strong>$</strong></label>
                    <input type="text" name="procesoplanta" id="procesoplanta" class="form-control" placeholder="">
                </div>
            </div>
        
        <div class="row justify-content-end">
            <div class="form-group col-md-2">
                <label for="text" style="min-height: 17px;"></label>
                <input type="text" name="text" id="text" class="form-control text-right" value="ADELANTOS" readonly>
            </div>
            <div class="form-group col-md-2">
                <label for="adelantosextras"><strong>$</strong></label>
                <input type="text" name="adelantosextras" id="adelantosextras" class="form-control" placeholder="">
            </div>
        </div>

            <div class="row justify-content-end">
                <div class="form-group col-md-2">
                    <label for="text" style="min-height: 17px;"></label>
                    <input type="text" name="text" id="text" class="form-control text-right" value="PRESTAMOS" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="prestamos"><strong>$</strong></label>
                    <input type="text" name="prestamos" id="prestamos" class="form-control" placeholder="">
                </div>
            </div>

            <div class="row justify-content-end">
                <div class="form-group col-md-2">
                    <label for="text" style="min-height: 17px;"></label>
                    <input type="text" name="text" id="text" class="form-control text-right" value="OTROS DESCUENTOS" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="otros_descuentos"><strong>$</strong></label>
                    <input type="text" name="otros_descuentos" id="otros_descuentos" class="form-control" placeholder="">
                </div>
            </div>

            <div class="row justify-content-end">
                <div class="form-group col-md-2">
                    <label for="text" style="min-height: 17px;"></label>
                    <input type="text" name="text" id="text" class="form-control text-right" value="TOTAL" readonly>
                </div>
                
                <div class="form-group col-md-2">
                    <label for="total"><strong>$</strong></label>
                    <input type="text" name="total" id="total" data-numeric="true" class="form-control text-right" readonly>
                </div>
            </div>
        </div>  
        <div class="row justify-content-end">
            
            <div class="form-group col-md-2">
                <label for="text " ></label>
                <input type="text" name="text" id="text" class="form-control text-right" value="OBSERVACION" readonly>
            </div>       

            <div class="form-group col-md-10">
                <label for="comentario"></label>
                <textarea type="comentario" name="comentario" id="comentario" class="form-control" placeholder=""></textarea>
               
            </div>


        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-secondary btn-md">
                {{ __('GUARDAR LIQUIDACIÓN') }}
            </button>
        </div>
        <P>        
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')

    <script>
        $('.crear-muestras').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Crear liquidación?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, confirmar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });
         // LLENA LOS CAMPOS DEL CLIENTE Y LAS CONDICIONES O REQUERIMIENTOS
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#cliente_id').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            
            // Update existing fields
            $('#datos_cliente').val(selectedOption.data('datos'));
            $('#ruc_empresa').val(selectedOption.data('empresa'));
            $('#razon_social').val(selectedOption.data('razon-social'));
            $('#direccion').val(selectedOption.data('direccion'));
            $('#telefono').val(selectedOption.data('telefono'));
            $('#proteccion_au').val(selectedOption.data('proteccion-au'));
            $('#proteccion_ag').val(selectedOption.data('proteccion-ag'));
            $('#proteccion_cu').val(selectedOption.data('proteccion-cu'));
            $('#deduccion_au').val(selectedOption.data('deduccion-au'));
            $('#deduccion_ag').val(selectedOption.data('deduccion-ag'));
            $('#deduccion_cu').val(selectedOption.data('deduccion-cu'));
            $('#refinamiento_au').val(selectedOption.data('refinamiento-au'));
            $('#refinamiento_ag').val(selectedOption.data('refinamiento-ag'));
            $('#refinamiento_cu').val(selectedOption.data('refinamiento-cu'));
            $('#maquila').val(selectedOption.data('maquila'));
            $('#analisis').val(selectedOption.data('analisis'));
            $('#estibadores').val(selectedOption.data('estibadores'));
            $('#molienda').val(selectedOption.data('molienda'));
            $('#igv').val(selectedOption.data('igv'));
            
            // Llamar a la función para calcular y mostrar el valor de IGV
           calcularYMostrarIGV();
            // Add additional fields handling
            $('#penalidad_as').val(selectedOption.data('penalidad-as'));
            $('#penalidad_sb').val(selectedOption.data('penalidad-sb'));
            $('#penalidad_pb').val(selectedOption.data('penalidad-pb'));
            $('#penalidad_zn').val(selectedOption.data('penalidad-zn'));
            $('#penalidad_bi').val(selectedOption.data('penalidad-bi'));
            $('#penalidad_hg').val(selectedOption.data('penalidad-hg'));
            $('#penalidad_s').val(selectedOption.data('penalidad-s'));
            $('#penalidad_h2o').val(selectedOption.data('penalidad-h2o'));
            $('#merma').val(selectedOption.data('merma'));
            $('#pagable_au').val(selectedOption.data('pagable-au'));
            $('#pagable_ag').val(selectedOption.data('pagable-ag'));
            $('#pagable_cu').val(selectedOption.data('pagable-cu'));
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#muestra_id').on('change', function() {
            var muestra_id = $(this).val();
            var selectedOption = $(this).find('option:selected');

            // Obtener los valores de los atributos data-*
            var codigo = selectedOption.data('codigo');
            var au = selectedOption.data('au');
            var ag = selectedOption.data('ag');
            var cu = selectedOption.data('cu');
            var as = selectedOption.data('as');
            var sb = selectedOption.data('sb');
            var pb = selectedOption.data('pb');
            var zn = selectedOption.data('zn');
            var bi = selectedOption.data('bi');
            var hg = selectedOption.data('hg');
            var s = selectedOption.data('s');
            var humedad = selectedOption.data('humedad');
            var obs = selectedOption.data('obs');

            // Mostrar los valores en los campos correspondientes
            $('#codigo').val(codigo);
            $('#au').val(au);
            $('#ag').val(ag);
            $('#cu').val(cu);
            $('#as').val(as);
            $('#sb').val(sb);
            $('#pb').val(pb);
            $('#zn').val(zn);
            $('#bi').val(bi);
            $('#hg').val(hg);
            $('#s').val(s);
            $('#humedad').val(humedad);
            $('#obs').val(obs);
        });
    });
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Función para actualizar o borrar los campos según el estado de los checkboxes
        function actualizarCampos() {
            // Obtener los valores de AU, AG y CU desde los datos de la opción seleccionada
            var auString = $('option:selected', '#muestra_id').data('au');
            var auDecimal = parseFloat(auString);
            
            var agString = $('option:selected', '#muestra_id').data('ag');
            var agDecimal = parseFloat(agString);

            var cuString = $('option:selected', '#muestra_id').data('cu');
            var cuDecimal = parseFloat(cuString);

            // Verificar el estado de los checkboxes
            var aplicarFactorAu = $('#aplicar_factor_au').is(':checked');
            var aplicarFactorAg = $('#aplicar_factor_ag').is(':checked');

            // Actualizar o limpiar #ley_au según el estado del checkbox aplicar_factor_au
            if (!aplicarFactorAu) {
                if (!isNaN(auDecimal)) {
                    var leyOro = auDecimal * 1.1023;
                    $('#ley_au').val(leyOro.toFixed(3));
                } else {
                    $('#ley_au').val(auDecimal.toFixed(3));
                }
            } else {
                $('#ley_au').val(auDecimal.toFixed(3));
            }

            // Actualizar o limpiar #ley_ag según el estado del checkbox aplicar_factor_ag
            if (!aplicarFactorAg) {
                if (!isNaN(agDecimal)) {
                    var leyPlata = agDecimal * 1.1023;
                    $('#ley_ag').val(leyPlata.toFixed(3));
                } else {
                    $('#ley_ag').val(agDecimal.toFixed(3));
                }
            } else {
                $('#ley_ag').val(agDecimal.toFixed(3));
            }

            // Limpiar siempre #ley_cu
            if (!isNaN(cuDecimal)) {
                var leyCobre = cuDecimal;
                $('#ley_cu').val(leyCobre.toFixed(3));
            } else {
                $('#ley_cu').val('');
            }
        }

        // Manejar cambios en el selector y los checkboxes
        $('#muestra_id').on('change', actualizarCampos);
        $('#aplicar_factor_au').on('change', actualizarCampos);
        $('#aplicar_factor_ag').on('change', actualizarCampos);
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Elementos del DOM necesarios para el cálculo
        const pesoInput = document.getElementById('peso');
        const mermaInput = document.getElementById('merma');
        const tmsInput = document.getElementById('tms');
        const tmnsInput = document.getElementById('tmns');
        const muestraIdSelect = document.getElementById('muestra_id');
        const clienteIdSelect = document.getElementById('cliente_id');

        // Función para obtener y actualizar valores al cambiar la muestra
        function actualizarValoresMuestra() {
            var muestraSeleccionada = muestraIdSelect.options[muestraIdSelect.selectedIndex];

            if (muestraSeleccionada) {
                var humedad = parseFloat(muestraSeleccionada.getAttribute('data-humedad'));
                calcularPesoTMS(humedad); // Llamar a la función de cálculo con la humedad obtenida
            } else {
                console.error('Error: No se ha seleccionado una muestra válida.');
            }
        }

        // Función para calcular peso, tms y tmns
        function calcularPesoTMS(humedad) {
            var peso = parseFloat(pesoInput.value);
            var merma = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-merma')) || 0;

            if (!isNaN(peso) && !isNaN(humedad) && !isNaN(merma)) {
                // Operación 1: Calcular resultado
                var resultado = peso - (peso * humedad / 100);
                resultado = Math.round(resultado * 1000) / 1000;
                tmsInput.value = resultado.toFixed(3);

                // Operación 2: Calcular tmns
                var tmns = resultado - (resultado * merma / 100);
                tmns = Math.floor(tmns * 1000 + 0.5) / 1000; // Redondea hacia abajo a 3 decimales
                tmnsInput.value = tmns.toFixed(3);
            } else {
                console.error('Error: peso, humedad o merma no son números válidos.');
            }
        }

        // Event listener para cambios en el selector de muestra
        muestraIdSelect.addEventListener('change', function() {
            actualizarValoresMuestra(); // Recalcular peso, tms y tmns al cambiar la muestra
        });

        // Event listener para cambios en el selector de cliente
        clienteIdSelect.addEventListener('change', function() {
            var humedad = parseFloat(muestraIdSelect.options[muestraIdSelect.selectedIndex].getAttribute('data-humedad'));
            calcularPesoTMS(humedad); // Recalcular peso, tms y tmns al cambiar el cliente
        });

        // Event listener para cambios en el input de peso
        pesoInput.addEventListener('input', function() {
            var humedad = parseFloat(muestraIdSelect.options[muestraIdSelect.selectedIndex].getAttribute('data-humedad'));
            calcularPesoTMS(humedad); // Recalcular peso, tms y tmns al cambiar el peso
        });

        // Llamada inicial para establecer valores iniciales y calcular las fórmulas
        actualizarValoresMuestra(); // Calcular peso, tms y tmns inicialmente con la muestra seleccionada
    });
</script>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Obtener elementos del DOM para oro (Au)
        const leyAuInput = document.getElementById('au');
        const pagableAuInput = document.getElementById('pagable_au');
        const deduccionAuInput = document.getElementById('deduccion_au');
        const proteccionAuInput = document.getElementById('proteccion_au');
        const formulaAuInput = document.getElementById('formula_au');
        const formulafinaAuInput=document.getElementById('formula_fi_au')
        const precioAuInput = document.getElementById('precio_au');
        const valorAuInput = document.getElementById('val_au');
        const refinamientoAuInput=document.getElementById('refinamiento_au');
        const finaAuInput=document.getElementById('fina_au');

        // Obtener elementos del DOM para plata (Ag)
        const leyAgInput = document.getElementById('ag');
        const pagableAgInput = document.getElementById('pagable_ag');
        const deduccionAgInput = document.getElementById('deduccion_ag');
        const proteccionAgInput = document.getElementById('proteccion_ag');
        const formulaAgInput = document.getElementById('formula_ag');
        const formulafinaAgInput=document.getElementById('formula_fi_ag')
        const precioAgInput = document.getElementById('precio_ag');
        const valorAgInput = document.getElementById('val_ag');
        const refinamientoAgInput=document.getElementById('refinamiento_ag');
        const finaAgInput=document.getElementById('fina_ag');

        // Obtener elementos del DOM para cobre (Cu)
        const leyCuInput = document.getElementById('ley_cu');
        const pagableCuInput = document.getElementById('pagable_cu');
        const deduccionCuInput = document.getElementById('deduccion_cu');
        const proteccionCuInput = document.getElementById('proteccion_cu');
        const formulaCuInput = document.getElementById('formula_cu');
        const formulafinaCuInput=document.getElementById('formula_fi_cu')
        const precioCuInput = document.getElementById('precio_cu');
        const valorCuInput = document.getElementById('val_cu');
        const refinamientoCuInput=document.getElementById('refinamiento_cu');
        const finaCuInput=document.getElementById('fina_cu');
        // Elemento select de cliente
        const muestraIdSelect = document.getElementById('muestras_id');
        const clienteIdSelect = document.getElementById('cliente_id');

        //Deducciones
        const maquilaInput = document.getElementById('maquila');
        const analisisInput = document.getElementById('analisis');
        const estibadoresInput = document.getElementById('estibadores');
        const moliendaInput = document.getElementById('molienda'); 
        // Función para actualizar los valores de deducción y pagable según el cliente seleccionado
        function actualizarValoresCliente() {
          
            deduccionAuInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-deduccion-au')) || 0;
            pagableAuInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-pagable-au')) || 0;  
            proteccionAuInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-proteccion-au')) || 0;
            refinamientoAuInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-refinamiento-au')) || 0;

            deduccionAgInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-deduccion-ag')) || 0;
            pagableAgInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-pagable-ag')) || 0;
            proteccionAgInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-proteccion-ag')) || 0;
            refinamientoAgInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-refinamiento-ag')) || 0;

            deduccionCuInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-deduccion-cu')) || 0;
            pagableCuInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-pagable-cu')) || 0;
            proteccionCuInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-proteccion-cu')) || 0;
            refinamientoCuInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-refinamiento-cu')) || 0;

            maquilaInput.value =     parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-maquila')) || 0;
            analisisInput.value =     parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-analisis')) || 0;
            estibadoresInput.value =     parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-estibadores')) || 0;
            moliendaInput.value =     parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-molienda')) || 0;
        }
        function actualizarValoresMuestra() {

            deduccionAuInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-deduccion-au')) || 0;
            pagableAuInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-pagable-au')) || 0;
            proteccionAuInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-proteccion-au')) || 0;
            refinamientoAuInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-refinamiento-au')) || 0;

            deduccionAgInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-deduccion-ag')) || 0;
            pagableAgInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-pagable-ag')) || 0;
            proteccionAgInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-proteccion-ag')) || 0;
            refinamientoAgInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-refinamiento-ag')) || 0;

            deduccionCuInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-deduccion-cu')) || 0;
            pagableCuInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-pagable-cu')) || 0;
            proteccionCuInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-proteccion-cu')) || 0;
            refinamientoCuInput.value = parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-refinamiento-cu')) || 0;

            maquilaInput.value =     parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-maquila')) || 0;
            analisisInput.value =     parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-analisis')) || 0;
            estibadoresInput.value =     parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-estibadores')) || 0;
            moliendaInput.value =     parseFloat(clienteIdSelect.options[clienteIdSelect.selectedIndex].getAttribute('data-molienda')) || 0;
        }
        // Función para calcular y actualizar la fórmula para oro (Au)
    function calcularFormulaAu() {
    const leyAu = parseFloat(leyAuInput.value) || 0;
    const pagableAu = parseFloat(pagableAuInput.value) || 0;
    const deduccionAu = parseFloat(deduccionAuInput.value) || 0;
    const proteccionAu = parseFloat(proteccionAuInput.value) || 0;
    const refinamientoAu = parseFloat(refinamientoAuInput.value) || 0;
    const cotizacionAu = parseFloat(document.getElementById('cotizacion_au').value) || 0;

    // Establecer 3 decimales por defecto
    let decimalCount = parseInt(document.getElementById('decimal_count').value) || 3;

    // Obtener el estado del checkbox para aplicar el factor
    const aplicarFactorAu = document.getElementById('aplicar_factor_au').checked;

    // Función para redondear a los decimales especificados
    function redondear(valor, decimales) {
        const factor = Math.pow(10, decimales);
        return Math.floor(valor * factor) / factor;
    }

    // Verificar si todos los valores son válidos antes de calcular
    if (cotizacionAu >= 0 && !isNaN(leyAu) && !isNaN(pagableAu) && !isNaN(deduccionAu) && !isNaN(proteccionAu) && !isNaN(cotizacionAu) && !isNaN(refinamientoAu)) {
        // Invertir la lógica: aplicar el factor si el checkbox está desmarcado
        const leyOro = aplicarFactorAu ? leyAu : leyAu * 1.1023;
        const resultadoAu = redondear(((leyOro * (pagableAu / 100)) - deduccionAu), decimalCount);
        const formulaAu = redondear(((leyOro * (pagableAu / 100)) - deduccionAu), decimalCount);
        const resultadopreAu = cotizacionAu - proteccionAu;

        // Verificar si resultadoAu o resultadopreAu son negativos
        const resultadovalAu = (resultadoAu >= 0 && resultadopreAu >= 0) ? 
            (resultadoAu * resultadopreAu) : 
            0.000;

        const resultadofinaAu = (formulaAu >= 0 && refinamientoAu >= 0) ? 
            (formulaAu * refinamientoAu) : 
            0.000;

        const valorPorDefecto = '0.000';
        finaAuInput.value = (resultadofinaAu >= 0) ? resultadofinaAu.toFixed(decimalCount) : valorPorDefecto;
        formulaAuInput.value = (formulaAu >= 0) ? formulaAu.toFixed(decimalCount) : valorPorDefecto;
        valorAuInput.value = (resultadovalAu >= 0) ? resultadovalAu.toFixed(decimalCount) : valorPorDefecto;
        formulafinaAuInput.value = formulaAu.toFixed(decimalCount);  
        precioAuInput.value = resultadopreAu.toFixed(decimalCount); 
        
        calcularSumaTotal();
        calcularSumaTotalDeducciones();
        calcularTotalUS();
        calcularYMostrarTotalUSPorTMNS();
        calcularYMostrarIGV();
    } else {
        formulaAuInput.value = ''; // Limpiar el campo si falta algún valor   
        formulafinaAuInput.value = '';
        precioAuInput.value = '';
        valorAuInput.value = '';
        finaAuInput.value = '';
    }
}

// Agregar un event listener para recalcular cuando el usuario cambia la selección de decimales o el checkbox de factor
document.getElementById('decimal_count').addEventListener('change', calcularFormulaAu);
document.getElementById('aplicar_factor_au').addEventListener('change', calcularFormulaAu);

// Establecer el valor inicial de 'decimal_count' a 3 si no se ha configurado aún
document.getElementById('decimal_count').value = 3;



function calcularFormulaAg() {
    const leyAg = parseFloat(leyAgInput.value) || 0;
    const pagableAg = parseFloat(pagableAgInput.value) || 0;
    const deduccionAg = parseFloat(deduccionAgInput.value) || 0;
    const proteccionAg = parseFloat(proteccionAgInput.value) || 0;
    const refinamientoAg = parseFloat(refinamientoAgInput.value) || 0;
    const cotizacionAg = parseFloat(document.getElementById('cotizacion_ag').value) || 0;

    // Obtener el estado del checkbox para aplicar el factor
    const aplicarFactorAg = document.getElementById('aplicar_factor_ag').checked;

    // Verificar si todos los valores son válidos antes de calcular
    if (cotizacionAg >= 0 && !isNaN(leyAg) && !isNaN(pagableAg) && !isNaN(deduccionAg) && !isNaN(proteccionAg) && !isNaN(cotizacionAg) && !isNaN(refinamientoAg)) {
        // Invertir la lógica: aplicar el factor si el checkbox está desmarcado
        const leyPlata = aplicarFactorAg ? leyAg : leyAg * 1.1023;
        const resultadoAg = Math.floor(((leyPlata * (pagableAg / 100)) - deduccionAg) * 1000) / 1000; // redondeando a menor
        const formulaAg = Math.floor(((leyPlata * (pagableAg / 100)) - deduccionAg) * 1000) / 1000;
        const resultadopreAg = cotizacionAg - proteccionAg;

        // Verificar si resultadoAg o resultadopreAg son negativos
        const resultadovalAg = (resultadoAg >= 0 && resultadopreAg >= 0) ? 
            (resultadoAg * resultadopreAg) : 
            0.000;

        const resultadofinaAg = (formulaAg >= 0 && refinamientoAg >= 0) ? 
            (formulaAg * refinamientoAg) : 
            0.000;

        const valorPorDefecto = '0.000';
        finaAgInput.value = (resultadofinaAg >= 0) ? resultadofinaAg.toFixed(3) : valorPorDefecto;
        formulaAgInput.value = (resultadoAg >= 0) ? resultadoAg.toFixed(3) : valorPorDefecto;
        valorAgInput.value = (resultadovalAg >= 0) ? resultadovalAg.toFixed(3) : valorPorDefecto;

        formulafinaAgInput.value = formulaAg.toFixed(3);
        precioAgInput.value = resultadopreAg.toFixed(3);

        calcularSumaTotal();
        calcularSumaTotalDeducciones();
        calcularTotalUS();
        calcularYMostrarTotalUSPorTMNS();
        calcularYMostrarIGV();
    } else {
        formulaAgInput.value = ''; // Limpiar el campo si falta algún valor
        formulafinaAgInput.value = '';
        precioAgInput.value = '';
        valorAgInput.value = '';
        finaAgInput.value = '';
    }
}

// Agregar un event listener para recalcular cuando el usuario cambia la selección de decimales o el checkbox de factor
document.getElementById('decimal_count').addEventListener('change', calcularFormulaAg);
document.getElementById('aplicar_factor_ag').addEventListener('change', calcularFormulaAg);

        // Función para calcular y actualizar la fórmula para cobre (Cu)
        function calcularFormulaCu() {
            const leyCu = parseFloat(leyCuInput.value) || 0;
            const pagableCu = parseFloat(pagableCuInput.value) || 0;
            const deduccionCu = parseFloat(deduccionCuInput.value) || 0;
            const proteccionCu = parseFloat(proteccionCuInput.value) || 0;
            const refinamientoCu = parseFloat(refinamientoCuInput.value) || 0;
            const cotizacionCu = parseFloat(document.getElementById('cotizacion_cu').value) || 0;
    
    // Obtener el estado del checkbox
    const usarValor69 = document.getElementById('checkboxResultadoFinaCu').checked;

    // Verificar si todos los valores son válidos antes de calcular
    if (cotizacionCu >= 0 && !isNaN(leyCu) && !isNaN(pagableCu) && !isNaN(deduccionCu) && !isNaN(proteccionCu) && !isNaN(cotizacionCu) && !isNaN(refinamientoCu)) {

        const resultadoCu = ((leyCu * (pagableCu / 100)) - deduccionCu);
        const formulaCu = ((leyCu * (pagableCu / 100)) - deduccionCu);
        const resultadopreCu = Math.floor((cotizacionCu - proteccionCu) * 2204.62 * 100) / 100;

        // Verificar si resultadoCu o resultadopreCu son negativos
        const resultadovalCu = (resultadoCu >= 0 && resultadopreCu >= 0) ? 
            Math.floor((resultadoCu * resultadopreCu / 100) * 1000) / 1000 : 
            0.000;

        // Condición especial para cotizacionCu igual a 0
        const resultadofinaCu = (cotizacionCu === 0) ? 
            (usarValor69 ? 69 : 0) : 
            (formulaCu >= 0 && refinamientoCu >= 0) ? 
            (formulaCu * refinamientoCu * 2204.62 / 100) : 
            0.000;

        const valorPorDefecto = '0.000';
        formulaCuInput.value = (resultadoCu >= 0) ? resultadoCu.toFixed(3) : valorPorDefecto;
        finaCuInput.value = (resultadofinaCu >= 0) ? resultadofinaCu.toFixed(3) : valorPorDefecto;
        valorCuInput.value = resultadovalCu.toFixed(3);
        formulafinaCuInput.value = formulaCu.toFixed(3);
        precioCuInput.value = resultadopreCu.toFixed(3);

        calcularSumaTotal();
        calcularSumaTotalDeducciones();
        calcularTotalUS();
        calcularYMostrarTotalUSPorTMNS();
        calcularYMostrarIGV();

    } else {
        formulaCuInput.value = ''; // Limpiar el campo si falta algún valor
        precioCuInput.value = '';
        formulafinaCuInput.value = '';
        valorCuInput.value = '';
        finaCuInput.value = '';
    }
    document.getElementById('checkboxResultadoFinaCu').addEventListener('change', calcularFormulaCu);
}



        function calcularSumaTotal() {
            const resultadovalAu = parseFloat(valorAuInput.value) || 0;
            const resultadovalAg = parseFloat(valorAgInput.value) || 0;
            const resultadovalCu = parseFloat(valorCuInput.value) || 0;

            const sumaTotal = resultadovalAu + resultadovalAg + resultadovalCu;

            // Actualizar campo en el formulario con la suma total
            document.getElementById('total_valores').value = sumaTotal.toFixed(3); // Redondea a tres decimales

        }

        
// Función para calcular la suma total de deducciones
function calcularSumaTotalDeducciones() {

const finaAuInput = document.getElementById('fina_au');
const finaAgInput = document.getElementById('fina_ag');
const finaCuInput = document.getElementById('fina_cu');
const maquilaInput = document.getElementById('maquila');
const analisisInput = document.getElementById('analisis');
const estibadoresInput = document.getElementById('estibadores');
const transporteInput = document.getElementById('transporte');
const moliendaInput = document.getElementById('molienda');
const dolarInput = document.getElementById('dolar');
const pesoInput = document.getElementById('peso');
const tmnsInput = document.getElementById('tmns');
const transInput = document.getElementById('trans');

const resultadovaldeduccionesAu = parseFloat(finaAuInput.value) || 0;
const resultadovaldeduccionesAg = parseFloat(finaAgInput.value) || 0;
const resultadovaldeduccionesCu = parseFloat(finaCuInput.value) || 0;
const maquila = parseFloat(maquilaInput.value) || 0;
const analisis = parseFloat(analisisInput.value) || 0;
const estibadores = parseFloat(estibadoresInput.value) || 0;
const transporte = parseFloat(transporteInput.value) || 0;
const molienda = parseFloat(moliendaInput.value) || 0; 0
const dolar = parseFloat(dolarInput.value) || 0;
const peso = parseFloat(pesoInput.value) || 0;
const trans = parseFloat(transInput.value) || 0 ;
const tmns = parseFloat(tmnsInput.value) || 1; 

// Calcula el valor de division
const division = (tmns > 1) ? (analisis / tmns) : analisis;
document.getElementById('division').value = division === '' ? '' : division.toFixed(2);

// Verifica si dolar, estibadores y molienda son válidos para los cálculos

const resultadoestibadores = (dolar > 0 && estibadores > 0 && tmns > 0) ? (estibadores * peso / dolar / tmns) : '';
document.getElementById('resultadoestibadores').value = resultadoestibadores === '' ? '' : resultadoestibadores.toFixed(2);

//const resultadomolienda = (dolar > 0 && molienda > 0 && tmns > 0) ? (molienda * peso / dolar / tmns) : '';
const resultadomolienda = (dolar > 0 && molienda > 0 && tmns > 0) ? (molienda / dolar) : '';
document.getElementById('resultadomolienda').value = resultadomolienda === '' ? '' : resultadomolienda.toFixed(2);

const transporteCalculado = (dolar > 0) ? (trans / dolar /tmns) : '';
document.getElementById('transporte').value = transporteCalculado === '' ? '' : transporteCalculado.toFixed(2);

const sumaTotalDeduccion = maquila + (division === '' ? 0 : division) + (resultadoestibadores === '' ? 0 : resultadoestibadores) + resultadovaldeduccionesAu + resultadovaldeduccionesAg + resultadovaldeduccionesCu + transporte + (resultadomolienda === '' ? 0 : resultadomolienda);

document.getElementById('total_deducciones').value = sumaTotalDeduccion.toFixed(3);
calcularTotalUS();  // Llama a la función que necesites para otros cálculos
}
// Añade los eventos de cambio a todos los campos relevantes, incluyendo el nuevo campo
document.getElementById('fina_au').addEventListener('input', calcularSumaTotalDeducciones);
document.getElementById('fina_ag').addEventListener('input', calcularSumaTotalDeducciones);
document.getElementById('fina_cu').addEventListener('input', calcularSumaTotalDeducciones);
document.getElementById('maquila').addEventListener('input', calcularSumaTotalDeducciones);
document.getElementById('analisis').addEventListener('input', calcularSumaTotalDeducciones);
document.getElementById('estibadores').addEventListener('input', calcularSumaTotalDeducciones);
document.getElementById('transporte').addEventListener('input', calcularSumaTotalDeducciones);
document.getElementById('molienda').addEventListener('input', calcularSumaTotalDeducciones);
document.getElementById('dolar').addEventListener('input', calcularSumaTotalDeducciones); // Asegúrate de escuchar los cambios en 'dolar'
document.getElementById('tmns').addEventListener('input', calcularSumaTotalDeducciones); // Asegúrate de escuchar los cambios en 'tmns'

// Llama a la función inicialmente para establecer el valor correcto al cargar la página
calcularSumaTotalDeducciones();
document.addEventListener('DOMContentLoaded', calcularSumaTotalDeducciones);

        
        // Event listener para cambios en el selector de cliente
        clienteIdSelect.addEventListener('change', function() {
            actualizarValoresCliente(); // Actualizar deducción y pagable según el cliente seleccionado
            calcularFormulaAu(); // Recalcular la fórmula de oro
            calcularFormulaAg(); // Recalcular la fórmula de plata
            calcularFormulaCu(); // Recalcular la fórmula de cobre
          
        });
        muestraIdSelect.addEventListener('change', function() {
            actualizarValoresMuestra(); // Actualizar deducción y pagable según el cliente seleccionado
            calcularFormulaAu(); // Recalcular la fórmula de oro
            calcularFormulaAg(); // Recalcular la fórmula de plata
            calcularFormulaCu(); // Recalcular la fórmula de cobre
            
           
        });
        
        // Llamada inicial para establecer valores iniciales y calcular las fórmulas
        actualizarValoresCliente();
        actualizarValoresMuestra();
        calcularFormulaAu();
        calcularFormulaAg();
        calcularFormulaCu();
        calcularTotalUS();
        calcularYMostrarTotalUSPorTMNS();
        calcularYMostrarIGV();
    });
</script>
<script>
    // Obtener referencias a los campos
    const pesoInput = document.getElementById('peso');
    const loteInput = document.getElementById('lote');
    const cotizacionAuInput = document.getElementById('cotizacion_au');
    const cotizacionAgInput = document.getElementById('cotizacion_ag');
    const cotizacionCuInput = document.getElementById('cotizacion_cu');
    const productoInput = document.getElementById('producto');
    const clienteSelect = document.getElementById('cliente_id');

    // Función para habilitar o deshabilitar el selector de cliente
    function validarCampos() {
        // Verificar si todos los campos tienen valor
        if (pesoInput.value.trim() !== '' &&
            loteInput.value.trim() !== '' &&

            cotizacionAuInput.value.trim() !== '' &&
            cotizacionAgInput.value.trim() !== '' &&
            cotizacionCuInput.value.trim() !== '' &&
            productoInput.value !== '') {
            clienteSelect.disabled = false; // Habilitar selector de cliente
        } else {
            clienteSelect.disabled = true; // Deshabilitar selector de cliente
        }
    }

    // Agregar listeners para verificar cambios en los campos
    pesoInput.addEventListener('input', validarCampos);
    loteInput.addEventListener('input', validarCampos);
    cotizacionAuInput.addEventListener('input', validarCampos);
    cotizacionAgInput.addEventListener('input', validarCampos);
    cotizacionCuInput.addEventListener('input', validarCampos);
    productoInput.addEventListener('input', validarCampos);

    // Ejecutar la validación inicialmente
    validarCampos();
</script> 


<script>
    //MODIFICANDO LOS VALORES DE PENALIDADES
    
    function calcularTotalAS() {
            // Obtener los valores seleccionados
            var muestra_id = document.getElementById('muestra_id').value;
            var cliente_id = document.getElementById('cliente_id').value;

            // Obtener los atributos de la muestra seleccionada para as
            var as = parseFloat(document.querySelector('#muestra_id option:checked').getAttribute('data-as'));
            var penalidad_as = parseFloat(document.getElementById('penalidad_as').value) || parseFloat(document.querySelector('#cliente_id option:checked').getAttribute('data-penalidad-as'));
            var val_as = parseFloat(document.getElementById('val_as').value);
            var pre_as = parseFloat(document.getElementById('pre_as').value);

            // Obtener los atributos de la muestra seleccionada para sb
            var sb = parseFloat(document.querySelector('#muestra_id option:checked').getAttribute('data-sb'));
            var penalidad_sb = parseFloat(document.getElementById('penalidad_sb').value) || parseFloat(document.querySelector('#cliente_id option:checked').getAttribute('data-penalidad-sb'));
            var val_sb = parseFloat(document.getElementById('val_sb').value);
            var pre_sb = parseFloat(document.getElementById('pre_sb').value);

            // Obtener los atributos de la muestra seleccionada para pb
            var pb = parseFloat(document.querySelector('#muestra_id option:checked').getAttribute('data-pb'));
            var penalidad_pb = parseFloat(document.getElementById('penalidad_pb').value) || parseFloat(document.querySelector('#cliente_id option:checked').getAttribute('data-penalidad-pb'));
            var val_pb = parseFloat(document.getElementById('val_pb').value);
            var pre_pb = parseFloat(document.getElementById('pre_pb').value);

            // Obtener los atributos de la muestra seleccionada para bi
            var bi = parseFloat(document.querySelector('#muestra_id option:checked').getAttribute('data-bi'));
            var penalidad_bi = parseFloat(document.getElementById('penalidad_bi').value) || parseFloat(document.querySelector('#cliente_id option:checked').getAttribute('data-penalidad-bi'));
            var val_bi = parseFloat(document.getElementById('val_bi').value);
            var pre_bi = parseFloat(document.getElementById('pre_bi').value);

            // Obtener los atributos de la muestra seleccionada para hg
            var hg = parseFloat(document.querySelector('#muestra_id option:checked').getAttribute('data-hg'));
            var penalidad_hg = parseFloat(document.getElementById('penalidad_hg').value) || parseFloat(document.querySelector('#cliente_id option:checked').getAttribute('data-penalidad-hg'));
            var val_hg = parseFloat(document.getElementById('val_hg').value);
            var pre_hg = parseFloat(document.getElementById('pre_hg').value);

            // Obtener los atributos de la muestra seleccionada para s
            var s = parseFloat(document.querySelector('#muestra_id option:checked').getAttribute('data-s'));
            var penalidad_s = parseFloat(document.getElementById('penalidad_s').value) || parseFloat(document.querySelector('#cliente_id option:checked').getAttribute('data-penalidad-s'));
            var val_s = parseFloat(document.getElementById('val_s').value);
            var pre_s = parseFloat(document.getElementById('pre_s').value);

                       // Validar los valores obtenidos y realizar los cálculos
                       var  total_as = 0, total_sb = 0, total_pb = 0, total_bi = 0, total_hg = 0, total_s = 0;

                       var total_as = (!isNaN(as) && !isNaN(penalidad_as) && !isNaN(val_as) && !isNaN(pre_as)) 
                            ? (as < val_as ? 0 : ((as - val_as) * penalidad_as) / pre_as) 
                            : 0;

                        document.getElementById('total_as').value = total_as.toFixed(3); // Redondear a 3 decimales


                        var total_sb = (!isNaN(sb) && !isNaN(penalidad_sb) && !isNaN(val_sb) && !isNaN(pre_sb)) 
                        ? (sb < val_sb ? 0 : ((sb - val_sb) * penalidad_sb) / pre_sb) 
                        : 0;

                        document.getElementById('total_sb').value = total_sb.toFixed(3); // Redondear a 3 decimales


                        var total_pb = (!isNaN(pb) && !isNaN(penalidad_pb) && !isNaN(val_pb) && !isNaN(pre_pb)) 
                        ? (pb < val_pb ? 0 : ((pb - val_pb) * penalidad_pb) / pre_pb)  
                            : 0;

                        document.getElementById('total_pb').value = total_pb.toFixed(3); // Redondear a 3 decimales


                        var total_bi = (!isNaN(bi) && !isNaN(penalidad_bi) && !isNaN(val_bi) && !isNaN(pre_bi))
                        ? (bi < val_bi ? 0 : ((bi - val_bi) * penalidad_bi) / pre_bi)   
                            : 0;

                        document.getElementById('total_bi').value = total_bi.toFixed(3); // Redondear a 3 decimales

                        var total_hg = (!isNaN(hg) && !isNaN(penalidad_hg) && !isNaN(val_hg) && !isNaN(pre_hg)) 
                        ? (hg < val_hg ? 0 : ((hg - val_hg) * penalidad_hg) / pre_hg)   
                            : 0;

                        document.getElementById('total_hg').value = total_hg.toFixed(3); // Redondear a 3 decimales

                        var total_s = (!isNaN(s) && !isNaN(penalidad_s) && !isNaN(val_s) && !isNaN(pre_s)) 
                        ? (s < val_s ? 0 : ((s - val_s) * penalidad_s) / pre_s)   
                            : 0;
                        document.getElementById('total_s').value = total_s.toFixed(3); // Redondear a 3 decimales

                        // Calcular total de penalidades
                        var total_penalidades = total_as + total_sb + total_pb + total_bi + total_hg + total_s;

                        // Mostrar el resultado en el campo total_penalidades solo si hay un valor calculado
                        if (total_penalidades !== 0) {
                            document.getElementById('total_penalidades').value = total_penalidades.toFixed(3); // Redondear a 3 decimales
                        } else {
                            document.getElementById('total_penalidades').value = ''; // Dejar el campo vacío si no hay valor calculado
                        }
                        calcularTotalUS();
                        }

                        // Llamar a calcularTotalAS cada vez que cambie la selección en las listas
                        document.getElementById('muestra_id').addEventListener('change', calcularTotalAS);
                        document.getElementById('cliente_id').addEventListener('change', calcularTotalAS);

                        // Añadir escuchadores de eventos a los campos de penalidad para recalcular al cambiar
                        document.getElementById('penalidad_as').addEventListener('input', calcularTotalAS);
                        document.getElementById('penalidad_sb').addEventListener('input', calcularTotalAS);
                        document.getElementById('penalidad_pb').addEventListener('input', calcularTotalAS);
                        document.getElementById('penalidad_bi').addEventListener('input', calcularTotalAS);
                        document.getElementById('penalidad_hg').addEventListener('input', calcularTotalAS);
                        document.getElementById('penalidad_s').addEventListener('input', calcularTotalAS);

                        // También añadir escuchadores para los valores y pre valores
                        document.getElementById('val_as').addEventListener('input', calcularTotalAS);
                        document.getElementById('pre_as').addEventListener('input', calcularTotalAS);
                        document.getElementById('val_sb').addEventListener('input', calcularTotalAS);
                        document.getElementById('pre_sb').addEventListener('input', calcularTotalAS);
                        document.getElementById('val_pb').addEventListener('input', calcularTotalAS);
                        document.getElementById('pre_pb').addEventListener('input', calcularTotalAS);
                        document.getElementById('val_bi').addEventListener('input', calcularTotalAS);
                        document.getElementById('pre_bi').addEventListener('input', calcularTotalAS);
                        document.getElementById('val_hg').addEventListener('input', calcularTotalAS);
                        document.getElementById('pre_hg').addEventListener('input', calcularTotalAS);
                        document.getElementById('val_s').addEventListener('input', calcularTotalAS);
                        document.getElementById('pre_s').addEventListener('input', calcularTotalAS);
                       
                        </script>
<script>
    // Llamar a calcularTotalAS cada vez que cambie la selección en las listas
    document.getElementById('muestra_id').addEventListener('change', calcularTotalAS);
    document.getElementById('cliente_id').addEventListener('change', calcularTotalAS);

    // Llamar a calcularTotalAS al cargar la página (opcional)
    window.onload = function() {
        calcularTotalAS();
    };
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Función para calcular la suma total de deducciones
function calcularSumaTotalDeducciones() {
    const finaAuInput = document.getElementById('fina_au');
    const finaAgInput = document.getElementById('fina_ag');
    const finaCuInput = document.getElementById('fina_cu');
    const maquilaInput = document.getElementById('maquila');
    const analisisInput = document.getElementById('analisis');
    const estibadoresInput = document.getElementById('estibadores');

    const resultadovaldeduccionesAu = parseFloat(finaAuInput.value) || 0;
    const resultadovaldeduccionesAg = parseFloat(finaAgInput.value) || 0;
    const resultadovaldeduccionesCu = parseFloat(finaCuInput.value) || 0;
    const maquila = parseFloat(maquilaInput.value) || 0;
    const analisis = parseFloat(analisisInput.value) || 0;
    const estibadores = parseFloat(estibadoresInput.value) || 0;

    const sumaTotalDeduccion = maquila + analisis + estibadores + resultadovaldeduccionesAu + resultadovaldeduccionesAg + resultadovaldeduccionesCu;

    document.getElementById('total_deducciones').value = sumaTotalDeduccion.toFixed(3);
    calcularTotalUS();
}

// Función para calcular el total US
function calcularTotalUS() {
    var total_valores = parseFloat(document.getElementById('total_valores').value) || 0;
    var total_deducciones = parseFloat(document.getElementById('total_deducciones').value) || 0;
    var total_penalidades = parseFloat(document.getElementById('total_penalidades').value) || 0;

    var total_us = (total_valores - total_deducciones - total_penalidades);

    document.getElementById('total_us').value = total_us.toFixed(3);
    calcularYMostrarTotalUSPorTMNS();
}

// Función para calcular y mostrar el total US por TMNS
function calcularYMostrarTotalUSPorTMNS() {
    var total_us = parseFloat(document.getElementById('total_us').value) || 0;
    var tmns = parseFloat(document.getElementById('tmns').value) || 0;

    var resultado = total_us * tmns;

    document.getElementById('valorporlote').value = resultado.toFixed(3);
    calcularYMostrarIGV();
}

// Función para calcular y mostrar el valor de IGV
function calcularYMostrarIGV() {
    var igv = parseFloat(document.getElementById('igv').value) || 0;

    var valorporlote = parseFloat(document.getElementById('valorporlote').value) || 0;

    if (igv === 18) {
        var valor_igv = valorporlote * igv / 100;
        document.getElementById('valor_igv').value = valor_igv.toFixed(3);
        calcularYMostrarTotalLiqui();
    } else {
        document.getElementById('valor_igv').value = '';
        document.getElementById('total_porcentajeliqui').value = valorporlote;
        document.getElementById('saldo').value = valorporlote;
        document.getElementById('total_liquidacion').value = valorporlote;
        document.getElementById('total').value = valorporlote; 
    }
}


function calcularYMostrarTotalLiqui() {
    var valor_igv = parseFloat(document.getElementById('valor_igv').value) || 0;
    var valorporlote = parseFloat(document.getElementById('valorporlote').value) || 0;

    var total_liqui = valor_igv + valorporlote;

    document.getElementById('total_porcentajeliqui').value = total_liqui.toFixed(3);
    calcularYMostrarDetraccion();
}

// Función para calcular y mostrar la detracción
function calcularYMostrarDetraccion() {
    var total_porcentajeliqui = parseFloat(document.getElementById('total_porcentajeliqui').value) || 0;
    var adelantos = parseFloat(document.getElementById('adelantos').value) || 0;

    var saldo = total_porcentajeliqui - adelantos;

    var igv = parseFloat(document.getElementById('igv').value) || 0;
    if (igv === 18) {
        var detraccion = saldo * 0.10;
        document.getElementById('detraccion').value = detraccion.toFixed(3);
    } else {
        document.getElementById('detraccion').value = '';
    }

    document.getElementById('saldo').value = saldo.toFixed(3);
    calcularYMostrarTotalLiquidacion();
}

// Función para calcular y mostrar el total de liquidación
function calcularYMostrarTotalLiquidacion() {
    var saldo = parseFloat(document.getElementById('saldo').value) || 0;
    var detraccion = parseFloat(document.getElementById('detraccion').value) || 0;

    var total_liquidacion = saldo - detraccion;

    document.getElementById('total_liquidacion').value = total_liquidacion.toFixed(3);

    var procesoplanta = parseFloat(document.getElementById('procesoplanta').value) || 0;
    var adelantosextras = parseFloat(document.getElementById('adelantosextras').value) || 0;
    var prestamos = parseFloat(document.getElementById('prestamos').value) || 0;
    var otros_descuentos = parseFloat(document.getElementById('otros_descuentos').value) || 0;
    var total = total_liquidacion - procesoplanta - adelantosextras - prestamos - otros_descuentos;

    // Redondear hacia abajo a 2 decimales
    var totalRedondeado = Math.floor(total * 100) / 100;

    document.getElementById('total').value = totalRedondeado.toFixed(2);
}

// Función para agregar eventos de entrada a los campos
function agregarEventos() {
    document.getElementById('fina_au').addEventListener('input', calcularSumaTotalDeducciones);
    document.getElementById('fina_ag').addEventListener('input', calcularSumaTotalDeducciones);
    document.getElementById('fina_cu').addEventListener('input', calcularSumaTotalDeducciones);
    document.getElementById('maquila').addEventListener('input', calcularSumaTotalDeducciones);
    document.getElementById('analisis').addEventListener('input', calcularSumaTotalDeducciones);
    document.getElementById('estibadores').addEventListener('input', calcularSumaTotalDeducciones);

    document.getElementById('total_valores').addEventListener('input', calcularTotalUS);
    document.getElementById('total_deducciones').addEventListener('input', calcularTotalUS);
    document.getElementById('total_penalidades').addEventListener('input', calcularTotalUS);

    document.getElementById('tmns').addEventListener('input', calcularYMostrarTotalUSPorTMNS);
    document.getElementById('valorporlote').addEventListener('input', calcularYMostrarIGV);

    document.getElementById('igv').addEventListener('input', calcularYMostrarIGV);
    document.getElementById('adelantos').addEventListener('input', calcularYMostrarDetraccion);
    document.getElementById('procesoplanta').addEventListener('input', calcularYMostrarTotalLiquidacion);
    document.getElementById('adelantosextras').addEventListener('input', calcularYMostrarTotalLiquidacion);
    document.getElementById('prestamos').addEventListener('input', calcularYMostrarTotalLiquidacion);
    document.getElementById('otros_descuentos').addEventListener('input', calcularYMostrarTotalLiquidacion);
}

document.addEventListener('DOMContentLoaded', agregarEventos);


</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('NroSalida').addEventListener('change', function() {
            // Obtener la opción seleccionada
            const selectedOption = this.options[this.selectedIndex];

            // Si no se ha seleccionado ningún valor, no hacer nada
            if (selectedOption.value === '') return;

            // Obtener los datos del atributo data- de la opción seleccionada
            const peso = selectedOption.getAttribute('data-peso');
            const lote = selectedOption.getAttribute('data-lote');
            const descripcion = selectedOption.getAttribute('data-descripcion');
            const producto = selectedOption.getAttribute('data-producto');
            const fechai = selectedOption.getAttribute('data-fechai'); // Capturar la fecha de ingreso

            // Mostrar en consola para verificar
            console.log("Peso:", peso, "Lote:", lote ,"Descripcion:", descripcion, "Producto:", producto, "Fecha Ingreso:", fechai);

            // Actualizar los campos correspondientes
            document.getElementById('peso').value = peso;
            document.getElementById('lote').value = lote;
            document.getElementById('descripcion').value = descripcion;
            document.getElementById('producto').value = producto;
            document.getElementById('fechai').value = fechai; // Asignar la fecha de ingreso
        });
    });
</script>
@endpush
