@extends('layouts.app')


@section('content')
    <div class="container-fluid ">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <h6 class="mt-2">
                                    {{ __('VER LIQUIDACIONES') }}
                                </h6>
                                
                            </div>
                           
                            <div class="col-md-6 text-end">
                                <a class="btn btn-danger btn-sm" href="{{ route('liquidaciones.index') }}">
                                    {{ __('VOLVER') }}
                                </a>
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
                                    </style>
                                </head>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>
                                        {{ __('Estás viendo el ID') }}
                                    </strong>
                                    <span class="badge text-bg-secondary">{{ $liquidacion->id }}</span>
                                    <strong>
                                        {{ __('con el codigo') }}
                                    </strong>
                                    <span class="badge text-bg-secondary">{{ $liquidacion->id }}</span>
                                    <strong>
                                        {{ __('y esta operación fue registrada el ') }}
                                    </strong>
                                        {{ $liquidacion->created_at->format('d-m-Y') }}
                                    <strong>
                                        {{ __('a la(s) ') }}
                                    </strong>
                                        {{ $liquidacion->created_at->format('H:i:s') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @if ($liquidacion->updated_at != $liquidacion->created_at)
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>
                                            {{ __('Estás viendo el ID') }}
                                        </strong>
                                        <span class="badge text-bg-secondary">
                                            {{ $liquidacion->id }}
                                        </span>
                                        <strong>
                                            {{ __('y esta operación fue actualizada el ') }}
                                        </strong>
                                            {{ $liquidacion->updated_at->format('d-m-Y') }}
                                        <strong>
                                            {{ __('a la(s) ') }}
                                        </strong>
                                            {{ $liquidacion->updated_at->format('H:i:s') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @else
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>
                                            {{ __('Este muestra aún no ha sido actualizada') }}
                                        </strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>

                 <div class="row">

                    <div class="form-group col-md-7">
                        <label for="muestra_id">COD. LABORATORIO</label>
                        <input type="text" name="muestra_id" id="muestra_id"  class="form-control" value = "{{ $liquidacion->muestra->codigo }}" readonly>
                    </div> 
                <div class="form-group col-md-5">
                    <label for="obs">OBSERVACION</label>
                    <input type="text" name="obs" id="obs"  class="form-control" value = "{{ $liquidacion->muestra->obs }}" readonly>
                </div> 
                </div> 
                <P>            
                <h6><strong>MOSTRANDO DATOS REGISTRADOS MANUALMENTE</strong></h6>          
                <div class="row">
                    <div class="form-group col-md-3 g-1">
                        <label for="NroSalida" class="text-muted">NUMERO DE TICKET</label>
                        <select name="NroSalida" id="NroSalida" class="form-control" disabled>
                            <option value="">Seleccione un NroSalida...</option>
                            @foreach($ingresos as $ingreso)
                                <option value="{{ $ingreso->NroSalida }}"
                                    data-peso="{{ $ingreso->peso_total }}" 
                                    data-lote="{{ $ingreso->ref_lote }}" 
                                    data-producto="{{ $ingreso->estado }}"
                                    @if($ingreso->NroSalida == $liquidacion->NroSalida) selected @endif>
                                    {{ $ingreso->NroSalida }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="fechai">FECHA INGRESO</label>
                        <input type="text" name="fechai" id="fechai"class="form-control"  value ="{{ $liquidacion->fechai }}"  readonly>
                    </div>
                     <div class="form-group col-md-2">
                        <label for="guia_remision">GUIA REMISION</label>
                        <input type="text" name="guia_remision" id="guia_remision"class="form-control"  value ="{{ optional($liquidacion->ingreso)->guia_remision }}"  readonly>
                    </div>
                     <div class="form-group col-md-2">
                        <label for="guia_transporte">GUIA TRANSPORTE</label>
                        <input type="text" name="guia_transporte" id="guia_transporte"class="form-control"  value ="{{ optional($liquidacion->ingreso)->guia_transporte }}"  readonly>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="descripcion">DESCRIPCION</label>
                        <input type="text" name="descripcion" id="descripcion"class="form-control"  value ="{{ optional($liquidacion->ingreso)->descripcion }}"  readonly>
                    </div>
                </div>
                 <div class="form-group col-md-2">
                        <label for="peso">PESO</label>
                        <input type="text" name="peso" id="peso"class="form-control"  value ="{{ $liquidacion->peso }}"  readonly>
                </div>

                    <div class="form-group col-md-2">
                        <label for="lote">LOTE</label>
                        <input type="text" name="lote" id="lote" class="form-control" value ="{{ $liquidacion->lote }}" readonly >
                    </div>
                    <div class="form-group col-md-2">
                        <label for="producto">PRODUCTO</label>
                        <input type="text" name="producto" id="producto" class="form-control"value = "{{ $liquidacion->producto }}" readonly >
                    </div>
                    <div class="form-group col-md-2">
                        <label for="cotizacion_au">COTIZACION ORO</label>
                        <input type="text" name="cotizacion_au" id="cotizacion_au" class="form-control" value ="{{ $liquidacion->cotizacion_au }}" readonly >
                    </div>
                    <div class="form-group col-md-2">
                        <label for="cotizacion_ag">COTIZACION PLATA</label>
                        <input type="text" name="cotizacion_ag" id="cotizacion_ag" class="form-control" value ="{{ $liquidacion->cotizacion_ag }}" readonly >
                    </div>
                    <div class="form-group col-md-2">
                        <label for="cotizacion_cu">COTIZACION COBRE</label>
                        <input type="text" name="cotizacion_cu" id="cotizacion_cu" class="form-control"value ="{{ $liquidacion->cotizacion_cu }}" readonly >
                    </div>
                    
                    <p>
                    <h6><strong>CLIENTE SELECCIONADO</strong></h6>  
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="cliente_id">DNI CLIENTE</label>
                            <input type="text" name="cliente_id" id="cliente_id"  class="form-control" value = "{{ $liquidacion->cliente->documento_cliente }}" readonly>
                        </div> 
                        <div class="form-group col-md-5">
                    <label for="datos_cliente">DATOS CLIENTES
                    </label>
                    <input type="text" name="datos_cliente" id="datos_cliente" class="form-control" value = "{{ $liquidacion->cliente->datos_cliente }}" readonly>
                </div>

                <div class="form-group col-md-2">
                    <label for="ruc_empresa">RUC EMPRESA</label>
                    <input type="text" name="ruc_empresa" id="ruc_empresa" class="form-control" value = "{{ $liquidacion->cliente->ruc_empresa }}" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="telefono">TELEFONO</label>
                    <input type="text" name="telefono" id="telefono" class="form-control"value = "{{ $liquidacion->cliente->telefono  }}" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label for="razon_social">RAZÓN SOCIAL</label>
                    <input type="text" name="razon_social" id="razon_social" class="form-control" value = "{{ $liquidacion->cliente->razon_social }}" readonly>
                </div>
               
                <div class="form-group col-md-5">
                    <label for="direccion">DIRECCION</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" value = "{{ $liquidacion->cliente->direccion }}" readonly>
                </div>
                <P>
                    <h6><strong>SECCION ADELANTO</strong></h6>  
                    <div class="form-group col-md-10">
                    <label for="resumen_id">
                        {{ __('RESUMEN ADELANTO') }}
                    </label>
                    @if ($liquidacion->resumen_id)
                        <input class="form-control" value="{{ $liquidacion->resumen->cliente->datos_cliente}} - TOTAL : {{ $liquidacion->resumen->total }}" disabled>
                    @else
                        <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                    @endif
                </div>   
                <P>
                <div class="row">
                    <div class="col-md-4">
                        <h6><strong>OBTENIENDO EL TOTAL TMNS</strong></h6>
                        <div class="form-group">
                            <label for="humedad">HUMEDAD</label>
                            <div class="input-group"> 
                                <input type="text" name="humedad" id="humedad" class="form-control" value="{{ $liquidacion->muestra->humedad}}" readonly>
                                <span class="input-group-text">%</span> 
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <label for="tms">TMS</label>
                            <input type="text" id="tms" class="form-control"  value="{{ $liquidacion->tms}}" readonly>
                        </div>
                    
                        <div class="form-group">
                            <label for="merma">MERMA</label>
                            <div class="d-flex justify-content-between">
                                <div class="input-group" style="flex: 1; margin-right: 5px;">
                                    <input type="text" name="merma" id="merma" class="form-control" value="{{ old('merma', $liquidacion->cliente->requerimientos->merma) }}" oninput="calcularTMS()" readonly>
                                    <span class="input-group-text">%</span>
                                </div>
                                <div class="input-group" style="flex: 1;">
                                    <input type="text" name="merma2" id="merma2" class="form-control" value="{{ old('merma2', $liquidacion->merma2) }}" readonly>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    <P>
                        <div class="form-group">
                            <label for="tmns"><strong> TONELADAS METRICA NETAS SECAS</strong></label>
                            <input type="text" name="tmns" id="tmns" class="form-control text-center " value="{{ $liquidacion->tmns}}" readonly >
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <h6><strong>VALORES</strong></h6>
                                            
                        <div class="form-group">
                            <label for="cu">COBRE</label>
                            <div class="input-group">  
                               
                            <input type="text" name="cu" id="cu" class="form-control" value="{{ $liquidacion->muestra->cu}}" readonly>
                                <span class="input-group-text">%</span>
                        </div>
                    </div>
                    
                        <div class="form-group">
                            <label for="ag">PLATA</label>
                            <input type="text" name="ag" id="ag" class="form-control" value="{{ $liquidacion->muestra->ag}}"readonly>
                        </div>

                    <div class="form-group">
                        <label for="au">ORO</label>
                        <input type="text" name="au" id="au" class="form-control" value="{{ $liquidacion->muestra->au}}"readonly>
                    </div>
                </div>
                    
                    <div class="col-md-4">
                        <h6><strong>PROTECCION</strong></h6>
                        <div class="form-group">
                            <label for="proteccion_cu">PROTECCIÓN COBRE</label>
                            <div class="d-flex justify-content-between">
                                <input type="text" name="proteccion_cu" id="proteccion_cu" class="form-control me-2" value="{{ old('proteccion_cu', $liquidacion->cliente->requerimientos->proteccion_cu) }}" oninput="calcularformulac();" style="flex: 1;" readonly>
                                
                                <input type="text" name="proteccion_cu2" id="proteccion_cu2" class="form-control" value="{{ old('proteccion_cu2', $liquidacion->proteccion_cu2) }}" style="flex: 1;" readonly>
                            </div>
                        </div>  
                        <div class="form-group">
                            <label for="proteccion_ag">PROTECCIÓN PLATA</label>
                            <div class="d-flex justify-content-between">
                                <input type="text" name="proteccion_ag" id="proteccion_ag" class="form-control me-2" value="{{ old('proteccion_ag', $liquidacion->cliente->requerimientos->proteccion_ag) }}" oninput="calcularformulag();" style="flex: 1;" readonly>
                                
                                <input type="text" name="proteccion_ag2" id="proteccion_ag2" class="form-control" value="{{ old('proteccion_ag2', $liquidacion->proteccion_ag2) }}" style="flex: 1;" readonly>
                            </div>
                        </div>
                        
  
                        <div class="form-group">
                            <label for="proteccion_au">PROTECCIÓN ORO</label>
                            <div class="d-flex justify-content-between">
                                <input type="text" name="proteccion_au" id="proteccion_au" class="form-control me-2" value="{{ old('proteccion_au', $liquidacion->cliente->requerimientos->proteccion_au) }}" oninput="calcularformulaau();" style="flex: 1;" readonly>
                                
                                <input type="text" name="proteccion_au2" id="proteccion_au2" class="form-control" value="{{ old('proteccion_au2', $liquidacion->proteccion_au2) }}" style="flex: 1;" readonly>
                            </div>
                        </div>                    
                    </div>
                </div>                
    <p>
        <div class="container"> 
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="ley_cu">LEY COBRE</label>
                    <input type="text" name="ley_cu" id="ley_cu" class="form-control" value="{{ $liquidacion->ley_cu}}"readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="pagable_cu">% PAGABLE COBRE</label>
                    <div class="d-flex">
                        <div class="input-group me-2" style="flex: 1;">
                            <input type="text" name="pagable_cu" id="pagable_cu" class="form-control" value="{{ old('pagable_cu', $liquidacion->cliente->requerimientos->pagable_cu)}}" oninput="calcularformulacu()" readonly>
                            <span class="input-group-text small-percent">%</span>
                        </div>
                        <div class="input-group" style="flex: 1;">
                            <input type="text" name="pagable_cu2" id="pagable_cu2" class="form-control" value="{{ old('pagable_cu2', $liquidacion->pagable_cu2)}}" oninput="" readonly>
                            <span class="input-group-text small-percent">%</span>
                        </div>
                    </div>
                </div>
            
                <div class="form-group col-md-2">
                    <label for="deduccion_cu"><strong>DEDUC. COBRE</strong></label>
                    <div class="d-flex">
                        <div class="input-group me-2" style="flex: 1;">
                            <input type="text" name="deduccion_cu" id="deduccion_cu" class="form-control" value="{{ old('deduccion_cu', $liquidacion->cliente->requerimientos->deduccion_cu)}}" oninput="calcularformulacu()" readonly>
                        </div>
                        <div class="input-group" style="flex: 1;">
                            <input type="text" name="deduccion_cu2" id="deduccion_cu2" class="form-control" value="{{ old('deduccion_cu2', $liquidacion->deduccion_cu2)}}" oninput="" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label for="formula_cu"><strong>FORMULA</strong></label>
                    <div class="input-group"> 
                    <input type="text" name="formula_cu" id="formula_cu" class="form-control" value="{{ $liquidacion->formula_cu}}" readonly>
                    <span class="input-group-text">%</span>
                </div>
                </div>
                <div class="form-group col-md-2">
                    <label for="precio_cu"><strong>PRECIO COBRE</strong></label>
                    <input type="text" name="precio_cu" id="precio_cu" class="form-control"   value="{{ $liquidacion->precio_cu}}"readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="val_cu"><strong>VALOR COBRE</strong></label>
                    <input type="text" name="val_cu" id="val_cu" class="form-control"  value="{{ $liquidacion->val_cu}}" readonly>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="ley_ag">LEY PLATA</label>
                    <input type="text" name="ley_ag" id="ley_ag" class="form-control" value="{{ $liquidacion->ley_ag}}" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="pagable_ag">% PAGABLE PLATA</label>
                    <div class="d-flex">
                        <div class="input-group" style="flex: 1;">
                            <input type="text" name="pagable_ag" id="pagable_ag" class="form-control" value="{{ old('pagable_ag', $liquidacion->cliente->requerimientos->pagable_ag)}}" oninput="calcularformulaag()" readonly>
                            <span class="input-group-text small-percent">%</span>
                        </div>
                        <div class="input-group" style="flex: 1;">
                            <input type="text" name="pagable_ag2" id="pagable_ag2" class="form-control" value="{{ old('pagable_ag2', $liquidacion->pagable_ag2 ) }}" oninput="" readonly>
                            <span class="input-group-text small-percent">%</span>
                        </div>
                    </div>
                    
                </div>
                <div class="form-group col-md-2">
                    <label for="deduccion_ag"><strong>DEDUC. PLATA</strong></label>
                    <div class="d-flex">
                        <div class="input-group me-2" style="flex: 1;">
                            <input type="text" name="deduccion_ag" id="deduccion_ag" class="form-control" value="{{ old('deduccion_ag', $liquidacion->cliente->requerimientos->deduccion_ag)}}" oninput="calcularformulaag()" readonly>
                        </div>
                        <div class="input-group" style="flex: 1;">
                            <input type="text" name="deduccion_ag2" id="deduccion_ag2" class="form-control" value="{{ old('deduccion_ag2', $liquidacion->deduccion_ag2)}}" oninput="" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label for="formula_ag"><strong>FORMULA</strong></label>
                    <input type="text" name="formula_ag" id="formula_ag" class="form-control" value="{{ $liquidacion->formula_ag}}" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="precio_ag"><strong>PRECIO PLATA</strong></label>
                    <input type="text" name="precio_ag" id="precio_ag" class="form-control" value="{{ $liquidacion->precio_ag}}"readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="val_ag"><strong>VALOR PLATA</strong></label>
                    <input type="text" name="val_ag" id="val_ag" class="form-control" value="{{ $liquidacion->val_ag}}"readonly>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="ley_au">LEY ORO</label>
                    <input type="text" name="ley_au" id="ley_au" class="form-control" value="{{ $liquidacion->ley_au}}" readonly>
                </div>
                <div class="form-group col-md-2">   
                    <label for="pagable_au">% PAGABLE ORO</label>
                    <div class="d-flex">
                        <div class="input-group" style="flex: 1;">
                            <input type="text" name="pagable_au" id="pagable_au" class="form-control" value="{{ old('pagable_au', $liquidacion->cliente->requerimientos->pagable_au)}}" oninput="calcularformulaau()" readonly>
                            <span class="input-group-text small-percent">%</span>
                        </div>
                        <div class="input-group" style="flex: 1;">
                            <input type="text" name="pagable_au2" id="pagable_au2" class="form-control" value="{{ old('pagable_au2', $liquidacion->pagable_au2)}}" oninput="" readonly>
                            <span class="input-group-text small-percent">%</span>
                        </div>
                    </div>
                    <style>
                        .small-percent {
                            font-size: 0.5rem; /* Hacer el porcentaje aún más pequeño */
                            padding: 0.1rem 0.2rem; /* Reducir el padding para un ajuste más compacto */
                        }
                    </style>
                </div>
                
                <div class="form-group col-md-2">
                    <label for="deduccion_au"><strong>DEDUC. ORO</strong></label>
                    <div class="d-flex">
                        <div class="input-group me-2" style="flex: 1;">
                            <input type="text" name="deduccion_au" id="deduccion_au" class="form-control" value="{{ old('deduccion_au', $liquidacion->cliente->requerimientos->deduccion_au)}}" oninput="calcularformulaau()" readonly>
                        </div>
                        <div class="input-group" style="flex: 1;">
                            <input type="text" name="deduccion_au2" id="deduccion_au2" class="form-control" value="{{ old('deduccion_au2', $liquidacion->deduccion_au2)}}" oninput="" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label for="formula_au"><strong>FORMULA</strong></label>
                    <input type="text" name="formula_au" id="formula_au" class="form-control" value="{{ $liquidacion->formula_au}}" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="precio_au"><strong>PRECIO ORO</strong></label>
                    <input type="text" name="precio_au" id="precio_au" class="form-control" value="{{ $liquidacion->precio_au}}" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="val_au"><strong>VALOR ORO</strong></label>
                    <input type="text" name="val_au" id="val_au" class="form-control" value="{{ $liquidacion->val_au}}"readonly>
                </div>
            </div>
            
      <div class="row">
            <div class="form-group col-md-10">
                <label for="text"><strong></strong></label>
                <input type="text" name="text" id="text" value= "TOTAL PAGABLE / TM " class="form-control" readonly>
            </div>
            <div class="form-group col-md-2" >
                <label for="total_valores"><strong></strong></label>
                <input type="text" name="total_valores" id="total_valores" class="form-control"  value="{{ $liquidacion->total_valores}}" readonly>
            </div>
        </div>
    
            <P>
                    <h4><strong>DEDUCCIONES</strong></h4>
                    
                        <div class="row">                           
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="text" style="min-height: 17px;"></label>
                                        <input type="text" name="text" id="text" value="REFINACION DE COBRE (CU)" class="form-control" readonly>
                                    </div>
                                </div>
                             
                                <div class="col-md-8">
                                    <div class="row justify-content-end">
                                        <div class="form-group col-md-3">
                                            <label for="formula_fi_cu"><strong>FORMULA</strong></label>
                                            <div class="input-group"> 
                                            <input type="text" name="formula_fi_cu" id="formula_fi_cu" class="form-control"  value="{{ $liquidacion->formula_fi_cu}}" readonly >
                                            <span class="input-group-text">%</span>
                                        </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="refinamiento_cu"><strong>REF. COBRE</strong></label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" name="refinamiento_cu" id="refinamiento_cu" class="form-control" value="{{ old('refinamiento_cu', $liquidacion->cliente->requerimientos->refinamiento_cu)}}" oninput="deducciones()" readonly >
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="refinamiento_cu2" id="refinamiento_cu2" class="form-control" value="{{ old('refinamiento_cu2', $liquidacion->refinamiento_cu2)}}" oninput="deducciones()" readonly >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="fina_cu"><strong>$</strong></label>
                                            <input type="text" name="fina_cu" id="fina_cu" class="form-control"   value="{{ $liquidacion->fina_cu}}"readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                              
                           
           
                        <div class="row">
                         
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="text" style="min-height: 17px;"></label>
                                    <input type="text" name="text" id="text" value="REFINACION DE PLATA (AG)" class="form-control" readonly>
                                </div>
                            </div>
                        
                            <div class="col-md-8">
                                <div class="row justify-content-end">
                                    <div class="form-group col-md-3">
                                        <label for="formula_fi_ag"><strong>FORMULA</strong></label>
                                        <input type="text" name="formula_fi_ag" id="formula_fi_ag" class="form-control"  value="{{ $liquidacion->formula_fi_ag}}" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="refinamiento_ag"><strong>REF. PLATA</strong></label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="refinamiento_ag" id="refinamiento_ag" class="form-control" value="{{ old('refinamiento_ag', $liquidacion->cliente->requerimientos->refinamiento_ag)}}" oninput="deducciones()" readonly >
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="refinamiento_ag2" id="refinamiento_ag2" class="form-control" value="{{ old('refinamiento_ag2', $liquidacion->refinamiento_ag2 )}}" oninput="deducciones()" readonly >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="fina_ag"><strong>$</strong></label>
                                        <input type="text" name="fina_ag" id="fina_ag" class="form-control"  value="{{ $liquidacion->fina_ag}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="text" style="min-height: 17px;"></label>
                                <input type="text" name="text" id="text" value="REFINACION DE ORO (AU)" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="row justify-content-end">
                                <div class="form-group col-md-3">
                                    <label for="formula_fi_au"><strong>FORMULA</strong></label>
                                    <input type="text" name="formula_fi_au" id="formula_fi_au" class="form-control"   value="{{ $liquidacion->formula_fi_au}}"readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="refinamiento_au"><strong>REF. ORO</strong></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" name="refinamiento_au" id="refinamiento_au" class="form-control" value="{{ old('refinamiento_au', $liquidacion->cliente->requerimientos->refinamiento_au)}}" oninput="deducciones()" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="refinamiento_au2" id="refinamiento_au2" class="form-control" value="{{ old('refinamiento_au2', $liquidacion->refinamiento_au2)}}" oninput="deducciones()" readonly >
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="fina_au"><strong>$</strong></label>
                                    <input type="text" name="fina_au" id="fina_au" class="form-control"  value="{{ $liquidacion->fina_au}}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    
          
                        
                        <!-- Cuarta sección -->
                        <div class="row">
                           
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="text" style="min-height: 17px;"> </label>
                                    <input type="text" name="text" id="text" value="MAQUILA" class="form-control" readonly>
                                </div>
                            </div>
                     
                            <div class="col-md-8">
                                <div class="row justify-content-end">
                                    <div class="form-group col-md-3">
                                        <label for="maquila"><strong>$</strong></label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="maquila" id="maquila" class="form-control" value="{{ old('maquila', $liquidacion->cliente->requerimientos->maquila)}}" oninput="deducciones()" readonly >
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="maquila2" id="maquila2" class="form-control" value="{{ old('maquila2', $liquidacion->maquila2)}}" oninput="deducciones()" readonly >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                    </div>
                        
                    <div class="row">
                        <!-- Primer div a la izquierda -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="text" style="min-height: 17px;"></label>
                                <input type="text" name="text" id="text" value="ANALISIS/SARANDEO/DESESTIBAR" class="form-control" readonly>
                            </div>
                        </div>
                        <!-- Segunda sección con elementos alineados a la derecha -->
                        <div class="col-md-8">
                            <div class="row justify-content-end">

                                <div class="form-group col-md-3">
                                    <label for="analisis"><strong>VALOR</strong></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" name="analisis" id="analisis" class="form-control" value="{{ old('analisis', $liquidacion->cliente->requerimientos->analisis)}}" oninput="deducciones()" readonly >
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="analisis2" id="analisis2" class="form-control" value="{{ old('analisis2', $liquidacion->analisis2)}}" oninput="deducciones()" readonly >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="division"><strong>$</strong></label>
                                    <input type="text" name="division" id="division" class="form-control"   value="{{ $liquidacion->division}}"readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    <div class="row"> 
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="text" style="min-height: 17px;"></label>
                                <input type="text" name="text" id="text" value="ESTIBADORES" class="form-control" readonly>
                            </div>
                        </div>

                        
                        <div class="col-md-8">
                            <div class="row justify-content-end">
                                <div class="form-group col-md-3">
                                    <label for="estibadores"><strong>VALOR</strong></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" name="estibadores" id="estibadores" class="form-control" value="{{ old('estibadores', $liquidacion->cliente->requerimientos->estibadores)}}" oninput="deducciones()" readonly >
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="estibadores2" id="estibadores2" class="form-control" value="{{ old('estibadores2', $liquidacion->estibadores2)}}" oninput="deducciones()" readonly>
                                        </div>
                                    </div>                           
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="dolar"><strong>TIPO DE CAMBIO </strong></label>
                                    <input type="text" name="dolar" id="dolar" class="form-control" value="{{ $liquidacion->dolar}}" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="resultadoestibadores"><strong>$</strong></label>
                                    <input type="text" name="resultadoestibadores" id="resultadoestibadores" class="form-control"   value="{{ $liquidacion->resultadoestibadores}}"readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="text" style="min-height: 17px;"></label>
                                <input type="text" name="text" id="text" value="MOLIENDA" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row justify-content-end">
                                <div class="form-group col-md-3">
                                    <label for="molienda"><strong>VALOR</strong></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" name="molienda" id="molienda" class="form-control" value="{{ old('molienda', $liquidacion->cliente->requerimientos->molienda)}}" oninput="deducciones()" readonly >
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="molienda2" id="molienda2" class="form-control" value="{{ old('molienda2', $liquidacion->molienda2)}}" oninput="deducciones()" readonly >
                                        </div>
                                    </div>
  
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="dolar"><strong>TIPO DE CAMBIO </strong></label>
                                    <input type="text" name="dolar" id="dolar" class="form-control" value="{{ $liquidacion->dolar}}" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="resultadomolienda"><strong>$</strong></label>
                                    <input type="text" name="resultadomolienda" id="resultadomolienda" class="form-control"   value="{{ $liquidacion->resultadomolienda}}"readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Sexta sección -->
                    <div class="row">
                        <!-- Primer div a la izquierda -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="text" style="min-height: 17px;"></label>
                                <input type="text" name="text" id="text" value="TRANSPORTE" class="form-control" readonly>
                            </div>
                        </div>
                        <!-- Segundo div todo a la derecha -->
                        <div class="col-md-8">
                            <div class="row justify-content-end">
                                <div class="form-group col-md-3">
                                <label for="transporte"><strong>$</strong></label>
                                <input type="text" name="transporte" id="transporte" class="form-control" value="{{ $liquidacion->transporte}}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                        
                        <!-- Séptima sección -->
                        <div class="row">
                            <div class="form-group col-md-10">
                                <label for="text" style="min-height: 17px;"></label>
                                <input type="text" name="text" id="text" class="form-control" value="TOTAL DEDUCCIONES" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="total_deducciones"><strong>$</strong></label>
                                <input type="text" name="total_deducciones" id="total_deducciones" class="form-control"  value="{{ $liquidacion->total_deducciones}}"readonly>
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
                <input type="text" name="as" id="as" class="form-control" value="{{ $liquidacion->muestra->as}}" readonly>
            </div>
            <div class="form-group col-md-1">
                <label for="val_as" style="min-height: 17px;"></label>
                <input type="text" name="val_as" id="val_as" class="form-control" VALUE="0.100" readonly style="width: 70px;">
            </div>

            <div class="form-group col-md-2">
                <label for="penalidad_as">PEN. ARSENICO</label>
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="penalidad_as" id="penalidad_as" class="form-control" value="{{ old('penalidad_as', $liquidacion->cliente->requerimientos->penalidad_as)}}" oninput="penalidades()" readonly style="width: 70px;">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="penalidad_as2" id="penalidad_as2" class="form-control" value="{{ old('penalidad_as2', $liquidacion->penalidad_as2)}}" oninput="penalidades()" readonly style="width: 70px;">
                    </div>
                </div>
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
                <input type="text" name="total_as" id="total_as" class="form-control"  value="{{ $liquidacion->total_as}}" readonly>
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
                <input type="text" name="sb" id="sb" class="form-control" value="{{ $liquidacion->muestra->sb}}" readonly >
            </div>
            <div class="form-group col-md-1">
                <label for="val_sb" style="min-height: 17px;"></label>
                <input type="text" name="val_sb" id="val_sb" class="form-control" VALUE="0.100" readonly style="width: 70px;">
            </div>
            <div class="form-group col-md-2">
                <label for="penalidad_sb">PEN. ANTIMONIO</label>
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="penalidad_sb" id="penalidad_sb" class="form-control" value="{{ old('penalidad_sb', $liquidacion->cliente->requerimientos->penalidad_sb)}}" oninput="penalidades()"readonly style="width: 70px;">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="penalidad_sb2" id="penalidad_sb2" class="form-control" value="{{ old('penalidad_sb2', $liquidacion->penalidad_sb2)}}" oninput="penalidades()" readonly style="width: 70px;">
                    </div>
                </div>
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
                <input type="text" name="total_sb" id="total_sb" class="form-control" value="{{ $liquidacion->total_sb}}" readonly>
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
        <input type="text" name="bi" id="bi" class="form-control" value="{{ $liquidacion->muestra->bi}}" readonly>
    </div>
    <div class="form-group col-md-1">
        <label for="val_bi" style="min-height: 17px;"></label>
        <input type="text" name="val_bi" id="val_bi" class="form-control" VALUE="0.050" readonly style="width: 70px;">
    </div>
    <div class="form-group col-md-2">
        <label for="penalidad_bi">PEN. BISMUTO</label>
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="penalidad_bi" id="penalidad_bi" class="form-control" value="{{ old('penalidad_bi', $liquidacion->cliente->requerimientos->penalidad_bi)}}" oninput="penalidades()" readonly style="width: 70px;">
            </div>
            <div class="col-md-6">
                <input type="text" name="penalidad_bi2" id="penalidad_bi2" class="form-control" value="{{ old('penalidad_bi2', $liquidacion->penalidad_bi2 )}}" oninput="penalidades()" readonly style="width: 70px;">
            </div>
        </div>
    </div>
    <div class="form-group col-md-1">
        <label for="text" style="min-height: 17px;"></label>
        <input type="text" name="text" id="text" value="$/TMS" class="form-control" readonly style="width: 80px;">
    </div>
    <div class="form-group col-md-1">
        <label for="pre_bi" style="min-height: 17px;"></label>
        <input type="text" name="pre_bi" id="pre_bi" class="form-control" VALUE="0.010" readonly style="width: 70px;">
    </div>
    <div class="col-md-4">
        <div class="row justify-content-end">
            <div class="form-group col-md-6">
        <label for="total_bi"><strong>$</strong></label>
        <input type="text" name="total_bi" id="total_bi" class="form-control" value="{{ $liquidacion->total_bi}}"readonly>
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
                <input type="text" name="pb" id="pb" class="form-control" value="{{ $liquidacion->muestra->pb}}" readonly>
            </div>
            <div class="form-group col-md-1">
                <label for="val_pb" style="min-height: 17px;"></label>
                <input type="text" name="val_pb" id="val_pb" class="form-control" VALUE="8.000" readonly style="width: 70px;">
            </div>
            <div class="form-group col-md-2">
                <label for="penalidad_pb">PEN.  PB + ZN</label>
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="penalidad_pb" id="penalidad_pb" class="form-control" value="{{ old('penalidad_pb', $liquidacion->cliente->requerimientos->penalidad_pb)}}" oninput="penalidades()" readonly style="width: 70px;">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="penalidad_pb2" id="penalidad_pb2" class="form-control" value="{{ old('penalidad_pb2', $liquidacion->penalidad_pb2)}}" oninput="penalidades()" readonly style="width: 70px;">
                    </div>
                </div>
            </div>
            <div class="form-group col-md-1">
                <label for="text" style="min-height: 17px;"></label>
                <input type="text" name="text" id="text" value="$/TMS" class="form-control" readonly style="width: 80px;">
            </div>
            <div class="form-group col-md-1">
                <label for="pre_pb"></label>
                <input type="text" name="pre_pb" id="pre_pb" class="form-control" VALUE="1.000" readonly style="width: 70px;">
            </div>
            <div class="col-md-4">
                <div class="row justify-content-end">
                    <div class="form-group col-md-6">
                <label for="total_pb"><strong>$</strong></label>
                <input type="text" name="total_pb" id="total_pb" class="form-control" value="{{ $liquidacion->total_pb}}"readonly>
            </div>
        </div>
    </div>
</div>
            <div class="row">
              
</div>
            <div class="row">
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="text" style="min-height: 17px;"></label>
                        <input type="text" name="text" id="text" value="HG:" class="form-control" readonly>
                    </div>
                </div>
            <div class="form-group col-md-2">
                <label for="hg">LAB. MERCURIO</label>
                <input type="text" name="hg" id="hg" class="form-control" value="{{ $liquidacion->muestra->hg}}" readonly>
            </div>
            <div class="form-group col-md-1">
                <label for="val_hg" style="min-height: 17px;"></label>
                <input type="text" name="val_hg" id="val_hg" class="form-control" VALUE="30.000" readonly style="width: 70px;">
            </div>
            <div class="form-group col-md-2">
                <label for="penalidad_hg">PEN. MERCURIO</label>
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="penalidad_hg" id="penalidad_hg" class="form-control" value="{{ old('penalidad_hg', $liquidacion->cliente->requerimientos->penalidad_hg)}}" oninput="penalidades()" readonly style="width: 70px;">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="penalidad_hg2" id="penalidad_hg2" class="form-control" value="{{ old('penalidad_hg2', $liquidacion->penalidad_hg2 )}}" oninput="penalidades()" readonly style="width: 70px;">
                    </div>
                </div>
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
                <input type="text" name="total_hg" id="total_hg" class="form-control" value="{{ $liquidacion->total_hg}}"readonly>
            </div>
        </div>
    </div>
</div>
 <!--azufre obtiene valor de h2o-->
            <div class="row">
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="text" style="min-height: 17px;"></label>
                        <input type="text" name="text" id="text" value="H2O:" class="form-control" readonly>
                    </div>
                </div>
            <div class="form-group col-md-2">
                <label for="s">LAB. H2O</label>
                <input type="text" name="s" id="s" class="form-control" value="{{ $liquidacion->muestra->s}}" readonly>
            </div>
            <div class="form-group col-md-1">
                <label for="val_s" style="min-height: 17px;"></label>
                <input type="text" name="val_s" id="val_s" class="form-control" VALUE="0.000" readonly style="width: 70px;">
            </div>
            <div class="form-group col-md-2">
                <label for="penalidad_s">PEN. H2O</label>
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="penalidad_s" id="penalidad_s" class="form-control" value="{{ old('penalidad_s', $liquidacion->cliente->requerimientos->penalidad_s)}}" oninput="penalidades()" readonly style="width: 70px;">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="penalidad_s2" id="penalidad_s2" class="form-control" value="{{ old('penalidad_s2', $liquidacion->penalidad_s2)}}" oninput="penalidades()" readonly style="width: 70px;">
                    </div>
                </div>
            </div>
            
            <div class="form-group col-md-1">
                <label for="text" style="min-height: 17px;"></label>
                <input type="text" name="text" id="text" value="$/TMS" class="form-control" readonly style="width: 80px;">
            </div>
            <div class="form-group col-md-1">
                <label for="pre_s" style="min-height: 17px;"></label>
                <input type="text" name="pre_s" id="pre_s" class="form-control" VALUE="1.000" readonly style="width: 70px;">
            </div>
            <div class="col-md-4">
                <div class="row justify-content-end">
                    <div class="form-group col-md-6">
                <label for="total_s"><strong>$</strong></label>
                <input type="text" name="total_s" id="total_s" class="form-control" value="{{ $liquidacion->total_s}}" readonly>
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
                <input type="text" name="total_penalidades" id="total_penalidades" class="form-control"  value="{{ $liquidacion->total_penalidades}}"readonly>
            </div>
        </div>

        <div class="row justify-content-end">
            <div class="form-group col-md-2">
                <label for="text" style="min-height: 17px;"></label>
                <input type="text" name="text" id="text" class="form-control text-right" value="TOTAL US$/TM" readonly>
            </div>
            <div class="form-group col-md-2">
                <label for="total_us"><strong>$</strong></label>
                <input type="text" name="total_us" id="total_us" class="form-control text-right" value="{{ $liquidacion->total_us}}"readonly>
            </div>
        </div>

        <div class="row justify-content-end">
            <div class="form-group col-md-2">
                <label for="text" style="min-height: 17px;"></label>
                <input type="text" name="text" id="text" class="form-control text-right" value="VALOR POR LOTE US$" readonly>
            </div>
            <div class="form-group col-md-2">
                <label for="valorporlote" ><strong>$</strong></label>
                <input type="text" name="valorporlote" id="valorporlote" class="form-control text-right" value="{{ $liquidacion->valorporlote}}"readonly>
            </div>
        </div>

        <div class="row justify-content-end">
            <div class="form-group col-md-1">
                <label for="text" style="min-height: 17px;"></label>
                <input type="text" name="text" id="text" class="form-control text-right" value="IGV" readonly>
            </div>
            <div class="form-group col-md-3">
                <label for="igv"><strong>IGV</strong></label>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" name="igv" id="igv" class="form-control text-right" value="{{ old('igv', $liquidacion->cliente->requerimientos->igv)}}" oninput="sumafinal()" readonly>
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" name="igv2" id="igv2" class="form-control text-right" value="{{ old('igv2', $liquidacion->igv2)}}" oninput="sumafinal()" readonly>
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>
            </div>
        <div class="form-group col-md-2">
            <label for="valor_igv" ><strong>$</strong></label>
            <input type="text" name="valor_igv" id="valor_igv" class="form-control text-right" value="{{ $liquidacion->valor_igv}}" readonly>
        </div>
        </div>
        <div class="row justify-content-end">
            <div class="form-group col-md-2">
                <label for="text" style="min-height: 17px;"></label>
                <input type="text" name="text" id="text" class="form-control text-right" value="TOTAL DE LIQUIDACION %" readonly>
            </div>
            <div class="form-group col-md-2">
                <label for="total_porcentajeliqui"><strong>$</strong></label>
                <input type="text" name="total_porcentajeliqui" id="total_porcentajeliqui"  value="{{ $liquidacion->total_porcentajeliqui}}"class="form-control text-right" readonly>
            </div>
        </div>

        <div class="row justify-content-end">

                <div class="form-group col-md-2">
                    <label for="text" style="min-height: 17px;"></label>
                    <input type="text" name="text" id="text" class="form-control text-right" value="ADELANTOS" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="adelantos"><strong>$</strong></label>
                    <input type="text" name="adelantos" id="adelantos" class="form-control text-right"  value="{{ $liquidacion->adelantos}}"class="form-control text-right" readonly>
                </div>
                
        </div>

        <div class="row justify-content-end">
            <div class="form-group col-md-2">
                <label for="text" style="min-height: 17px;"></label>
                <input type="text" name="text" id="text" class="form-control text-right" value="SALDO" readonly>
            </div>
            <div class="form-group col-md-2">
                <label for="saldo"><strong>$</strong></label>
                <input type="text" name="saldo" id="saldo" class="form-control text-right"  value="{{ $liquidacion->saldo}}"readonly>
            </div>
        </div>
        <div class="row justify-content-end">
            <div class="form-group col-md-2">
                <label for="text" style="min-height: 17px;"></label>
                <input type="text" name="text" id="text" class="form-control text-right" value="DETRACCION 10%" readonly>
            </div>
            <div class="form-group col-md-2">
                <label for="detraccion"><strong>$</strong></label>
                <input type="text" name="detraccion" id="detraccion" class="form-control text-right" value="{{ $liquidacion->detraccion}}"readonly>
            </div>
        </div>
       


        <div class="row justify-content-end">
            <div class="form-group col-md-2">
                <label for="text" style="min-height: 17px;"></label>
                <input type="text" name="text" id="text" class="form-control text-right" value="TOTAL DE LIQUIDACION " readonly>
            </div>
            <div class="form-group col-md-2">
                <label for="total_liquidacion" ><strong>$</strong></label>
                <input type="text" name="total_liquidacion" id="total_liquidacion" class="form-control text-right" value="{{ $liquidacion->total_liquidacion}}"readonly>
            </div>
        </div>

        <div class="row justify-content-end">
            <div class="form-group col-md-4">
                <label for="text1"></label>
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
                <input type="text" name="pendientes" id="pendientes" class="form-control text-right" value="{{ $liquidacion->pendientes}}"readonly>
            </div>
        </div>
        <div class="row justify-content-end">
                <div class="form-group col-md-2">
                    <label for="text" style="min-height: 17px;"></label>
                    <input type="text" name="text" id="text" class="form-control text-right" value="PROCESO PLANTA" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="procesoplanta"><strong>$</strong></label>
                    <input type="text" name="procesoplanta" id="procesoplanta" class="form-control text-right" value="{{ $liquidacion->procesoplanta}}" readonly>
                </div>
        </div>
    <div class="row justify-content-end">
        <div class="form-group col-md-2">
            <label for="text" style="min-height: 17px;"></label>
            <input type="text" name="text" id="text" class="form-control text-right" value="ADELANTOS " readonly>
        </div>
        <div class="form-group col-md-2">
            <label for="adelantosextras"><strong>$</strong></label>
            <input type="text" name="adelantosextras" id="adelantosextras" class="form-control text-right" value="{{ $liquidacion->adelantosextras}}" readonly>
        </div>
    </div>

<div class="row justify-content-end">
    <div class="form-group col-md-2">
        <label for="text" style="min-height: 17px;"></label>
        <input type="text" name="text" id="text" class="form-control text-right" value="PRESTAMOS " readonly>
    </div>
    <div class="form-group col-md-2">
        <label for="prestamos"><strong>$</strong></label>
        <input type="text" name="prestamos" id="prestamos" class="form-control text-right" value="{{ $liquidacion->prestamos}}" readonly>
    </div>
</div>

<div class="row justify-content-end">
    <div class="form-group col-md-2">
        <label for="text" style="min-height: 17px;"></label>
        <input type="text" name="text" id="text" class="form-control text-right" value="OTROS DESCUENTOS " readonly>
    </div>
    <div class="form-group col-md-2">
        <label for="otros_descuentos"><strong>$</strong></label>
        <input type="text" name="otros_descuentos" id="otros_descuentos" class="form-control text-right" value="{{ $liquidacion->otros_descuentos}}" readonly>
    </div>
</div>

        <div class="row justify-content-end">
            <div class="form-group col-md-2">
                <label for="text" style="min-height: 17px;"></label>
                <input type="text" name="text" id="text" class="form-control text-right" value="TOTAL" readonly>
            </div>
            
            <div class="form-group col-md-2">
                <label for="total"><strong>$</strong></label>
                <input type="text" name="total" id="total" class="form-control text-right" value="{{ $liquidacion->total}}" readonly>
            </div>
        </div>

        <div class="row justify-content-end">

            <div class="form-group col-md-2">
                <label for="text" style="min-height: 17px;"></label>
                <input type="text" name="text" id="text" class="form-control text-right" value="OBSERVACION" readonly>
            </div>       

            <div class="form-group col-md-10">
                <label for="comentario">COMENTARIO</label>
                <textarea name="comentario" id="comentario" class="form-control" rows="3"readonly> {{ $liquidacion->comentario }}</textarea>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Función para formatear números con comas
            function formatNumber(number) {
                if (!isNaN(number) && number !== '') {
                    return parseFloat(number).toLocaleString('en-US', {
                        minimumFractionDigits: 3
                    });
                }
                return number;
            }

            // Función para limpiar comas
            function cleanNumber(number) {
                return number.replace(/,/g, '');
            }

            // Lista de nombres de campos numéricos
            const camposNumericos = [
                'peso', 'tms', 'tmns', 'ley_au', 'formula_au', 'precio_au', 'val_au',
                'ley_ag', 'formula_ag', 'precio_ag', 'val_ag', 'ley_cu', 'formula_cu',
                'precio_cu', 'val_cu', 'total_valores', 'total_deducciones', 'total_us',
                'valorporlote', 'valor_igv', 'total_porcentajeliqui', 'saldo', 'detraccion',
                'total_liquidacion', 'procesoplanta', 'adelantosextras', 'prestamos', 'total'
            ];

            // Aplicar data-numeric="true" y formatear los valores al cargar la página
            document.querySelectorAll('input').forEach(function (input) {
                if (camposNumericos.includes(input.name)) {
                    input.setAttribute('data-numeric', 'true');
                    input.value = formatNumber(cleanNumber(input.value));

                    // Limpiar comas al enfocar para permitir edición
                    input.addEventListener('focus', function () {
                        this.value = cleanNumber(this.value);
                    });

                    // Formatear con comas al salir del campo
                    input.addEventListener('blur', function () {
                        this.value = formatNumber(this.value);
                    });
                }
            });

            // Limpiar comas antes de enviar el formulario
            document.querySelectorAll('form').forEach(function (form) {
                form.addEventListener('submit', function () {
                    form.querySelectorAll('input[data-numeric="true"]').forEach(function (input) {
                        input.value = cleanNumber(input.value);
                    });
                });
            });
        });
    </script>


@endsection