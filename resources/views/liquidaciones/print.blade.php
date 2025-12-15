<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIQUIDACION IMPRIMIR</title>
 <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        position: relative;
    }

    /* Marca de agua */
    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('{{ asset('images/innovalogo.png') }}') no-repeat center center;
        background-size: 60%;
        opacity: 0.08; /* Transparencia suave */
        z-index: -1; /* Detrás de todo */
    }

    .container {
        width: 100%;
        max-width: 800px;
        margin: auto;
        padding: 20px;
        position: relative;
        z-index: 1; /* Asegura que el contenido quede encima */
    }

    .header, .footer {
        text-align: center;
        margin-bottom: 10px;
    }

    .header h1 {
        margin: 0;
        font-size: 18px;
    }

    .header p {
        margin: 5px 0;
        font-size: 12px;
    }

    .content {
        display: flex;
        flex-direction: column;
        gap: 3px;
        margin-bottom: 20px;
    }

    .section {
        border: 1px solid #be748b;
        border-radius: 4px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        padding: 5px;
        box-sizing: border-box;
        font-size: 12px;
        position: relative;
    }

    .section h6 {
        margin-top: 5px;
        margin-bottom: 5px;
        text-align: center;
        background-color: #be748b;
        padding: 3px;
        font-size: 14px;
        border-radius: 4px;
    }

    .section p {
        margin: 3px 0;
        font-size: 12px;
    }

    .section img {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        max-width: 150px;
        height: auto;
    }

    .centered-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
        margin-bottom: 20px;
    }

    .data-box-full {
        border: 1px solid #be748b;
        border-radius: 4px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        padding: 5px;
        min-width: 130px;
        box-sizing: border-box;
        flex: 1 1 130px;
        font-size: 11px;
        margin: 0;
    }

    .data-box-full h6 {
        margin-top: 5px;
        margin-bottom: 5px;
        text-align: center;
        background-color: #be748b;
        padding: 3px;
        font-size: 13px;
        border-radius: 4px;
    }

    .data-box-full p {
        margin: 2px 0;
        font-size: 11px;
    }

    .combined-table {
        width: 100%;
        border: 1px solid #be748b;
        border-radius: 4px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        padding: 0;
        overflow-x: auto;
        margin-bottom: 5px;
        font-size: 10px;
    }

    .combined-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .combined-table th, .combined-table td {
        padding: 3px;
        border: 1px solid #be748b;
        text-align: center;
        font-size: 10px;
    }

    .combined-table th {
        background-color: #be748b;
    }

    .combined-table td.highlighted-text {
        font-weight: bold;
        background-color: #f9f9f9;
    }

    .footer button {
        padding: 8px 16px;
        font-size: 12px;
        border: none;
        border-radius: 4px;
        background-color: #be748b;
        color: white;
        cursor: pointer;
    }

    .footer button:hover {
        background-color: #be748b;
    }

    @media print {
        #toggle-datos-adicionales,
        label[for="toggle-datos-adicionales"],
        input[type="checkbox"],
        .no-print {
            display: none !important;
        }
        body {
            margin: 0;
            padding: 0;
            font-size: 10px;
            overflow-x: hidden;
        }

        body::before {
            background: url('{{ asset('images/innovalogo.png') }}') no-repeat center center;
            background-size: 60%;
            opacity: 0.05; /* Más tenue en impresión */
        }

        .container {
            width: 100%;
            padding: 0;
            box-shadow: none;
            box-sizing: border-box;
        }

        .header, .footer {
            margin-bottom: 5px;
        }

        .footer button {
            display: none;
        }
        .wrap { white-space: pre-wrap; word-break: break-word; }
        .combined-table {
            width: 100%;
            max-width: 100%;
            font-size: 8px;
            box-sizing: border-box;
            overflow-x: hidden;
        }

        .combined-table th, .combined-table td {
            padding: 2px;
            word-break: break-word;
        }

        .section, .data-box-full {
            font-size: 10px;
            padding: 3px;
            box-sizing: border-box;
        }

        .section p, .data-box-full p {
            margin: 2px 0;
        }
    }
</style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>VALORIZACION COMPRA VENTA - {{ $liquidacion->estado }}  </h1>
            <p>N° {{ $liquidacion->id }} - Fecha y hora: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s')  }}</p>
        </div>

        <div class="content">
            <!-- Primer contenedor (más grande) -->
            <div class="section">
                <div class="data-box">
                    <div class="left">
                        <h6>DATOS GENERALES</h6>
                        <p><strong>RUC:</strong> {{ $liquidacion->cliente->ruc_empresa }}</p>
                        <p><strong>PRODUCTOR:</strong> {{ $liquidacion->cliente->razon_social }}</p>
                        <p><strong>CLIENTE:</strong> {{ $liquidacion->cliente->datos_cliente }}</p>
                     <!--    <p><strong>DIRECCIÓN:</strong> {{ $liquidacion->cliente->direccion }}</p>
                        <p><strong>TELÉFONO:</strong> {{ $liquidacion->cliente->telefono }}</p>-->
                        <p><strong>LOTE:</strong> {{ $liquidacion->lote }}</p>
                        <p></p>
                        <p><strong>FECHA INGRESO LOTE:</strong> {{ $liquidacion->fechai }} <strong> FECHA CIERRE:</strong> {{ $liquidacion->updated_at }} <strong>CERRADO POR: </strong> 
                        <td>
                            {{ $liquidacion->lastEditor ? explode(' ', $liquidacion->lastEditor->name)[0] : 'N/A' }}
                        </td></p>
                        <p><strong>N° Ticket:</strong> {{ $liquidacion->NroSalida }} <strong> Guía de Transporte:</strong> {{ $liquidacion->ingreso->guia_transporte ?? '' }} <strong>Guía de Remisión:</strong> {{ $liquidacion->ingreso->guia_remision ?? '' }}</p>
                     
                    </div>
                </div>
                <!-- Imagen en el lado derecho -->
               @if($liquidacion->igv2 > 0)
                    <img src="{{ asset('images/inn.jpg') }}" alt="Imagen" />
                @endif
            </div>

            <!-- Contenedor centrado -->
            <div class="centered-container">
                <div class="data-box-full">
                    <h6>PESO</h6>
                    <p><strong>TMH:</strong> {{ $liquidacion->peso }}</p>
                    <p><strong>HUMEDAD:</strong> {{ $liquidacion->muestra->humedad }}%</p>
                    <p><strong>TMS:</strong> {{ $liquidacion->tms }}</p>
                    <p><strong>MERMA:</strong> {{ $liquidacion->merma2 }}</p>
                    <p><strong>TMNS:</strong> {{ $liquidacion->tmns }}</p>
                </div>
                <div class="data-box-full">
                    <h6>ENSAYO</h6>
                    @if($liquidacion->val_cu > 0)
                    <p><strong>CU %:</strong> {{ $liquidacion->muestra->cu . '%' }}</p>
                    @endif

                    @if($liquidacion->val_ag > 0)
                        <p><strong>AG Oz/TM:</strong> {{ $liquidacion->muestra->ag }}</p>
                    @endif

                    @if($liquidacion->val_au > 0)
                        <p><strong>AU Oz/TM:</strong> {{ $liquidacion->muestra->au }}</p>
                    @endif

                </div>
                <div class="data-box-full">
                    <h6>COTIZACIÓN</h6>
                    @if($liquidacion->val_cu > 0)
                        <p><strong>Cu $/ lb:</strong> {{ $liquidacion->cotizacion_cu }}</p>
                    @endif

                    @if($liquidacion->val_ag > 0)
                        <p><strong>Ag $/ oz:</strong> {{ $liquidacion->cotizacion_ag }}</p>
                    @endif

                    @if($liquidacion->val_au > 0)
                        <p><strong>Au $/ oz:</strong> {{ $liquidacion->cotizacion_au }}</p>
                    @endif
                    
                </div>
            </div>

            <!-- Contenedor combinado -->
            <!-- Contenedor en forma de tabla -->
            <div class="combined-table">
                <table>
                    <thead>
                        <tr>
                            <th colspan="7">PAGABLES</th>
                        </tr>
                        <tr>
                            <th>TIPO</th>
                            <th>LEYES</th>
                            <th>% PAGABLE</th>
                            <th>DEDUCCION</th>
                            <th></th>
                            <th>PRECIO</th>
                            <th>US$/TM</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="highlighted-text">Cu % :</td>
                            @if($liquidacion->val_cu > 0)
                                <td>{{ $liquidacion->ley_cu . '%' }}</td>
                            @else
                                <td></td>
                            @endif
                            <td>{{ $liquidacion->pagable_cu2 > 0 ? $liquidacion->pagable_cu2 : '' }}</td>
                            <td>{{ $liquidacion->deduccion_cu2 > 0 ? $liquidacion->deduccion_cu2 : '' }}</td>
                            <td>{{ $liquidacion->formula_cu > 0 ? $liquidacion->formula_cu . '%' : '' }}</td>
                            @if($liquidacion->val_cu > 0)
                                <td>{{   number_format(floor($liquidacion->precio_cu * 100) / 100, 2)  }}</td>
                            @else
                                <td></td>
                            @endif
                            <td><strong>$</strong>{{ $liquidacion->val_cu > 0 ? $liquidacion->val_cu : '' }}</td>
                        </tr>
                        <tr>
                            <td class="highlighted-text">Ag Oz/TC</td>
                            @if($liquidacion->val_ag > 0)
                            <td>{{ $liquidacion->ley_ag }}</td>
                            @else
                                <td></td>
                            @endif
                            <td>{{ $liquidacion->pagable_ag2 > 0 ? $liquidacion->pagable_ag2 . '%' : '' }}</td>
                            <td>{{ $liquidacion->deduccion_ag2 > 0 ? $liquidacion->deduccion_ag2 . '%' : '' }}</td>
                            <td>{{ $liquidacion->formula_ag > 0 ? $liquidacion->formula_ag : '' }}</td>
                            @if($liquidacion->val_ag > 0)
                                <td>{{ number_format(floor($liquidacion->precio_ag * 100) / 100, 2) }}</td>
                            @else
                                <td></td>
                            @endif
                            <td><strong>$</strong>{{ $liquidacion->val_ag > 0 ? $liquidacion->val_ag : '' }}</td>
                        </tr>
                        <tr>
                            <td class="highlighted-text">Au Oz/TC</td>
                            @if($liquidacion->val_au > 0)
                                    <td>{{ $liquidacion->ley_au }}</td>
                                @else
                                    <td></td>
                                @endif
                            <td>{{ $liquidacion->pagable_au2 > 0 ? $liquidacion->pagable_au2 . '%' : '' }}</td>
                            <td>{{ $liquidacion->deduccion_au2 > 0 ? $liquidacion->deduccion_au2 . '%' : '' }}</td>
                            <td>{{ $liquidacion->formula_au > 0 ? $liquidacion->formula_au : '' }}</td>
                            @if($liquidacion->val_au > 0)
                            <td>{{  number_format(floor($liquidacion->precio_au * 100) / 100, 2) }}</td>
                            @else
                                <td></td>
                            @endif
                            
                            <td><strong>$</strong>{{ $liquidacion->val_au > 0 ? $liquidacion->val_au : '' }}</td>
                        </tr>
                        <tr>


                            <td colspan="6" class="highlighted-text"><strong>TOTAL PAGABLE/TM:</strong></td>
                            <td class="highlighted-text"><strong>$</strong>{{ $liquidacion->total_valores }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Sección combinada para deducciones en formato de tabla -->
            <div class="combined-table">
                <table>
                    <thead>
                        <tr>
                            <th colspan="8">DEDUCCIONES</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>PRECIO</th>
                            <th>US$/TM</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="highlighted-text">REFINACION DE CU</td>
                            <td>{{ $liquidacion->formula_fi_cu > 0 ? $liquidacion->formula_fi_cu . '%' : '' }}</td>
                            <td>{{ $liquidacion->refinamiento_cu2 > 0 ? $liquidacion->refinamiento_cu2 : '' }}</td>
                            <td><strong>$</strong>{{ $liquidacion->fina_cu > 0 ? $liquidacion->fina_cu : '' }}</td>
                            
                        </tr>
                        <tr>
                            <td class="highlighted-text">REFINACION DE AG</td>
                            <td>{{ $liquidacion->formula_fi_ag > 0 ? $liquidacion->formula_fi_ag : '' }}</td>
                            <td>{{ $liquidacion->refinamiento_ag2 > 0 ? $liquidacion->refinamiento_ag2 : '' }}</td>
                            <td><strong>$</strong>{{ $liquidacion->fina_ag > 0 ? $liquidacion->fina_ag : '' }}</td>
                            
                        </tr>
                        <tr>
                            <td class="highlighted-text">REFINACION DE AU</td>
                            <td>{{ $liquidacion->formula_fi_au > 0 ? $liquidacion->formula_fi_au : '' }}</td>
                            <td>{{ $liquidacion->refinamiento_au2 > 0 ? $liquidacion->refinamiento_au2 : '' }}</td>
                            <td><strong>$</strong>{{ $liquidacion->fina_au > 0 ? $liquidacion->fina_au : '' }}</td>
                        </tr>
                        <tr>
                            <td class="highlighted-text">MAQUILA</td>
                            <td></td>
                            <td>{{ $liquidacion->maquila2 > 0 ? $liquidacion->maquila2 : '' }}</td>
                            <td><strong>$</strong>{{ $liquidacion->maquila2 > 0 ? $liquidacion->maquila2 : '' }}</td>
                        </tr>
                        <tr>
                            <td class="highlighted-text">ANALISIS</td>
                            <td></td>
                            <td>{{ $liquidacion->division > 0 ? $liquidacion->division : '' }}</td>
                            <td><strong>$</strong>{{ $liquidacion->division > 0 ? $liquidacion->division : '' }}</td>
                            
                        </tr>
                        <tr>
                            <td class="highlighted-text" contenteditable="true">ESTIBADORES</td>
                            <td></td>
                            <td>{{ $liquidacion->resultadoestibadores > 0 ? $liquidacion->resultadoestibadores : '' }}</td>
                            <td><strong>$</strong>{{ $liquidacion->resultadoestibadores > 0 ? $liquidacion->resultadoestibadores : ''  }}</td>
                        </tr>
                        <tr>
                            <td class="highlighted-text" contenteditable="true">MOLIENDA</td>
                            <td></td>
                            <td>{{ $liquidacion->resultadomolienda > 0 ? $liquidacion->resultadomolienda : '' }}</td>
                            <td><strong>$</strong>{{ $liquidacion->resultadomolienda > 0 ? $liquidacion->resultadomolienda : '' }}</td>
                            
                        </tr>
                        <tr>
                            <td class="highlighted-text">TRANSPORTE</td>
                            <td></td>
                            <td>{{ $liquidacion->transporte > 0 ? $liquidacion->transporte : '' }}</td>
                            <td><strong>$</strong>{{ $liquidacion->transporte > 0 ? $liquidacion->transporte : '' }}</td>
                            
                        </tr>
                        <tr>
                            <td colspan="3" class="highlighted-text"><strong>TOTAL DEDUCCIONES:</strong></td>
                            <td class="highlighted-text"><strong>$</strong>{{ $liquidacion->total_deducciones }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Sección combinada para penalidades en formato de tabla -->
            <div class="combined-table">
                <table>
                    <thead>
                        <tr>
                            <th colspan="8">PENALIDADES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="highlighted-text">As:</td>
                            <td>( {{ $liquidacion->muestra->as }}</td>
                            <td contenteditable="true">-0.100</td>
                            <td>% ) x</td>
                            <td>{{ $liquidacion->penalidad_as2 }}</td>
                            <td>$ / TMS</td>
                            <td contenteditable="true">0.100</td>
                            <td>{{ $liquidacion->total_as }}</td>
                        </tr>
                        <tr>
                            <td class="highlighted-text">Sb:</td>
                            <td>( {{ $liquidacion->muestra->sb }}</td>
                            <td contenteditable="true">-0.100</td>
                            <td>% ) x</td>
                            <td>{{ $liquidacion->penalidad_sb2 }}</td>
                            <td>$ / TMS</td>
                            <td contenteditable="true">0.100</td>
                            <td>{{ $liquidacion->total_sb > 0 ? $liquidacion->total_sb : '' }}</td>

                        </tr>
                        <tr>
                            <td class="highlighted-text">Bi:</td>
                            <td>( {{ $liquidacion->muestra->bi }}</td>
                            <td contenteditable="true">-0.050</td>
                            <td>% ) x</td>
                            <td>{{ $liquidacion->penalidad_bi2 }}</td>
                            <td>$ / TMS</td>
                            <td contenteditable="true">0.010</td>
                            <td>{{ $liquidacion->total_bi > 0  ? $liquidacion->total_bi : '' }}</td>
                        </tr>
                        <tr>
                            <td class="highlighted-text">Pb+Zn:</td>
                            <td>( {{ $liquidacion->muestra->pb }}</td>
                            <td contenteditable="true">-8.000</td>
                            <td>% ) x</td>
                            <td>{{ $liquidacion->penalidad_pb2 }}</td>
                            <td>$ / TMS</td>
                            <td contenteditable="true">1.000</td>
                            <td>{{ $liquidacion->total_pb > 0 ? $liquidacion->total_pb : '' }}</td>
                        </tr>
                        <tr>
                            <td class="highlighted-text">Hg:</td>
                            <td>( {{ $liquidacion->muestra->hg }}</td>
                            <td contenteditable="true">-30.000</td>
                            <td>% ) x</td>
                            <td>{{ $liquidacion->penalidad_hg2 }}</td>
                            <td>$ / TMS</td>
                            <td contenteditable="true">20.000</td>
                            <td>{{ $liquidacion->total_hg  > 0 ? $liquidacion->total_hg : ''}}</td>
                        </tr>
                        <tr>
                            <td class="highlighted-text">H2O:</td>
                            <td>( {{ $liquidacion->muestra->s }}</td>
                            <td contenteditable="true"></td>
                            <td>% ) x</td>
                            <td>{{ $liquidacion->penalidad_s2 }}</td>
                            <td>$ / TMS</td>
                            <td contenteditable="true">1.000</td>
                            <td>{{ $liquidacion->total_s > 0 ? $liquidacion->total_s : '' }}</td>
                        </tr>
                        <tr>
                            <td colspan="7" class="highlighted-text"><strong>TOTAL PENALIDADES :</strong></td>
                            <td class="highlighted-text"><strong>$</strong>{{ $liquidacion->total_penalidades }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
             <!-- Contenedor en forma de tabla -->
             <div class="combined-table">
                <table>
                    <thead>

                    </thead>
                    <tbody>
                        <tr>
                            <td class="highlighted-text">TOTAL US$/TM :</td>
                            <td>$ {{ $liquidacion->total_us }}</td>
                        </tr>
                        <tr>
                            <td class="highlighted-text">VALOR POR LOTE US$</td>
                            <td>$ {{ $liquidacion->valorporlote }}</td>
                           
                        </tr>
                        @if($liquidacion->igv2 > 0)
                        <tr>
                            <td class="highlighted-text">IGV {{ $liquidacion->igv2}} %</td>
                            <td>$ {{ $liquidacion->valor_igv }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="highlighted-text">TOTAL DE LIQUIDACION %</td>
                            <td>$ {{ $liquidacion->total_porcentajeliqui }}</td>
                        </tr>
                        <tr>
                            <td class="highlighted-text">ADELANTO:
                              @if ($liquidacion->facturas && $liquidacion->facturas->count())
                            <small>
                                {{-- Mostrar las referencias separadas por coma --}}
                                {{ $liquidacion->facturas->pluck('factura_numero')->implode(', ') }}
                            </small>
                            </td>
                        @endif
                            <td>$ {{ $liquidacion->adelantos }}</td>
                        </tr>
                        
                        <tr>
                            <td class="highlighted-text">SALDO</td>
                            <td>$ {{ $liquidacion->saldo }}</td>
                        </tr>
                        <tr>
                            <td class="highlighted-text">DETRACCION</td>
                            <td>$ {{ $liquidacion->detraccion }}</td>
                        </tr>
                       
                        <tr>
                            <td colspan="1" class="highlighted-text"><strong>TOTAL DE LIQUIDACION:</strong></td>
                            <td class="highlighted-text"><strong>$</strong>{{ $liquidacion->total_liquidacion }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
                        <div class="no-print" style="margin-bottom: 10px;">
                        <label for="toggle-saldo-negativo">
                            <input type="checkbox" id="toggle-saldo-negativo">
                            Mostrar SALDO NEGATIVO
                        </label>
                        </div>

                        <div class="combined-table" id="seccion-saldo-negativo" style="display:none;">
                        <table>
                            <thead><tr><th colspan="2">PENDIENTES</th></tr></thead>
                            <tbody>
                            <tr>
                                <td class="highlighted-text">SALDO NEGATIVO</td>
                                <td class="text-right">$ - {{ $liquidacion->pendientes }}</td>
                            </tr>
                            <tr id="fila-total-pendientes" style="display: none;">
                                <td class="highlighted-text"><strong>TOTAL:</strong></td>
                                <td class="highlighted-text"><strong>$</strong>{{ $liquidacion->total }}</td>
                            </tr>
                            </tbody>
                        </table>
                        </div>

                        <div class="no-print" style="margin-bottom: 10px;">
                        <label for="toggle-datos-adicionales">
                            <input type="checkbox" id="toggle-datos-adicionales">
                            Mostrar DATOS ADICIONALES
                        </label>
                        </div>

                        <div class="combined-table" id="seccion-datos-adicionales" style="display:none;">
                        <table>
                            <thead><tr><th colspan="2">INFORMACION ADICIONAL</th></tr></thead>
                            <tbody>
                            <tr><td class="highlighted-text">PROCESO DE PLANTA</td><td class="text-right">$ {{ $liquidacion->procesoplanta }}</td></tr>
                            <tr><td class="highlighted-text">ADELANTOS</td><td class="text-right">$ {{ $liquidacion->adelantosextras }}</td></tr>
                            <tr><td class="highlighted-text">PRESTAMOS</td><td>$ {{ $liquidacion->prestamos }}</td></tr>
                            <tr><td class="highlighted-text">OTROS DESCUENTOS</td><td>$ {{ $liquidacion->otros_descuentos }}</td></tr>
                            <tr id="fila-total-adicionales" style="display: none;">
                                <td class="highlighted-text"><strong>TOTAL:</strong></td>
                                <td class="highlighted-text"><strong>$</strong>{{ $liquidacion->total }}</td>
                            </tr>
                            </tbody>
                        </table>
                        </div>

                        {{-- TOTAL GLOBAL (solo si ambos están activos) --}}
                        <div class="combined-table" id="seccion-total-global" style="display: none;">
                        <table><tbody>
                            <tr>
                            <td class="highlighted-text"><strong>TOTAL:</strong></td>
                            <td class="highlighted-text"><strong>$</strong>{{ $liquidacion->total }}</td>
                            </tr>
                        </tbody></table>
                        </div>

                        <div class="footer">
                            <button onclick="window.print()">Imprimir</button>
                        </div>
                        <script>
                        document.addEventListener('DOMContentLoaded', function () {
                        // Valor numérico seguro desde Blade (sin comas ni formato local)
                        const pendientesVal = Number(@json((float) $liquidacion->pendientes));

                        const chkPend   = document.getElementById('toggle-saldo-negativo');
                        const chkAdic   = document.getElementById('toggle-datos-adicionales');

                        const secPend   = document.getElementById('seccion-saldo-negativo');
                        const secAdic   = document.getElementById('seccion-datos-adicionales');

                        const filaTotPend = document.getElementById('fila-total-pendientes');
                        const filaTotAdic = document.getElementById('fila-total-adicionales');
                        const secTotGlobal = document.getElementById('seccion-total-global');

                        function updateSections() {
                            // Mostrar/ocultar secciones
                            secPend.style.display = chkPend.checked ? 'block' : 'none';
                            secAdic.style.display = chkAdic.checked ? 'block' : 'none';

                            const showPend = chkPend.checked;
                            const showAdic = chkAdic.checked;

                            // Lógica de totales
                            if (showPend && showAdic) {
                            filaTotPend.style.display = 'none';
                            filaTotAdic.style.display = 'none';
                            secTotGlobal.style.display = 'block';
                            } else if (showPend) {
                            filaTotPend.style.display = 'table-row';
                            filaTotAdic.style.display = 'none';
                            secTotGlobal.style.display = 'none';
                            } else if (showAdic) {
                            filaTotPend.style.display = 'none';
                            filaTotAdic.style.display = 'table-row';
                            secTotGlobal.style.display = 'none';
                            } else {
                            filaTotPend.style.display = 'none';
                            filaTotAdic.style.display = 'none';
                            secTotGlobal.style.display = 'none';
                            }
                        }

                        // Estado inicial: todo desmarcado...
                        chkPend.checked = false;
                        chkAdic.checked = false;

                        // ... excepto si pendientes > 0.01 → activar automáticamente "Saldo Negativo"
                        if (pendientesVal > 0.01) {
                            chkPend.checked = true;
                        }

                        // Pintar según estado inicial
                        updateSections();

                        // Eventos
                        chkPend.addEventListener('change', updateSections);
                        chkAdic.addEventListener('change', updateSections);
                        });
                        </script>