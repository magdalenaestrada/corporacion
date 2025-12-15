@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">{{ __('DETALLE DE BLENDING') }}</h6>
                    </div>
                    <div class="col-md-6 text-end">
                        <a class="btn btn-danger btn-sm" href="{{ route('blendings.index') }}">
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
                            <span class="badge text-bg-secondary">{{ $blending->id }}</span>
                            <strong>
                                {{ __('y esta operación fue registrada el ') }}
                            </strong>
                                {{ $blending->created_at->format('d-m-Y') }}
                            <strong>
                                {{ __('a la(s) ') }}
                            </strong>
                                {{ $blending->created_at->format('H:i:s') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @if ($blending->updated_at != $blending->created_at)
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>
                                    {{ __('Estás viendo el ID') }}
                                </strong>
                                <span class="badge text-bg-secondary">
                                    {{ $blending->id }}
                                </span>
                                <strong>
                                    {{ __('y esta operación fue actualizada el ') }}
                                </strong>
                                    {{ $blending->updated_at->format('d-m-Y') }}
                                <strong>
                                    {{ __('a la(s) ') }}
                                </strong>
                                    {{ $blending->updated_at->format('H:i:s') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @else
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>
                                    {{ __('Este ingreso aún no ha sido actualizado') }}
                                </strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                    </div>
            <div class="card-body">
                <div class="row">
                    <div class="mb-3">
                        <div class="row">
                            <div class="column">
                                <strong>{{ __('Código') }}:</strong>
                                <span>{{ $blending->cod }}</span>
                            </div>
                            
                            <div class="column">
                                <strong>{{ __('Preparación') }}:</strong>
                                <span>{{ $blending->lista }}</span>
                            </div>
                            
                            <div class="column">
                                <strong>{{ __('Notas') }}:</strong>
                                <span>{{ $blending->notas }}</span>
                            </div>
                            
                            <div class="column">
                                <strong>{{ __('Estado') }}:</strong>
                                <span>{{ $blending->estado }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <style>
                        .row {
                            display: flex;
                            justify-content: space-between; /* Espacio uniforme entre las columnas */
                            flex-wrap: wrap; /* Asegura que las columnas no se desborden en pantallas pequeñas */
                        }
                    
                        .column {
                            flex: 1; /* Hace que cada columna ocupe el mismo ancho */
                            padding: 0 10px; /* Espacio entre las columnas */
                        }
                    
                        /* Opcional: Para manejar el espaciado y diseño en pantallas pequeñas */
                        @media (max-width: 768px) {
                            .column {
                                flex: 1 0 100%; /* En pantallas pequeñas, las columnas ocupan el 100% de ancho */
                                margin-bottom: 10px; /* Espacio entre las filas */
                            }
                        }
                    </style>
                    
            <h6>{{ __('INGRESOS ASOCIADOS') }}</h6>
            @if($blending->ingresos->isEmpty())
                <p>{{ __('No hay ingresos asociados a este blending.') }}</p>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('Fecha de Ingreso') }}</th>
                            <th>{{ __('Cliente') }}</th >
                            <th>{{ __('Nro Ticket') }}</th>
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
                <strong>{{ __('Peso Total') }}:</strong>
                <span class="ms-2">{{ $blending->pesoblending }} </span>
            </div>
        </div>


@endsection

