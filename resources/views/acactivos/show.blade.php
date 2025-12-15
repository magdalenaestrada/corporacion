@extends('layouts.app')


@push('css')

    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    <link href="{{ asset('css/actionviews.css') }}" rel="stylesheet">
    


@endpush
    
@section('content')


<div class="container">
    <header>
      
    <h2 class="text-center">{{__('ESTÁS VIENDO EL ACTIVO: ')}} {{$activo->nombre}}</h2>
    <div class="create-btn-container text-end">

        <form action="{{ route('acactivos.index') }}">
            <button class="volver-btn">
                <span class="btn-volver-text" type="submit">Volver</span>
            </button>
        </form>
        
        
    </div>
    </header>

    <main class="mt-5">
        <div class="row">

            <div class="col-md-4 mb-4 text-center">
                <label for="">{{__('Id:')}}</label>
                <input class="show-input" value="{{$activo->id}}" disabled placeholder="No hay datos..." name="text" type="text" />
    
            </div>

            <div class="col-md-4 mb-4 text-center">
                <label for="">{{__('Identificador de fábrica/IMEI:')}}</label>
                <input class="show-input" value="{{$activo->imei}}" disabled placeholder="No hay datos..." name="text" type="text" />
    
            </div>

            <div class="col-md-4 mb-4 text-center">
                <label for="">{{__('Código de barras:')}}</label>
                <input class="show-input" value="{{$activo->codigo_barras}}" disabled placeholder="No hay datos..." name="text" type="text" />
    
            </div>

            <div class="col-md-12 mb-4  text-center">
                <label for="">{{__('Especificaciones:')}}</label>
                <input class="show-input input-especificaciones" value="{{$activo->especificaciones}}" disabled placeholder="No hay datos..." name="text" type="text" />
    
            </div>

            <div class="col-md-12 mb-4 text-center">
                <label for="">{{__('Observaciones:')}}</label>
                <input class="show-input input-observaciones" value="{{$activo->observaciones}}" disabled placeholder="No hay datos..." name="text" type="text" />
    
            </div>

            <div class="col-md-6 mb-4 text-center">
                <label for="">{{__('Valor:')}}</label>
                <input class="show-input" value="s/{{$activo->valor}}" disabled placeholder="No hay datos..." name="text" type="text" />
    
            </div>

            <div class="col-md-6 mb-4 text-center">
                <label for="">{{__('Responsable:')}}</label>

                @if ($activo->empleado)
                <input class="show-input" value="{{$activo->empleado->nombre}}" disabled placeholder="No hay datos..." name="text" type="text" />
                @else
                <input class="show-input"  disabled placeholder="No hay datos..." name="text" type="text" />
                @endif
            </div>

            <div class="col-md-4 mb-4 text-center">
                <label for="">{{__('Estado:')}}</label>
                @if ($activo->estado)
                <input class="show-input" value="{{$activo->estado->nombre}}" disabled placeholder="No hay datos..." name="text" type="text" />
                @else
                <input class="show-input"  disabled placeholder="No hay datos..." name="text" type="text" />
                @endif
            </div>


            <div class="col-md-4 mb-4 text-center">
                <label for="">{{__('Categoría:')}}</label>
                <label for="">{{__('Estado:')}}</label>
                @if ($activo->categoria)
                <input class="show-input" value="{{$activo->categoria->nombre}}" disabled placeholder="No hay datos..." name="text" type="text" />
                @else
                <input class="show-input"  disabled placeholder="No hay datos..." name="text" type="text" />
                @endif
            </div>

            <div class="col-md-4 mb-4 text-center">
                <label for="">{{__('Fecha de creación:')}}</label>
                <input class="show-input" value="{{$activo->created_at}}" disabled placeholder="No hay datos..." name="text" type="text" />
                
            </div>

            <div class="row">

                <div class="col-md-6 text-center">
                    {!!DNS2D::getBarcodeHTML("$activo->codigo_barras", 'QRCODE')!!}
                </div>
    
                <div class="col-md-6 text-center">
                    {!! DNS1D::getBarcodeHTML("$activo->codigo_barras", 'C128') !!}
                </div>

            </div>

           




        </div>
        
        <div class="text-end mt-2">
            <a class="beautiful-button" href="#" data-toggle="modal" data-target="#ModalCreate">
                Añadir item
            </a>
        </div>

        <h6 class="text-center">ITEMS</h6>
        
        <div class="responsive-table">
            <table style="font-size:12px" class="table table-hover table-dark text-center">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Observación</th>
                    <th scope="col">Fecha de creación</th>
                  </tr>
                </thead>
                <tbody style="font-size:12px">
                  @if (count($activo->items)  > 0)
                    @foreach ($activo->items as $item)
                      <tr>
                        <th scope="row">{{$item->id}}</th>
                        <td>{{$item->nombre}}</td>
    
                        <td>{{$item->observacion}}</td>
    
                        <td>{{$item->created_at}}</td>
                        
    
                       
    
    
    
                        </td>
                      </tr>
                    @endforeach
                  @else
                  <tr>
                    <td colspan="7" class="text-center">
                        {{ __('No hay datos disponibles') }} 
                    </td>
                  </tr>
                  @endif
                  
                </tbody>
            </table>
        </div>
    </main>
    
</div>


@include('acitems.modal.create')


@push('js')


<script>
  @if (session('status'))

    Swal.fire({
      title:'Success',
      text: '{{ session('status') }}',
      icon: 'success'
    });
  @elseif (session('error'))
    Swal.fire({
      title: 'Error',
      text: '{{ session('error') }}',
      icon: 'error'
    });    

  @endif
</script>
  
@endpush


@endsection