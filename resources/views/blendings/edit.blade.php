@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('MÓDULO PARA EDITAR BLENDINGS') }}
                        </h6>
                    </div>
                    <div class="col-md-6 text-end">
                        <a class="btn btn-danger btn-sm" href="{{ route('blendings.index') }}">
                            {{ __('VOLVER') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
            <form action="{{ route('blendings.update', $blending->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="d-flex align-items-center g-3">
                    <div class="form-group col-md-3">
                        <label for="lista" class="text-muted">{{ __('PREPARACION BLENDING') }}</label>
                        <select name="lista" id="lista" class="form-control @error('lista') is-invalid @enderror">
                            <option value="">Seleccione tipo preparación</option>
                            @foreach(['COBRE', 'COBRE TIPO 1', 'COBRE TIPO 2', 'PLATA', 'ORO','PLOMO','ZINC'] as $lista)
                                <option value="{{ $lista }}" {{ (old('lista', $blending->lista) == $lista) ? 'selected' : '' }}>{{ $lista }}</option>
                            @endforeach
                        </select>
                        @error('lista')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-3 g-1">
                        <label for="cod" class="text-muted">CODIGO BLENDING</label>
                        <input type="text" name="cod" id="cod" class="form-control @error('cod') is-invalid @enderror" value="{{ old('cod', $blending->cod) }}" readonly>
                        @error('cod')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 g-1">
                        <label for="notas" class="text-muted">NOTAS</label>
                        <input type="text" name="notas" id="notas" class="form-control @error('notas') is-invalid @enderror" value="{{ old('notas', $blending->notas) }}">
                        @error('notas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                

                <h6>{{ __('Ingresos Asociados') }}</h6>
                @if($blending->ingresos->isEmpty())
                    <p>{{ __('No hay ingresos asociados a este blending.') }}</p>
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Fecha de Ingreso') }}</th>
                                <th>{{ __('Cliente') }}</th>
                                <th>{{ __('Lote') }}</th>
                                <th>{{ __('Peso') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blending->ingresos as $ingreso)
                            <tr>
                                <td>{{ $ingreso->fecha_ingreso }}</td>
                                <td>{{ $ingreso->nom_iden }}</td>
                                <td>{{ $ingreso->lote }}</td>
                                <td>{{ $ingreso->peso_total }} kg</td>
                            </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                @endif
                <div class="mb-3 d-flex justify-content-end">
                    <strong>{{ __('Peso Total') }}:</strong>
                    <span class="ms-2">{{ $blending->pesoblending }} </span>
                </div>
                <div class="mb-3 text-end">
                    <button type="submit" class="btn btn-primary">{{ __('Guardar Cambios') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
