@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <h6 class="mt-2">
                                    {{ __('VER MUESTRA') }}
                                </h6>
                            </div>
                            <div class="col-md-6 text-end">
                                <a class="btn btn-danger btn-sm" href="{{ route('muestras.index') }}">
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
                                    <span class="badge text-bg-secondary">{{ $muestra->id }}</span>
                                    <strong>
                                        {{ __('con el codigo') }}
                                    </strong>
                                    <span class="badge text-bg-secondary">{{ $muestra->codigo }}</span>
                                    <strong>
                                        {{ __('y esta operación fue registrada el ') }}
                                    </strong>
                                        {{ $muestra->created_at->format('d-m-Y') }}
                                    <strong>
                                        {{ __('a la(s) ') }}
                                    </strong>
                                        {{ $muestra->created_at->format('H:i:s') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @if ($muestra->updated_at != $muestra->created_at)
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>
                                            {{ __('Estás viendo el ID') }}
                                        </strong>
                                        <span class="badge text-bg-secondary">
                                            {{ $muestra->id }}
                                        </span>
                                        <strong>
                                            {{ __('y esta operación fue actualizada el ') }}
                                        </strong>
                                            {{ $muestra->updated_at->format('d-m-Y') }}
                                        <strong>
                                            {{ __('a la(s) ') }}
                                        </strong>
                                            {{ $muestra->updated_at->format('H:i:s') }}
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
                                <div class="form-group col-md-4 g-3 mb-3">
                                    <label for="codigo" class="text-muted fs-5 fw-bold mb-2"> 
                                    {{ __('CODIGO') }}
                                </label>
                                @if ($muestra->codigo)
                                    <input class="form-control" value="{{ $muestra->codigo }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>
                            <div class="form-group col-md-2 g-3">
                                <label for="humedad"  class="text-muted fs-5 fw-bold mb-2">
                                    {{ __('HUMEDAD') }}
                                </label>
                                @if ($muestra->humedad)
                                    <input class="form-control" value="{{ $muestra->humedad }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>
                            <fieldset class="mb-3">
                                <legend class="h5">{{ __('METALES PRECIOSOS') }}</legend>
                                <div class="row">
                            <div class="form-group col-md-2 g-3">
                                <label for="au">
                                    {{ __('ORO') }}
                                </label>
                                @if ($muestra->au)
                                    <input class="form-control" value="{{ $muestra->au }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>


                            <div class="form-group col-md-2 g-3">
                                <label for="ag">
                                    {{ __('PLATA') }}
                                </label>
                                @if ($muestra->ag)
                                    <input class="form-control" value="{{ $muestra->ag }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>

                            <div class="form-group col-md-2 g-3">
                                <label for="cu">
                                    {{ __('COBRE') }}
                                </label>
                                @if ($muestra->cu)
                                    <input class="form-control" value="{{ $muestra->cu }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>
                            
                        </fieldset>
                        <fieldset class="mb-3">
                            <legend class="h5">{{ __('CONTAMINANTES') }}</legend>
                            <span class="note">(Nota: "Si no se encuentran valores para los contaminantes, deja el campo vacío.")</span>
                            <div class="row">
                            <div class="form-group col-md-2 g-3">
                                <label for="as">
                                    {{ __('ARSENICO') }}
                                </label>
                                @if ($muestra->as)
                                    <input class="form-control" value="{{ $muestra->as }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>
                            
                            <div class="form-group col-md-2 g-3">
                                <label for="sb">
                                    {{ __('ANTOMONIO') }}
                                </label>
                                @if ($muestra->sb)
                                    <input class="form-control" value="{{ $muestra->sb }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>
                            
                            <div class="form-group col-md-2 g-3">
                                <label for="pb">
                                    {{ __('PLOMO + ZINC') }}
                                </label>
                                @if ($muestra->pb)
                                    <input class="form-control" value="{{ $muestra->pb }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>
                            
                       <!--     <div class="form-group col-md-2 g-3">
                                <label for="zn">
                                    {{ __('ZINC') }}
                                </label>
                                @if ($muestra->zn)
                                    <input class="form-control" value="{{ $muestra->zn }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div> -->

                            <div class="form-group col-md-2 g-3">
                                <label for="bi">
                                    {{ __('BISMUTO') }}
                                </label>
                                @if ($muestra->bi)
                                    <input class="form-control" value="{{ $muestra->bi }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>
                            <div class="form-group col-md-2 g-3">
                                <label for="hg">
                                    {{ __('MERCURIO') }}
                                </label>
                                @if ($muestra->hg)
                                    <input class="form-control" value="{{ $muestra->hg }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>
                            <div class="form-group col-md-2 g-3">
                                <label for="s">
                                    {{ __('H2O') }}
                                </label>
                                @if ($muestra->s)
                                    <input class="form-control" value="{{ $muestra->s }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>
                        </fieldset>
                   
                    <div class="form-group col-md-12 g-3">
                        <label for="obs"  class="text-muted fs-5 fw-bold mb-2">
                            {{ __('OBSERVACION') }}
                        </label>
                        @if ($muestra->obs)
                            <input class="form-control" value="{{ $muestra->obs }}" disabled>
                        @else
                            <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                        @endif
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection