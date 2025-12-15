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
                                    {{ __('VER CLIENTE') }}
                                </h6>
                            </div>
                            <div class="col-md-6 text-end">
                                <a class="btn btn-danger btn-sm" href="{{ route('clientes.index') }}">
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
                                    <span class="badge text-bg-secondary">{{ $cliente->id }}</span>
                                    <strong>
                                        {{ __('y esta operación fue registrada el ') }}
                                    </strong>
                                        {{ $cliente->created_at->format('d-m-Y') }}
                                    <strong>
                                        {{ __('a la(s) ') }}
                                    </strong>
                                        {{ $cliente->created_at->format('H:i:s') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @if ($cliente->updated_at != $cliente->created_at)
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>
                                            {{ __('Estás viendo el ID') }}
                                        </strong>
                                        <span class="badge text-bg-secondary">
                                            {{ $cliente->id }}
                                        </span>
                                        <strong>
                                            {{ __('y esta operación fue actualizada el ') }}
                                        </strong>
                                            {{ $cliente->updated_at->format('d-m-Y') }}
                                        <strong>
                                            {{ __('a la(s) ') }}
                                        </strong>
                                            {{ $cliente->updated_at->format('H:i:s') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @else
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>
                                            {{ __('Este cliente aún no ha sido actualizado') }}
                                        </strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group col-md-4 g-3">
                                <label for="documento_cliente">
                                    {{ __('DNI CLIENTE') }}
                                </label>
                                <div class="input-group">
                                    <input class="form-control" value="{{ $cliente->documento_cliente }}" disabled>
                                    <button class="btn btn-secondary" type="button" id="buscar_cliente_btn" disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 25 25" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z"></path></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group col-md-8 g-3">
                                <label for="datos_cliente">
                                    {{ __('NOMBRE CLIENTE') }}
                                </label>
                                <input class="form-control" value="{{ $cliente->datos_cliente }}" disabled>
                            </div>



                            <div class="form-group col-md-4 g-3">
                                <label for="ruc_empresa">
                                    {{ __('RUC EMPRESA') }}
                                </label>
                                <div class="input-group">
                                    <input class="form-control" value="{{ $cliente->ruc_empresa }}" disabled>
                                    <button class="btn btn-secondary" type="button" id="buscar_cliente_btn" disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 25 25" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z"></path></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group col-md-8 g-3">
                                <label for="razon_social">
                                    {{ __('RAZÓN SOCIAL EMPRESA') }}
                                </label>
                                <input class="form-control" value="{{ $cliente->razon_social }}" disabled>
                            </div>



                            <div class="form-group col-md-6 g-3">
                                <label for="direccion">
                                    {{ __('DIRECCIÓN') }}
                                </label>
                                @if ($cliente->direccion)
                                    <input class="form-control" value="{{ $cliente->direccion }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>


                            <div class="form-group col-md-6 g-3">
                                <label for="telefono">
                                    {{ __('TELÉFONO') }}
                                </label>
                                @if ($cliente->telefono)
                                    <input class="form-control" value="{{ $cliente->telefono }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>

                        <!--    <div class="form-group col-md-6 g-3">
                                <label for="producto">
                                    {{ __('PRODUCTO') }}
                                </label>
                                @if ($cliente->producto)
                                    <input class="form-control" value="{{ $cliente->producto }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>-->
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection