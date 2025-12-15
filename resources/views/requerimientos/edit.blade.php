@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('MÓDULO PARA EDITAR CONDICIONES DEL CLIENTE') }}
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
                <form class="editar-requerimiento" action="{{ route('requerimientos.update', $requerimiento->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
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
                                <input type="text" name="igv" id="igv"
                                    class="form-control @error('igv') is-invalid @enderror" value="{{$requerimiento->igv ?? old('igv') }}"
                                    placeholder="Ingrese igv">
                                @error('igv')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                </div>
                                <div class="form-group col-md-2 g-3">
                                    <label for="merma">
                                        {{ __('MERMA') }}
                                    </label>
                                    <input type="text" name="merma" id="merma"
                                        class="form-control @error('merma') is-invalid @enderror" value="{{$requerimiento->merma ?? old('merma') }}"
                                        placeholder="Ingrese merma">
                                    @error('merma')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    </div>
                                    <p>
                                        <div class="container">
                                            <div class="row">
                                                 <!-- Cuarta columna -->
                                                 <div class="col-md-3">
                                                    <h6><strong>PAGABLE</strong></h6>
                                        
                                                    <div class="form-group">
                                                        <label for="pagable_au">PAGABLE ORO</label>
                                                        <input type="text" name="pagable_au" id="pagable_au" class="form-control @error('pagable_au') is-invalid @enderror" value="{{ $requerimiento->pagable_au ?? old('pagable_au') }}" placeholder="Ingrese valor">
                                                        @error('pagable_au')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                        
                                                    <div class="form-group">
                                                        <label for="pagable_ag">PAGABLE PLATA</label>
                                                        <input type="text" name="pagable_ag" id="pagable_ag" class="form-control @error('pagable_ag') is-invalid @enderror" value="{{ $requerimiento->pagable_ag ?? old('pagable_ag') }}" placeholder="Ingrese valor">
                                                        @error('pagable_ag')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                        
                                                    <div class="form-group">
                                                        <label for="pagable_cu">PAGABLE COBRE</label>
                                                        <input type="text" name="pagable_cu" id="pagable_cu" class="form-control @error('pagable_cu') is-invalid @enderror" value="{{ $requerimiento->pagable_cu ?? old('pagable_cu') }}" placeholder="Ingrese valor">
                                                        @error('pagable_cu')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!-- Primera columna -->
                                                <div class="col-md-3">
                                                    <h6><strong>PROTECCION</strong></h6>
                                        
                                                    <div class="form-group">
                                                        <label for="proteccion_au">PROTECCION DEL ORO</label>
                                                        <input type="text" name="proteccion_au" id="proteccion_au" class="form-control @error('proteccion_au') is-invalid @enderror" value="{{ $requerimiento->proteccion_au ?? old('proteccion_au') }}" placeholder="Ingrese valor">
                                                        @error('proteccion_au')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                        
                                                    <div class="form-group">
                                                        <label for="proteccion_ag">PROTECCION DE LA PLATA</label>
                                                        <input type="text" name="proteccion_ag" id="proteccion_ag" class="form-control @error('proteccion_ag') is-invalid @enderror" value="{{ $requerimiento->proteccion_ag ?? old('proteccion_ag') }}" placeholder="Ingrese valor">
                                                        @error('proteccion_ag')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                        
                                                    <div class="form-group">
                                                        <label for="proteccion_cu">PROTECCION DEL COBRE</label>
                                                        <input type="text" name="proteccion_cu" id="proteccion_cu" class="form-control @error('proteccion_cu') is-invalid @enderror" value="{{ $requerimiento->proteccion_cu ?? old('proteccion_cu') }}" placeholder="Ingrese valor">
                                                        @error('proteccion_cu')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                        
                                                <!-- Segunda columna -->
                                                <div class="col-md-3">
                                                    <h6><strong>DEDUCCION</strong></h6>
                                        
                                                    <div class="form-group">
                                                        <label for="deduccion_au">DEDUCCION ORO</label>
                                                        <input type="text" name="deduccion_au" id="deduccion_au" class="form-control @error('deduccion_au') is-invalid @enderror" value="{{ $requerimiento->deduccion_au ?? old('deduccion_au') }}" placeholder="Ingrese valor">
                                                        @error('deduccion_au')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                        
                                                    <div class="form-group">
                                                        <label for="deduccion_ag">DEDUCCION PLATA</label>
                                                        <input type="text" name="deduccion_ag" id="deduccion_ag" class="form-control @error('deduccion_ag') is-invalid @enderror" value="{{ $requerimiento->deduccion_ag ?? old('deduccion_ag') }}" placeholder="Ingrese valor">
                                                        @error('deduccion_ag')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                        
                                                    <div class="form-group">
                                                        <label for="deduccion_cu">DEDUCCION DEL COBRE</label>
                                                        <input type="text" name="deduccion_cu" id="deduccion_cu" class="form-control @error('deduccion_cu') is-invalid @enderror" value="{{ $requerimiento->deduccion_cu ?? old('deduccion_cu') }}" placeholder="Ingrese valor">
                                                        @error('deduccion_cu')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                        
                                                <!-- Tercera columna -->
                                                <div class="col-md-3">
                                                    <h6><strong>REFINAMIENTO</strong></h6>
                                        
                                                    <div class="form-group">
                                                        <label for="refinamiento_au">REFINAMIENTO ORO</label>
                                                        <input type="text" name="refinamiento_au" id="refinamiento_au" class="form-control @error('refinamiento_au') is-invalid @enderror" value="{{ $requerimiento->refinamiento_au ?? old('refinamiento_au') }}" placeholder="Ingrese valor">
                                                        @error('refinamiento_au')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                        
                                                    <div class="form-group">
                                                        <label for="refinamiento_ag">REFINAMIENTO PLATA</label>
                                                        <input type="text" name="refinamiento_ag" id="refinamiento_ag" class="form-control @error('refinamiento_ag') is-invalid @enderror" value="{{ $requerimiento->refinamiento_ag ?? old('refinamiento_ag') }}" placeholder="Ingrese valor">
                                                        @error('refinamiento_ag')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                        
                                                    <div class="form-group">
                                                        <label for="refinamiento_cu">REFINAMIENTO COBRE</label>
                                                        <input type="text" name="refinamiento_cu" id="refinamiento_cu" class="form-control @error('refinamiento_cu') is-invalid @enderror" value="{{ $requerimiento->refinamiento_cu ?? old('refinamiento_cu') }}" placeholder="Ingrese valor">
                                                        @error('refinamiento_cu')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                        
                                               
                                            </div>
                                        <P>
                                            <div class="row">
                                                <!-- Otros campos -->
                                                <div class="col-md-12">
                                                    <h6><strong>OTROS</strong></h6>
                                        
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="maquila">MAQUILA</label>
                                                                <input type="text" name="maquila" id="maquila" class="form-control @error('maquila') is-invalid @enderror" value="{{ $requerimiento->maquila ?? old('maquila') }}" placeholder="Ingrese maquila">
                                                                @error('maquila')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="analisis">ANALISIS</label>
                                                                <input type="text" name="analisis" id="analisis" class="form-control @error('analisis') is-invalid @enderror" value="{{ $requerimiento->analisis ?? old('analisis') }}" placeholder="Ingrese analisis">
                                                                @error('analisis')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="estibadores">ESTIBADORES</label>
                                                                <input type="text" name="estibadores" id="estibadores" class="form-control @error('estibadores') is-invalid @enderror" value="{{ $requerimiento->estibadores ?? old('estibadores') }}" placeholder="Ingrese estibadores">
                                                                @error('estibadores')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="molienda">MOLIENDA</label>
                                                                <input type="text" name="molienda" id="molienda" class="form-control @error('molienda') is-invalid @enderror" value="{{ $requerimiento->molienda ?? old('molienda') }}" placeholder="Ingrese molienda">
                                                                @error('molienda')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                    
                 
                        <p>
                            <div class="row">
                                <h6><strong>PENALIDADES</strong></h6>

                                <div class="form-group col-md-2 g-3">
                                    <label for="penalidad_as">
                                        {{ __('PENALIDAD ARSENICO ') }}
                                    </label>
                                    <input type="text" name="penalidad_as" id="penalidad_as"
                                        class="form-control @error('penalidad_as') is-invalid @enderror" value="{{$requerimiento->penalidad_as ??  old('penalidad_as') }}"
                                        placeholder="Ingrese penalidad AS">
                                    @error('penalidad_as')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    </div>
                                    <div class="form-group col-md-2 g-3">
                                        <label for="penalidad_sb" >
                                            {{ __('PENALIDAD ANTIMONIO') }}
                                        </label>
                                        <input type="text" name="penalidad_sb" id="penalidad_sb"
                                            class="form-control @error('penalidad_sb') is-invalid @enderror" value="{{$requerimiento->penalidad_sb ?? old('penalidad_sb') }}"
                                            placeholder="Ingrese penalidad SB">
                                        @error('penalidad_sb')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        </div>
                                        <div class="form-group col-md-2 g-3">
                                            <label for="penalidad_bi" >
                                                {{ __('PENALIDAD BISMUTO ') }}
                                            </label>
                                            <input type="text" name="penalidad_bi" id="penalidad_bi"
                                                class="form-control @error('penalidad_bi') is-invalid @enderror" value="{{$requerimiento->penalidad_bi ??  old('penalidad_bi') }}"
                                                placeholder="Ingrese penalidad BI">
                                            @error('penalidad_bi')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            </div>
                                        <div class="form-group col-md-2 g-3">
                                            <label for="penalidad_pb" >
                                                {{ __('PENALIDAD PB + ZINC') }}
                                            </label>
                                            <input type="text" name="penalidad_pb" id="penalidad_pb"
                                                class="form-control @error('penalidad_pb') is-invalid @enderror" value="{{$requerimiento->penalidad_pb ??  old('penalidad_pb') }}"
                                                placeholder="Ingrese penalidad PB+ZN">
                                            @error('penalidad_pb')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            </div>
            
                                         <!--   <div class="form-group col-md-2 g-3">
                                                <label for="penalidad_zn" >
                                                    {{ __('PENALIDAD ZINC ') }}
                                                </label>
                                                <input type="text" name="penalidad_zn" id="penalidad_zn"
                                                    class="form-control @error('penalidad_zn') is-invalid @enderror" value="{{$requerimiento->penalidad_zn ??  old('penalidad_zn') }}"
                                                    placeholder="Ingrese penalidad ZN">
                                                @error('penalidad_zn')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                </div>-->
            
                                
            
                                                    <div class="form-group col-md-2 g-3">
                                                        <label for="penalidad_hg">
                                                            {{ __('PENALIDAD MERCURIO ') }}
                                                        </label>
                                                        <input type="text" name="penalidad_hg" id="penalidad_hg"
                                                            class="form-control @error('penalidad_hg') is-invalid @enderror" value="{{$requerimiento->penalidad_hg ??  old('penalidad_hg') }}"
                                                            placeholder="Ingrese penalidad HG">
                                                        @error('penalidad_hg')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                        </div>
                                                         <!--azufre obtiene valor de h2o-->
                                                        <div class="form-group col-md-2 g-3">
                                                            <label for="penalidad_s" >
                                                                {{ __('PENALIDAD H2O ') }}
                                                            </label>
                                                            <input type="text" name="penalidad_s" id="penalidad_s"
                                                                class="form-control @error('penalidad_s') is-invalid @enderror" value="{{$requerimiento->penalidad_s ??  old('penalidad_s') }}"
                                                                placeholder="Ingrese penalidad S">
                                                            @error('penalidad_s')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                            </div>
                                                         <!--   <div class="form-group col-md-2 g-3">
                                                                <label for="penalidad_h2o">
                                                                    {{ __('PENALIDAD H2O ') }}
                                                                </label>
                                                                <input type="text" name="penalidad_h2o" id="penalidad_h2o"
                                                                    class="form-control @error('penalidad_h2o') is-invalid @enderror" value="{{$requerimiento->penalidad_h2o ??  old('penalidad_h2o') }}"
                                                                    placeholder="Ingrese penalidad H2O">
                                                                @error('penalidad_h2o')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                                </div>-->
                                                                <P>
                                                               
                
            
                        <div class="col-md-12 text-end g-3">
                            <button type="submit" class="btn btn-secondary btn-sm">
                                {{ __('ACTUALIZAR REGISTRO') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            $('.editar-requerimiento').submit(function(e){
                e.preventDefault();
                Swal.fire({
                    title: '¿Actualizar Requerimiento?',
                    icon: 'warning',
                    ShowCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Si, confirmar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if(result.isConfirmed){
                        this.submit();
                    }
                })
            });
        </script>
    @endpush
    
    
@endsection