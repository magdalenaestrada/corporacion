@extends('layouts.app')

@push('css')
    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container">
    <header>
        <h1 class="text-center">ACTIVOS</h1>
        <div class="create-btn-container text-end">
            <a class="btn create-btn" href="#" data-toggle="modal" data-target="#ModalCreate">CREAR ACTIVO</a>
        </div>
    </header>
    <br>
    <div class="responsive-table mt-5">
        <table class="table table-hover table-dark text-center">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Imei</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Área</th>
                    <th scope="col">Responsable</th>
                    <th scope="col">Fecha de Creación</th>     
                    <th scope="col">{{ __('Acción') }}</th>     
                </tr>
            </thead>
            <tbody>
                @if (count($activos) > 0)
                    @foreach ($activos as $activo)
                        <tr>
                            <th scope="row">{{ $activo->id }}</th>
                            <td>{{ $activo->nombre }}</td>
                            <td>{{ $activo->imei ?: 'N/A' }}</td>
                            <td>{{ $activo->categoria ? $activo->categoria->nombre : 'N/A' }}</td>
                            <td>{{ $activo->valor }}</td>
                            <td>{{ $activo->empleado && $activo->empleado->area ? $activo->empleado->area->nombre : 'N/A' }}</td>
                            <td>{{ $activo->empleado ? $activo->empleado->nombre : 'N/A' }}</td>
                            <td>{{ $activo->created_at }}</td>
                            <td>
                                <div class="show-btn-conteiner">
                                    <a href="{{ route('acactivos.show', $activo->id) }}" class="show-btn-content">
                                        <span class="icon-arrow">
                                            <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 66 43" height="25px" width="25px">
                                                <g fill-rule="evenodd" fill="none" stroke-width="1" stroke="none" id="arrow">
                                                    <path fill="#9ee5fa" d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z"></path>
                                                </g>
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                                <a>
                                    <!-- Icon SVG here -->
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9" class="text-center">
                            {{ __('No hay datos disponibles') }} 
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-between">
            <div>
                {{ $activos->links('pagination::bootstrap-4') }}
            </div>
            <div>
                Mostrando del {{ $activos->firstItem() }} al {{ $activos->lastItem() }} de {{ $activos->total() }} registros
            </div>
        </div>
    </div>
</div>

@include('acactivos.modal.create')

@push('js')
<script>
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
</script>
@endpush

@endsection
