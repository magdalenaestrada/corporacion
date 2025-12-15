@extends('layouts.app')
@push('css')
    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
@endpush
@section('content')
<div class="container">
    <header>
        <h1 class="text-center">CATEGORÍAS</h1>
        <div class="create-btn-container text-end">
            <a class="btn create-btn" href="#" data-toggle="modal" data-target="#ModalCreate">CREAR CATEGORÍA</a>
        </div>
    </header>
    <br>
    <div class="responsive-table mt-5">
        <table class="table table-hover table-dark">
            <thead>
                <tr>
                    <th scope="col" class="hidden">#</th>
                    <th scope="col">Código</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Categoría Padre</th>
                    <th scope="col">Fecha de Creación</th>          
                </tr>
            </thead>
            <tbody>
                @if (count($categorias) > 0)
                    @foreach ($categorias as $categoria)
                        @include('accategorias.partials.category_row', ['categoria' => $categoria, 'level' => 0])
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center">{{ __('No hay datos disponibles...') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-between">
            <div>{{ $categorias->links('pagination::bootstrap-4') }}</div>
            <div>Mostrando del {{ $categorias->firstItem() }} al {{ $categorias->lastItem() }} de {{ $categorias->total() }} registros</div>
        </div>
    </div>
</div>
@include('accategorias.modal.create')
@push('js')
<script src="{{ asset('js/apireniecsunat.js') }}"></script>
<script>
    $(document).ready(function() {
      // Toggle subcategories on click
      $('.category-row').click(function() {
        close_open_toggle($(this));
      });
  
      function close_open_toggle(element) {
        var id = element.closest('tr').data('id');
        var subcategories = $('tr[data-parent-id="' + id + '"]');
        subcategories.toggle(); // Toggle visibility of subcategories
  
        // If hiding, also hide all descendants
        if (!subcategories.is(':visible')) {
          subcategories.each(function() {
            hide_all_descendants($(this));
          });
        }
      }
  
      function hide_all_descendants(element) {
        var id = element.closest('tr').data('id');
        var subcategories = $('tr[data-parent-id="' + id + '"]');
        subcategories.hide(); // Hide subcategories
        subcategories.each(function() {
          hide_all_descendants($(this)); // Recursively hide all descendants
        });
      }
  
      // Initialize by hiding all subcategories
      $('.category-row').each(function() {
        hide_all_descendants($(this));
      });
  
      @if (session('status'))
        Swal.fire({
          title: 'Success',
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
    });
  </script>
  
@endpush
@endsection
