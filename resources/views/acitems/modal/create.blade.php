<form method="POST" action="{{ route('acitems.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal fade text-left" id="ModalCreate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-header-container align-items-center w-100">
                        <div class="align-items-center">
                            <h4 class="modal-title mb-0">
                                {{ __('Crear un nuevo Item para el activo: ')  }} {{$activo->nombre }}
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
                        <input name="nombre" id="nombre" class="input" placeholder="Ingrese el nombre del item" required="" type="text">
                        <span class="input-border"></span>
                    </div>

                    <div class="form mb-3">
                        <input name="observacion" id="observacion" class="input" placeholder="Ingrese una observación" type="text">
                        <span class="input-border"></span>
                    </div>

                   

                   
                   
                   <div class="mb-3 text-center" data-bs-theme="dark">
                        <select name="ac_activo_id" class="form-control activo_id" style="max-width: 70%">
                            <option selected value="{{ $activo->id }}">{{ $activo->nombre }}</option>
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