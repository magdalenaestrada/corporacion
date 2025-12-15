@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <h6 class="mt-2">
                                    {{ __('VER CONDICIONES') }}
                                </h6>
                            </div>
                            <div class="col-md-6 text-end">
                                <a class="btn btn-danger btn-sm" href="{{ route('requerimientos.index') }}">
                                    {{ __('VOLVER') }}
                                </a>
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
                                    <span class="badge text-bg-secondary">{{ $requerimiento->id }}</span>
                                    <strong>
                                        {{ __('y esta operación fue registrada el ') }}
                                    </strong>
                                        {{ $requerimiento->created_at->format('d-m-Y') }}
                                    <strong>
                                        {{ __('a la(s) ') }}
                                    </strong>
                                        {{ $requerimiento->created_at->format('H:i:s') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @if ($requerimiento->updated_at != $requerimiento->created_at)
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>
                                            {{ __('Estás viendo el ID') }}
                                        </strong>
                                        <span class="badge text-bg-secondary">
                                            {{ $requerimiento->id }}
                                        </span>
                                        <strong>
                                            {{ __('y esta operación fue actualizada el ') }}
                                        </strong>
                                            {{ $requerimiento->updated_at->format('d-m-Y') }}
                                        <strong>
                                            {{ __('a la(s) ') }}
                                        </strong>
                                            {{ $requerimiento->updated_at->format('H:i:s') }}
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

                            <div class="form-group col-md-12 g-3">
                                <label for="datos_cliente">
                                    {{ __('DATOS DEL CLIENTE') }}
                                </label>
                                @if ($requerimiento->cliente)
                                    <input class="form-control" value="{{ $requerimiento->cliente->datos_cliente }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>
                            
                            <div class="form-group col-md-12 g-3">
                                <label for="razon_social">
                                    {{ __('RAZON SOCIAL') }}
                                </label>
                                @if ($requerimiento->cliente)
                                    <input class="form-control" value="{{ $requerimiento->cliente->razon_social }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>
                            <p>
                                <div class="form-group col-md-2 g-3">
                                    <label for="igv">
                                        {{ __('IGV') }}
                                    </label>
                                    @if ($requerimiento->igv)
                                        <input class="form-control" value="{{ $requerimiento->igv }}" disabled>
                                    @else
                                        <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                    @endif
                                </div>
                                <div class="form-group col-md-2 g-3">
                                    <label for="merma">
                                        {{ __('MERMA') }}
                                    </label>
                                    @if ($requerimiento->merma)
                                        <input class="form-control" value="{{ $requerimiento->merma }}" disabled>
                                    @else
                                        <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                    @endif
                                </div>
                            </div>
                                <p>
                                <div class="row">
                                    <div class="col-md-3">
                                        <h6><strong>PAGABLES</strong></h6>
                                        <div class="form-group">
                                            <label for="pagable_au">{{ __('PAGABLE ORO') }}</label>
                                            @if ($requerimiento->pagable_au)
                                                <input class="form-control" value="{{ $requerimiento->pagable_au }}" disabled>
                                            @else
                                                <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="pagable_ag">{{ __('PAGABLE PLATA') }}</label>
                                            @if ($requerimiento->pagable_ag)
                                                <input class="form-control" value="{{ $requerimiento->pagable_ag }}" disabled>
                                            @else
                                                <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="pagable_cu">{{ __('PAGABLE COBRE') }}</label>
                                            @if ($requerimiento->pagable_cu)
                                                <input class="form-control" value="{{ $requerimiento->pagable_cu }}" disabled>
                                            @else
                                                <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                            @endif
                                        </div>
                                    </div>
                                
                                    <div class="col-md-3">
                                        <h6><strong>PROTECCION</strong></h6>
                                        <div class="form-group">
                                            <label for="proteccion_au">{{ __('PROTECCION ORO') }}</label>
                                            @if ($requerimiento->proteccion_au)
                                                <input class="form-control" value="{{ $requerimiento->proteccion_au }}" disabled>
                                            @else
                                                <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="proteccion_ag">{{ __('PROTECCION PLATA') }}</label>
                                            @if ($requerimiento->proteccion_ag)
                                                <input class="form-control" value="{{ $requerimiento->proteccion_ag }}" disabled>
                                            @else
                                                <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="proteccion_cu">{{ __('PROTECCION COBRE') }}</label>
                                            @if ($requerimiento->proteccion_cu)
                                                <input class="form-control" value="{{ $requerimiento->proteccion_cu }}" disabled>
                                            @else
                                                <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                            @endif
                                        </div>
                                    </div>
                                
                                    <div class="col-md-3">
                                        <h6><strong>DEDUCCION </strong></h6>
                                        <div class="form-group">
                                            <label for="deduccion_au">{{ __('DEDUCCION ORO') }}</label>
                                            @if ($requerimiento->deduccion_au)
                                                <input class="form-control" value="{{ $requerimiento->deduccion_au }}" disabled>
                                            @else
                                                <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="deduccion_ag">{{ __('DEDUCCION PLATA') }}</label>
                                            @if ($requerimiento->deduccion_ag)
                                                <input class="form-control" value="{{ $requerimiento->deduccion_ag }}" disabled>
                                            @else
                                                <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="deduccion_cu">{{ __('DEDUCCION COBRE') }}</label>
                                            @if ($requerimiento->deduccion_cu)
                                                <input class="form-control" value="{{ $requerimiento->deduccion_cu }}" disabled>
                                            @else
                                                <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                            @endif
                                        </div>
                                    </div>
                                
                                    <div class="col-md-3">
                                        <h6><strong>REFINAMIENTO</strong></h6>
                                        <div class="form-group">
                                            <label for="refinamiento_au">{{ __('REFINAMIENTO ORO') }}</label>
                                            @if ($requerimiento->refinamiento_au)
                                                <input class="form-control" value="{{ $requerimiento->refinamiento_au }}" disabled>
                                            @else
                                                <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="refinamiento_ag">{{ __('REFINAMIENTO PLATA') }}</label>
                                            @if ($requerimiento->refinamiento_ag)
                                                <input class="form-control" value="{{ $requerimiento->refinamiento_ag }}" disabled>
                                            @else
                                                <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="refinamiento_cu">{{ __('REFINAMIENTO COBRE') }}</label>
                                            @if ($requerimiento->refinamiento_cu)
                                                <input class="form-control" value="{{ $requerimiento->refinamiento_cu }}" disabled>
                                            @else
                                                <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                            <p>
                                <div class="row">

                                <h6><strong>OTROS </strong></h6> 
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="maquila">{{ __('MAQUILA') }}</label>
                                            @if ($requerimiento->maquila)
                                                <input class="form-control" value="{{ $requerimiento->maquila }}" disabled>
                                            @else
                                                <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="analisis">{{ __('ANALISIS') }}</label>
                                            @if ($requerimiento->analisis)
                                                <input class="form-control" value="{{ $requerimiento->analisis }}" disabled>
                                            @else
                                                <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="estibadores">{{ __('ESTIBADORES') }}</label>
                                            @if ($requerimiento->estibadores)
                                                <input class="form-control" value="{{ $requerimiento->estibadores }}" disabled>
                                            @else
                                                <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="molienda">{{ __('MOLIENDA') }}</label>
                                            @if ($requerimiento->molienda)
                                                <input class="form-control" value="{{ $requerimiento->molienda }}" disabled>
                                            @else
                                                <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                            <p>
                                <div class="row">
                                <h6><strong>PENALIDADES </strong></h6> 
                                <div class="form-group col-md-2 g-3">
                                    <label for="penalidad_as">
                                        {{ __('PENALIDAD ARSENICO') }}
                                    </label>
                                    @if ($requerimiento->penalidad_as)
                                        <input class="form-control" value="{{ $requerimiento->penalidad_as }}" disabled>
                                    @else
                                        <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                    @endif
                                </div>


                                <div class="form-group col-md-2 g-3">
                                    <label for="penalidad_sb">
                                        {{ __('PENALIDAD ANTIMONIO') }}
                                    </label>
                                    @if ($requerimiento->penalidad_sb)
                                        <input class="form-control" value="{{ $requerimiento->penalidad_sb }}" disabled>
                                    @else
                                        <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                    @endif
                                </div>
                                <div class="form-group col-md-2 g-3">
                                    <label for="penalidad_bi">
                                        {{ __('PENALIDAD BISMUTO') }}
                                    </label>
                                    @if ($requerimiento->penalidad_bi)
                                        <input class="form-control" value="{{ $requerimiento->penalidad_bi }}" disabled>
                                    @else
                                        <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                    @endif
                                </div>
                                <div class="form-group col-md-2 g-3">
                                    <label for="penalidad_pb">
                                        {{ __('PENALIDAD PB +ZN') }}
                                    </label>
                                    @if ($requerimiento->penalidad_pb)
                                        <input class="form-control" value="{{ $requerimiento->penalidad_pb }}" disabled>
                                    @else
                                        <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                    @endif
                                </div>
                             <!--   <div class="form-group col-md-2 g-3">
                                    <label for="penalidad_zn">
                                        {{ __('PENALIDAD ZINC') }}
                                    </label>
                                    @if ($requerimiento->penalidad_zn)
                                        <input class="form-control" value="{{ $requerimiento->penalidad_zn }}" disabled>
                                    @else
                                        <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                    @endif
                                </div>-->
                              

                                <div class="form-group col-md-2 g-3">
                                    <label for="penalidad_hg">
                                        {{ __('PENALIDAD MERCURIO') }}
                                    </label>
                                    @if ($requerimiento->penalidad_hg)
                                        <input class="form-control" value="{{ $requerimiento->penalidad_hg }}" disabled>
                                    @else
                                        <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                    @endif
                                </div>
                                
                                <div class="form-group col-md-2 g-3">
                                    <label for="penalidad_s">
                                        {{ __('PENALIDAD AZUFRE') }}
                                    </label>
                                    @if ($requerimiento->penalidad_s)
                                        <input class="form-control" value="{{ $requerimiento->penalidad_s }}" disabled>
                                    @else
                                        <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                    @endif
                                </div>
                                <!--<div class="form-group col-md-2 g-3">
                                    <label for="penalidad_h2o">
                                        {{ __('PENALIDAD H2O') }}
                                    </label>
                                    @if ($requerimiento->penalidad_h2o)
                                        <input class="form-control" value="{{ $requerimiento->penalidad_h2o }}" disabled>
                                    @else
                                        <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                    @endif
                                </div>-->
                                <p>
                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection