@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('TODOS LOS DESPACHOS REGISTRADOS') }}
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>TMH</th>
                                <th>Falta (-) y Excede (+)</th>
                                <th>Deposito</th>
                                <th>Destino</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($despachos as $despacho)
                                <tr>
                                    <td>{{ $despacho->fecha }}</td>
                                    <td>{{ $despacho->id }}</td>
                                   <td>{{ optional($despacho->blending)->cod ?? 'Sin blending' }}</td>
                                    <td>{{ $despacho->totalTMH }}</td>
                                    <td>{{ $despacho->masomenos }}</td>
                                    <td>{{ $despacho->deposito }}</td>
                                    <td>{{ $despacho->destino }}</td>
                                    <td>
                                        <a href="{{ route('despachos.show', $despacho->id) }}" class="btn btn-secondary btn-sm">Ver</a>
                                        <a href="{{ route('despachos.edit', $despacho->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        @if($despacho->retiros->count() > 0) 
                                        @php
                                            $pendientes = $despacho->retiros->whereNull('recepcion')->count();
                                        @endphp
                                
                                        <a href="{{ route('despachos.retiros', $despacho->id) }}" 
                                           class="btn btn-sm {{ $pendientes > 0 ? 'btn-info' : 'btn-success' }}">
                                            {{ $pendientes > 0 ? 'Retiros' : 'Recepcionados' }}
                                        </a>
                                    @endif
                                        <!-- Botón de eliminar con SweetAlert2 -->
                                        <form action="{{ route('despachos.destroy', $despacho->id) }}" method="POST" class="delete-form" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm delete-btn">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">{{ __('No hay despachos disponibles') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", function() {
                let form = this.closest(".delete-form");

                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "¡Esta acción no se puede deshacer!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Enviar el formulario si se confirma
                    }
                });
            });
        });
    });
</script>
@endpush

@endsection
