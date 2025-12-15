<form method="POST" action="{{ route('areas.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal fade text-left" id="ModalCreate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-header-container align-items-center w-100">
                        <div class="align-items-center">
                            <h4 class="modal-title mb-0">
                                {{ __('Crear una nueva área') }}
                            </h4>
                        </div>
                        <div class="justify-content-end">
                            <a type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 30px;">
                                &times;
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form">
                        <input name="nombre" class="input" placeholder="Ingrese el nombre de la área" required="" type="text">
                        <span class="input-border"></span>
                    </div>

                    

                 
                    <div class="mb-3 text-end">
                        <button type="submit" class="btn btn-secondary"> GUARDAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>