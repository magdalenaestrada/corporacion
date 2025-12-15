@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('MUESTRAS') }}
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
                <form class="crear-muestras" action="{{ route('muestras.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                    <div class="form-group col-md-4 g-3 mb-3">
                        <label for="codigo" class="text-muted fs-5 fw-bold mb-2"> 
                            {{ __('CODIGO') }}
                        </label>
                        <input type="text" name="codigo" id="codigo"
                            class="form-control @error('codigo') is-invalid @enderror" value="{{ old('codigo') }}"
                            placeholder="Ingrese codigo de laboratorio">
                        @error('codigo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3 g-3 mb-3">
                        <label for="humedad" class="text-muted fs-5 fw-bold mb-2">
                            {{ __('HUMEDAD') }}
                        </label>
                        <input type="text" name="humedad" id="humedad"
                            class="form-control @error('humedad') is-invalid @enderror" value="{{ old('humedad') }}"
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
                        <label for="au" class="text-muted">
                            {{ __('ORO') }}
                        </label>
                        <input type="text" name="au" id="au"
                            class="form-control @error('au') is-invalid @enderror" value="{{ old('au') }}"
                            placeholder="Ingrese valor del oro">
                        @error('au')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-2 g-3">
                        <label for="ag" class="text-muted">
                            {{ __('PLATA') }}
                        </label>
                        <input type="text" name="ag" id="ag"
                            class="form-control @error('ag') is-invalid @enderror" value="{{ old('ag') }}"
                            placeholder="Ingrese valor de la plata">
                        @error('ag')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-2 g-3">
                        <label for="cu" class="text-muted">
                            {{ __('COBRE') }}
                        </label>
                        <input type="text" name="cu" id="cu"
                            class="form-control @error('cu') is-invalid @enderror" value="{{ old('cu') }}"
                            placeholder="Ingrese valor del cobre">
                        @error('cu')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                </fieldset>
                    <legend class="h5" >{{ __('CONTAMINANTES') }}</legend>
                    <span class="note">(Nota: "Si no se encuentran valores para los contaminantes, deja el campo vacío.")</span>
                    <div class="row">
                    <div class="form-group col-md-2 g-3">
                        <label for="as" class="text-muted">
                            {{ __('ARSENICO') }}
                        </label>
                        <input type="text" name="as" id="as"
                            class="form-control @error('as') is-invalid @enderror" value="{{ old('as') }}"
                            placeholder="Ingrese valor del arsenico">
                        @error('as')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-2 g-3">
                        <label for="sb" class="text-muted">
                            {{ __('ANTIMONIO') }}
                        </label>
                        <input type="text" name="sb" id="sb"
                            class="form-control @error('sb') is-invalid @enderror" value="{{ old('sb') }}"
                            placeholder="Ingrese valor del antimonio">
                        @error('sb')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-2 g-3">
                        <label for="bi" class="text-muted">
                            {{ __('BISMUTO') }}
                        </label>
                        <input type="text" name="bi" id="bi"
                            class="form-control @error('bi') is-invalid @enderror" value="{{ old('bi') }}"
                            placeholder="Ingrese valor del bismuto">
                        @error('bi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-2 g-3">
                        <label for="pb" class="text-muted">
                            {{ __('PLOMO + ZINC') }}
                        </label>
                        <input type="text" name="pb" id="pb"
                            class="form-control @error('pb') is-invalid @enderror" value="{{ old('pb') }}"
                            placeholder="Ingrese valor plomo + zinc">
                        @error('pb')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!--
                    <div class="form-group col-md-2 g-3">
                        <label for="zn" class="text-muted">
                            {{ __('ZINC') }}
                        </label>
                        <input type="text" name="zn" id="zn"
                            class="form-control @error('zn') is-invalid @enderror" value="{{ old('zn') }}"
                            placeholder="Ingrese valor del zinc">
                        @error('zn')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div> -->
                    
                    <div class="form-group col-md-2 g-3">
                        <label for="hg" class="text-muted">
                            {{ __('MERCURIO') }}
                        </label>
                        <input type="text" name="hg" id="hg"
                            class="form-control @error('hg') is-invalid @enderror" value="{{ old('hg') }}"
                            placeholder="Ingrese valor del mercurio">
                        @error('hg')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-2 g-3">
                        <label for="s" class="text-muted">
                            {{ __('H2O') }}
                        </label>
                        <input type="text" name="s" id="s"
                            class="form-control @error('s') is-invalid @enderror" value="{{ old('s') }}"
                            placeholder="Ingrese valor del azufre">
                        @error('s')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
          
                    <div class="row">

                <div class="form-group col-md-12 g-3">
                    <label for="obs" class="text-muted fs-5 fw-bold mb-2">
                        {{ __('OBSERVACION') }}
                    </label>
                    <input type="text" name="obs" id="obs"
                        class="form-control @error('obs') is-invalid @enderror" value="{{ old('obs') }}"
                        placeholder="INGRESE COMENTARIO U OBSERVACION">
                    @error('obs')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
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
