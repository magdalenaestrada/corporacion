@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('REQUERIMIENTOS') }}
                            <span class="note">(Nota: "Introduce solo valores positivos en los campos.")</span>
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
                <form class="crear-requerimientos" action="{{ route('requerimientos.store') }}" method="POST">
                    @csrf
                     
                    <div class="row">
                        
                        <div class="form-group col-md-11 g-3 mb-3">
                            <label for="cliente_id" class="text-muted">
                                {{ __('CLIENTE') }}
                            </label>
                            <select name="cliente_id" id="cliente_id" class="form-control @error('cliente_id') is-invalid @enderror">
                                <option value="">{{ __('Seleccione un cliente') }}</option>
                                @foreach($clientesDisponibles as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->datos_cliente }} - {{ $cliente->razon_social }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="row">
                        <div class="form-group col-md-2 g-3">
                            <label for="igv" class="text-muted">
                                {{ __('IGV') }}
                            </label>
                            <input type="text" name="igv" id="igv"
                                class="form-control @error('igv') is-invalid @enderror" value="{{ old('igv') }}"
                                placeholder="Ingrese igv">
                            @error('igv')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            </div>
                            <div class="form-group col-md-2 g-3">
                                <label for="merma" class="text-muted">
                                    {{ __('MERMA') }}
                                </label>
                                <input type="text" name="merma" id="merma"
                                    class="form-control @error('merma') is-invalid @enderror" value="{{ old('merma') }}"
                                    placeholder="Ingrese merma">
                                @error('merma')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

<P>
    <div class="row">
        <div class="col-md-3">
            <h6><strong>PAGABLE</strong></h6>
            <div class="form-group">
                <label for="pagable_au" class="text-muted">{{ __('PAGABLE ORO') }}</label>
                <input type="text" name="pagable_au" id="pagable_au" class="form-control @error('pagable_au') is-invalid @enderror" value="{{ old('pagable_au') }}" placeholder="Ingrese valor">
                @error('pagable_au')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="form-group">
                <label for="pagable_ag" class="text-muted">{{ __('PAGABLE PLATA') }}</label>
                <input type="text" name="pagable_ag" id="pagable_ag" class="form-control @error('pagable_ag') is-invalid @enderror" value="{{ old('pagable_ag') }}" placeholder="Ingrese valor">
                @error('pagable_ag')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="form-group">
                <label for="pagable_cu" class="text-muted">{{ __('PAGABLE COBRE') }}</label>
                <input type="text" name="pagable_cu" id="pagable_cu" class="form-control @error('pagable_cu') is-invalid @enderror" value="{{ old('pagable_cu') }}" placeholder="Ingrese valor">
                @error('pagable_cu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    
        <div class="col-md-3">
            <h6><strong>PROTECCION</strong></h6>
            <div class="form-group">
                <label for="proteccion_au" class="text-muted">{{ __('PROTECCION DEL ORO') }}</label>
                <input type="text" name="proteccion_au" id="proteccion_au" class="form-control @error('proteccion_au') is-invalid @enderror" value="{{ old('proteccion_au') }}" placeholder="Ingrese valor">
                @error('proteccion_au')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="form-group">
                <label for="proteccion_ag" class="text-muted">{{ __('PROTECCION DE LA PLATA') }}</label>
                <input type="text" name="proteccion_ag" id="proteccion_ag" class="form-control @error('proteccion_ag') is-invalid @enderror" value="{{ old('proteccion_ag') }}" placeholder="Ingrese valor">
                @error('proteccion_ag')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="form-group">
                <label for="proteccion_cu" class="text-muted">{{ __('PROTECCION DEL COBRE') }}</label>
                <input type="text" name="proteccion_cu" id="proteccion_cu" class="form-control @error('proteccion_cu') is-invalid @enderror" value="{{ old('proteccion_cu') }}" placeholder="Ingrese valor">
                @error('proteccion_cu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    
        <div class="col-md-3">
            <h6><strong>DEDUCCION</strong></h6>
            <div class="form-group">
                <label for="deduccion_au" class="text-muted">{{ __('DEDUCCION ORO') }}</label>
                <input type="text" name="deduccion_au" id="deduccion_au" class="form-control @error('deduccion_au') is-invalid @enderror" value="{{ old('deduccion_au') }}" placeholder="Ingrese valor">
                @error('deduccion_au')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="form-group">
                <label for="deduccion_ag" class="text-muted">{{ __('DEDUCCION PLATA') }}</label>
                <input type="text" name="deduccion_ag" id="deduccion_ag" class="form-control @error('deduccion_ag') is-invalid @enderror" value="{{ old('deduccion_ag') }}" placeholder="Ingrese valor">
                @error('deduccion_ag')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="form-group">
                <label for="deduccion_cu" class="text-muted">{{ __('DEDUCCION DEL COBRE') }}</label>
                <input type="text" name="deduccion_cu" id="deduccion_cu" class="form-control @error('deduccion_cu') is-invalid @enderror" value="{{ old('deduccion_cu') }}" placeholder="Ingrese valor">
                @error('deduccion_cu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    
        <div class="col-md-3">
            <h6><strong>REFINAMIENTO</strong></h6>
            <div class="form-group">
                <label for="refinamiento_au" class="text-muted">{{ __('REFINAMIENTO ORO') }}</label>
                <input type="text" name="refinamiento_au" id="refinamiento_au" class="form-control @error('refinamiento_au') is-invalid @enderror" value="{{ old('refinamiento_au') }}" placeholder="Ingrese valor">
                @error('refinamiento_au')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="form-group">
                <label for="refinamiento_ag" class="text-muted">{{ __('REFINAMIENTO PLATA') }}</label>
                <input type="text" name="refinamiento_ag" id="refinamiento_ag" class="form-control @error('refinamiento_ag') is-invalid @enderror" value="{{ old('refinamiento_ag') }}" placeholder="Ingrese valor">
                @error('refinamiento_ag')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="form-group">
                <label for="refinamiento_cu" class="text-muted">{{ __('REFINAMIENTO COBRE') }}</label>
                <input type="text" name="refinamiento_cu" id="refinamiento_cu" class="form-control @error('refinamiento_cu') is-invalid @enderror" value="{{ old('refinamiento_cu') }}" placeholder="Ingrese valor">
                @error('refinamiento_cu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <P>
        <div class="row">

                <h6><strong>OTROS</strong></h6>
                <div class="col-md-3">
                <div class="form-group">
                    <label for="maquila" class="text-muted">{{ __('MAQUILA') }}</label>
                    <input type="text" name="maquila" id="maquila" class="form-control @error('maquila') is-invalid @enderror" value="{{ old('maquila') }}" placeholder="Ingrese maquila">
                    @error('maquila')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        
            <div class="col-md-3">
                <div class="form-group">
                    <label for="analisis" class="text-muted">{{ __('ANALISIS') }}</label>
                    <input type="text" name="analisis" id="analisis" class="form-control @error('analisis') is-invalid @enderror" value="{{ old('analisis') }}" placeholder="Ingrese análisis">
                    @error('analisis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        
            <div class="col-md-3">
                <div class="form-group">
                    <label for="estibadores" class="text-muted">{{ __('ESTIBADORES') }}</label>
                    <input type="text" name="estibadores" id="estibadores" class="form-control @error('estibadores') is-invalid @enderror" value="{{ old('estibadores') }}" placeholder="Ingrese estibadores">
                    @error('estibadores')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="molienda" class="text-muted">{{ __('MOLIENDA') }}</label>
                <input type="text" name="molienda" id="molienda" class="form-control @error('molienda') is-invalid @enderror" value="{{ old('molienda') }}" placeholder="Ingrese molienda">
                @error('molienda')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
    </div>
    </div>
    
            
                    <P>
                        <div class="row">
                            <h6><strong>PENALIDADES</strong></h6>
                    <div class="form-group col-md-2 g-3">
                        <label for="penalidad_as" class="text-muted">
                            {{ __('PENALIDAD ARSENICO ') }}
                        </label>
                        <input type="text" name="penalidad_as" id="penalidad_as"
                            class="form-control @error('penalidad_as') is-invalid @enderror" value="{{ old('penalidad_as') }}"
                            placeholder="Ingrese penalidad AS">
                        @error('penalidad_as')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        </div>
                        <div class="form-group col-md-2 g-3">
                            <label for="penalidad_sb" class="text-muted">
                                {{ __('PENALIDAD ANTIMONIO') }}
                            </label>
                            <input type="text" name="penalidad_sb" id="penalidad_sb"
                                class="form-control @error('penalidad_sb') is-invalid @enderror" value="{{ old('penalidad_sb') }}"
                                placeholder="Ingrese penalidad SB">
                            @error('penalidad_sb')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            </div>
                            <div class="form-group col-md-2 g-3">
                                <label for="penalidad_bi" class="text-muted">
                                    {{ __('PENALIDAD BISMUTO ') }}
                                </label>
                                <input type="text" name="penalidad_bi" id="penalidad_bi"
                                    class="form-control @error('penalidad_bi') is-invalid @enderror" value="{{ old('penalidad_bi') }}"
                                    placeholder="Ingrese penalidad BI">
                                @error('penalidad_bi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                </div>
                            <div class="form-group col-md-2 g-3">
                                <label for="penalidad_pb" class="text-muted">
                                    {{ __('PENALIDAD PB+ZINC ') }}
                                </label>
                                <input type="text" name="penalidad_pb" id="penalidad_pb"
                                    class="form-control @error('penalidad_pb') is-invalid @enderror" value="{{ old('penalidad_pb') }}"
                                    placeholder="Ingrese penalidad PB+ZN">
                                @error('penalidad_pb')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                </div>

                             <!--   <div class="form-group col-md-2 g-3">
                                    <label for="penalidad_zn" class="text-muted">
                                        {{ __('PENALIDAD ZINC ') }}
                                    </label>
                                    <input type="text" name="penalidad_zn" id="penalidad_zn"
                                        class="form-control @error('penalidad_zn') is-invalid @enderror" value="{{ old('penalidad_zn') }}"
                                        placeholder="Ingrese penalidad ZN">
                                    @error('penalidad_zn')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    </div>-->

                                    

                                        <div class="form-group col-md-2 g-3">
                                            <label for="penalidad_hg" class="text-muted">
                                                {{ __('PENALIDAD MERCURIO ') }}
                                            </label>
                                            <input type="text" name="penalidad_hg" id="penalidad_hg"
                                                class="form-control @error('penalidad_hg') is-invalid @enderror" value="{{ old('penalidad_hg') }}"
                                                placeholder="Ingrese penalidad HG">
                                            @error('penalidad_hg')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            </div>
                                            <!--azufre obtiene valor de h2o-->
                                            <div class="form-group col-md-2 g-3">
                                                <label for="penalidad_s" class="text-muted">
                                                    {{ __('PENALIDAD H2O ') }}
                                                </label>
                                                <input type="text" name="penalidad_s" id="penalidad_s"
                                                    class="form-control @error('penalidad_s') is-invalid @enderror" value="{{ old('penalidad_s') }}"
                                                    placeholder="Ingrese penalidad H2O">
                                                @error('penalidad_s')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                </div>
                                              <!--  <div class="form-group col-md-2 g-3">
                                                    <label for="penalidad_h2o" class="text-muted">
                                                        {{ __('PENALIDAD H2O ') }}
                                                    </label>
                                                    <input type="text" name="penalidad_h2o" id="penalidad_h2o"
                                                        class="form-control @error('penalidad_h2o') is-invalid @enderror" value="{{ old('penalidad_h2o') }}"
                                                        placeholder="Ingrese penalidad H2O">
                                                    @error('penalidad_h2o')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                    </div>
                                                -->
                                                    
                    <div class="col-md-12 text-end g-3">
                        <button type="submit" class="btn btn-secondary btn-sm">
                            {{ __('GUARDAR MUESTRA') }}
                        </button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    @push('js')
        <script>
            $('.crear-muestra').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Crear muestra?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Si, confirmar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                })
            });
        </script>
    @endpush
@endsection
