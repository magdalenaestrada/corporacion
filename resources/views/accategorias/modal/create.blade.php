<form method="POST" action="{{ route('accategorias.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal fade text-left" id="ModalCreate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-header-container align-items-center w-100">
                        <div class="align-items-center">
                            <h4 class="modal-title mb-0">
                                {{ __('Crear una nueva categoría') }}
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
                        <input name="nombre" id="nombre" class="input" placeholder="Ingrese el nombre de la categoría" required="" type="text">
                        <span class="input-border"></span>
                    </div>

                    <div class="form mb-3">
                        <input name="codigo" id="codigo" class="input" placeholder="Ingrese el código de la categoría" required="" type="text">
                        <span class="input-border"></span>
                    </div>
                   
                    <div class="mb-3 text-center" data-bs-theme="dark">
                        <select name="categoria_padre_id" class="form-control categoria_padre_id" style="max-width: 70%">
                            <option selected disabled>{{ __('-- Seleccione a la categoría padre') }}</option>
                            @if(count($categorias)>0)
                            @foreach ($categorias_select as $categoria)
                                <option value="{{ $categoria->id }}"
                                    {{ old('categoria_padre_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
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