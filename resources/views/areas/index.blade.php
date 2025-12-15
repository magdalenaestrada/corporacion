@extends('layouts.app')


@push('css')

    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    


@endpush
    
@section('content')


<div class="container">
    <header>
      
    <h1 class="text-center">ÁREAS</h1>
    <div class="create-btn-container text-end">
      <a class="btn create-btn" href="#" data-toggle="modal" data-target="#ModalCreate">CREAR ÁREA</a>
    </div>
    </header>
    <br>
    <div class="responsive-table mt-5">

        <table class="table table-hover table-dark">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Fecha de Creación</th>          
              </tr>
            </thead>
            <tbody>
              @if (count($areas)  > 0)
                @foreach ($areas as $area)
                  <tr>
                    <th scope="row">{{$area->id}}</th>
                    <td>{{$area->nombre}}</td>
                    <td>{{$area->created_at}}</td>
                  </tr>
                @endforeach
                  
              @else
                <tr>
                  <td colspan="4" class="text-center">
                      {{ __('No hay datos disponibles...') }} 
                  </td>
                </tr>
              @endif
              
            </tbody>
        </table>
    
    
    
    </div>
</div>

@include('areas.modal.create')


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