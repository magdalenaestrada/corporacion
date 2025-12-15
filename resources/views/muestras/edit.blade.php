@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('MÓDULO PARA EDITAR MUESTRAS') }}
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
                <form class="editar-muestra" action="{{ route('muestras.update', $muestra->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        
                            <div class="form-group col-md-4 g-3 mb-3">
                                <label for="codigo" class="text-muted fs-5 fw-bold mb-2"> 
                                {{ __('CODIGO') }}
                            </label>
                            @if ($muestra->codigo)
                            <input 
                                type="text" 
                                class="form-control" 
                                name="codigo" 
                                id="codigo" 
                                value="{{ old('codigo', $muestra->codigo) }}" 
                                required
                            >
                        @else
                            <input 
                                type="text" 
                                class="form-control" 
                                value="{{ __('No hay datos disponibles') }}" 
                                disabled
                            >
                        @endif
                    </div>
                                    <div class="form-group col-md-2 g-3 mb-3">
                                        <label for="humedad" class="text-muted fs-5 fw-bold mb-2"> 
                                            {{ __('HUMEDAD') }}
                                        </label>
                                        <input type="text" name="humedad" id="humedad"
                                            class="form-control @error('humedad') is-invalid @enderror" value="{{$muestra->humedad ?? old('humedad') }}"
                                            placeholder="  Ingrese valor de la humedad ">
                                        @error('humedad')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                        
    
                        <fieldset class="mb-3">
                            <legend class="h5">{{ __('METALES PRECIOSOS') }}</legend>
                            <div class="row">
                        <div class="form-group col-md-2 g-3">
                            <label for="au" >
                                
                                {{ __('ORO') }}
                            </label>
                            <input type="text" name="au" id="au"
                                class="form-control @error('au') is-invalid @enderror" value="{{$muestra->au ?? old('au') }}"
                                placeholder="Ingrese valor del oro">
                            @error('au')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
    
                        <div class="form-group col-md-2 g-3">
                            <label for="ag" >
                                {{ __('PLATA') }}
                            </label>
                            <input type="text" name="ag" id="ag"
                                class="form-control @error('ag') is-invalid @enderror" value="{{$muestra->ag ?? old('ag') }}"
                                placeholder="Ingrese valor de la plata">
                            @error('ag')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-2 g-3">
                            <label for="cu" >
                                {{ __('COBRE') }}
                            </label>
                            <input type="text" name="cu" id="cu"
                                class="form-control @error('cu') is-invalid @enderror" value="{{$muestra->cu ?? old('cu') }}"
                                placeholder="Ingrese valor del cobre">
                            @error('cu')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </fieldset>
                                <fieldset class="mb-3">
                                    <legend class="h5" >{{ __('CONTAMINANTES') }}</legend>
                                    <span class="note">(Nota: "Si no se encuentran valores para los contaminantes, deja el campo vacío.")</span>
                                    <div class="row">
                                    <div class="form-group col-md-2 g-3">
                                        <label for="as">
                                            {{ __('ARSENICO') }}
                                        </label>
                                        <input type="text" name="as" id="as"
                                            class="form-control @error('as') is-invalid @enderror" value="{{ $muestra->as ?? old('as') }}"
                                            placeholder="Ingrese valor del arsenico">
                                        @error('as')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-2 g-3">
                                        <label for="sb" >
                                            {{ __('ANTIMONIO') }}
                                        </label>
                                        <input type="text" name="sb" id="sb"
                                            class="form-control @error('sb') is-invalid @enderror" value="{{$muestra->sb ?? old('sb') }}"
                                            placeholder="Ingrese valor del antimonio">
                                        @error('sb')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-2 g-3">
                                        <label for="pb" >
                                            {{ __('PLOMO + ZINC') }}
                                        </label>
                                        <input type="text" name="pb" id="pb"
                                            class="form-control @error('pb') is-invalid @enderror" value="{{$muestra->pb ?? old('pb') }}"
                                            placeholder="Ingrese valor del plomo">
                                        @error('pb')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                   <!-- <div class="form-group col-md-2 g-3">
                                        <label for="zn">
                                            {{ __('ZINC') }}
                                        </label>
                                        <input type="text" name="zn" id="zn"
                                            class="form-control @error('zn') is-invalid @enderror" value="{{$muestra->zn ?? old('zn') }}"
                                            placeholder="Ingrese valor del zinc">
                                        @error('zn')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div> -->
                                    <div class="form-group col-md-2 g-3">
                                        <label for="bi" >
                                            {{ __('BISMUTO') }}
                                        </label>
                                        <input type="text" name="bi" id="bi"
                                            class="form-control @error('bi') is-invalid @enderror" value="{{$muestra->bi ?? old('bi') }}"
                                            placeholder="Ingrese valor del bismuto">
                                        @error('bi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-2 g-3">
                                        <label for="hg" >
                                            {{ __('MERCURIO') }}
                                        </label>
                                        <input type="text" name="hg" id="hg"
                                            class="form-control @error('hg') is-invalid @enderror" value="{{$muestra->hg ?? old('hg') }}"
                                            placeholder="Ingrese valor del mercurio">
                                        @error('hg')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-2 g-3">
                                        <label for="s">
                                            {{ __('H2O') }}
                                        </label>
                                        <input type="text" name="s" id="s"
                                            class="form-control @error('s') is-invalid @enderror" value="{{$muestra->s ?? old('s') }}"
                                            placeholder="Ingrese valor del azufre">
                                        @error('s')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </fieldset>
                            <fieldset class="mb-3">

                                <div class="form-group col-md-12 g-3">
                                    <label for="obs">
                                        {{ __('OBSERVACION') }}
                                    </label>
                                    <input type="text" name="obs" id="obs"
                                        class="form-control @error('obs') is-invalid @enderror" value="{{$muestra->obs ?? old('obs') }}"
                                        placeholder="INGRESE COMENTARIO U OBSERVACION">
                                    @error('obs')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
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
            $('.editar-muestra').submit(function(e){
                e.preventDefault();
                Swal.fire({
                    title: '¿actualizar muestra?',
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