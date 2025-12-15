<form method="POST" action="{{ route('empleados.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal fade text-left" id="ModalCreate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-header-container align-items-center w-100">
                        <div class="align-items-center">
                            <h4 class="modal-title mb-0">
                                {{ __('Crear un nuevo empleado') }}
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
                    <div class="input-group">

                        <div class="form mb-2">
                            <input name="documento" id="documento_cliente" class="input" placeholder="Ingrese el documento del empleado" required="" type="text">
                            <span class="input-border"></span>
                        </div>
                        <div>
    
                            <button class="btn-search-dni" type="button" id="buscar_cliente_btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 25 25"
                                    style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                    <path
                                        d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z">
                                    </path>
                                </svg>
                            </button>
    
                        </div>  

                    </div>
                    
                   
                    <div class="form mb-3">
                        <input name="nombre" id="datos_cliente" class="input" placeholder="Valide el nombre del empleado" required="" type="text">
                        <span class="input-border"></span>
                    </div>



                    <div class="mb-3 text-center" data-bs-theme="dark">
                        <select name="posicion_id" class="form-control cart-product" style="max-width: 70%">
                            <option selected disabled>{{ __('-- Seleccione la posicion este empleado') }}</option>
                            @if(count($posiciones)>0)
                            @foreach ($posiciones as $posicion)
                                <option value="{{ $posicion->id }}"
                                    {{ old('posicion_id') == $posicion->id ? 'selected' : '' }}>
                                    {{ $posicion->nombre }}
                                </option>
                            @endforeach
                            @endif
                        </select>
                    </div>


                    <div class="mb-3 text-center" data-bs-theme="dark">
                        <select name="area_id" class="form-control cart-product" style="max-width: 70%">
                            <option selected disabled>{{ __('-- Seleccione el área este empleado') }}</option>
                            @if(count($areas)>0)
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}"
                                    {{ old('posicion_id') == $area->id ? 'selected' : '' }}>
                                    {{ $area->nombre }}
                                </option>
                            @endforeach
                            @endif
                        </select>
                    </div>


                    
                    <div class="mb-3 text-center" data-bs-theme="dark">
                        <select name="jefe_id" class="form-control jefe_id" style="max-width: 70%">
                            <option selected disabled>{{ __('-- Seleccione al jefe de este empleado') }}</option>
                            @if(count($empleados)>0)
                            @foreach ($empleados as $empleado)
                                <option value="{{ $empleado->id }}"
                                    {{ old('jefe_id') == $empleado->id ? 'selected' : '' }}>
                                    {{ $empleado->nombre }}
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