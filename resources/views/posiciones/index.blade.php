@extends('layouts.app')


@push('css')

    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    


@endpush
    
@section('content')


<div class="container">
    <header>
      
    <h1 class="text-center">POSICIONES</h1>
    <div class="create-btn-container text-end">
      <a class="btn create-btn" href="#" data-toggle="modal" data-target="#ModalCreate">CREAR POSICIÓN</a>
    </div>
    </header>
    <br>
    <div class="responsive-table mt-5">

        <table class="table table-hover table-dark">
            <thead>
              <tr>
                <th scope="col">{{__('#')}}</th>
                <th scope="col">{{__('Nombre')}}</th>
                <th scope="col">{{__('Fecha de Creación')}}</th>   
                <th scope="col">{{__('Acción')}}</th>       
              </tr>
            </thead>
            <tbody>
              @if (count($posiciones)  > 0)
                @foreach ($posiciones as $posicion)
                  <tr>
                    <th scope="row">{{$posicion->id}}</th>
                    <td>{{$posicion->nombre}}</td>
                    <td>{{$posicion->created_at}}</td>
                    <td>

                     



                    </td>
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
    
    
    
    </div>
</div>

@include('posiciones.modal.create')


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