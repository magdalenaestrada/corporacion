@extends('layouts.app')


@push('css')

    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    


@endpush
    
@section('content')


<div class="container">
    <header>
      
    <h1 class="text-center">EMPLEADOS</h1>
    <div class="create-btn-container text-end">
      <a class="btn create-btn" href="#" data-toggle="modal" data-target="#ModalCreate">CREAR EMPLEADO</a>
    </div>
    </header>
    <br>
    <div class="responsive-table mt-5">

        <table class="table table-hover table-dark">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Documento</th>
                <th scope="col">Nombre</th>
                <th scope="col">Posición</th>
                <th scope="col">Área</th>
                <th scope="col">Fecha de Creación</th>          
              </tr>
            </thead>
            <tbody>
              @if (count($empleados)  > 0)
                @foreach ($empleados as $empleado)
                  <tr>
                    <th scope="row">{{$empleado->id}}</th>
                    <td>{{$empleado->documento}}</td>
                    <td>{{$empleado->nombre}}</td>
                    <td>
                    @if ($empleado->posicion)
                    {{$empleado->posicion->nombre}}
                    @else
                        N/A
                    @endif
                    </td>
                    <td>
                      @if ($empleado->area)
                      {{$empleado->area->nombre}}
                      @else
                          N/A
                      @endif
                      </td>
                    <td>{{$empleado->created_at}}</td>
                  </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="7" class="text-center">
                      {{ __('No hay datos disponibles...') }} 
                  </td>
                </tr>
              @endif
              
            </tbody>
        </table>


        <!-- Pagination Links -->
        <div class="d-flex justify-content-between">
          <div>
              {{ $empleados->links('pagination::bootstrap-4') }}
          </div>
          <div>
              Mostrando del {{ $empleados->firstItem() }} al {{ $empleados->lastItem() }} de {{ $empleados->total() }} registros
          </div>
      </div>
    
    
    
    </div>
</div>

@include('empleados.modal.create')


@push('js')


<script src="{{asset('js/apireniecsunat.js')}}"></script>
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