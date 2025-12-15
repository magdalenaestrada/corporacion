<form method="POST" action="{{ route('acactivos.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal fade text-left" id="ModalCreate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-header-container align-items-center w-100">
                        <div class="align-items-center">
                            <h4 class="modal-title mb-0">
                                {{ __('Crear un nuevo activo') }}
                            </h4>
                        </div>
                        <div class="justify-content-end">
                            <a type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 30px;">
                                &times;
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-body ">
                    
                   
                    <div class="form mb-3">
                        <input name="nombre" id="nombre" class="input" placeholder="Ingrese el nombre del activo" required="" type="text">
                        <span class="input-border"></span>
                    </div>

                    <div class="form mb-3">
                        <input name="imei" id="imei" class="input" placeholder="Ingrese el imei o el código identificador de fábrica" type="text">
                        <span class="input-border"></span>
                    </div>

                    <div class="form mb-3">
                        <input name="codigo_barras" id="codigo_barras" class="input" placeholder="Ingrese código de barras" required="" type="text">
                        <span class="input-border"></span>
                    </div>

                    <div class="form mb-3">
                        <input name="especificaciones" id="especificaciones" class="input" placeholder="Ingrese las especificaciones" type="text">
                        <span class="input-border"></span>
                    </div>

                    <div class="form mb-3">
                        <input name="observaciones" id="observaciones" class="input" placeholder="Ingrese las observaciones" type="text">
                        <span class="input-border"></span>
                    </div>

                    <div class="form mb-3">
                        <input name="valor" id="valor" class="input" placeholder="Ingrese el valor" type="text">
                        <span class="input-border"></span>
                    </div>
                   
                    <div class="mb-3 text-center" data-bs-theme="dark">
                        <select name="empleado_id" class="form-control empleado_id" style="max-width: 70%">
                            <option selected disabled>{{ __('-- Seleccione al empleado a cargo') }}</option>
                            @if(count($empleados)>0)
                            @foreach ($empleados as $empleado)
                                <option value="{{ $empleado->id }}"
                                    {{ old('empleado_id') == $empleado->id ? 'selected' : '' }}>
                                    {{ $empleado->nombre }}
                                </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    

                    <div class="mb-3 text-center" data-bs-theme="dark">
                        <select name="categoria_id" class="form-control categoria_id" style="max-width: 70%">
                            <option selected disabled>{{ __('-- Seleccione la categoría') }}</option>
                            @if(count($categorias)>0)
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}"
                                    {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{$categoria->codigo}} - {{$categoria->nombre}}
                                </option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                   
                    

                 
                    <div class=" text-end">
                        <button type="submit" class="btn btn-secondary"> GUARDAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>