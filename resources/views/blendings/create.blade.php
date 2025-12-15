@extends('layouts.app')

@section('content')
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-between">
                        <div class="col-md-6">
                            <h6 class="mt-2">
                                {{ __('BLENDINGS') }}
                            </h6>
                        </div>
                        <div class="col-md-6 text-end">
                            <a class="btn btn-danger btn-sm" href="{{ route('blendings.index') }}">
                                {{ __('VOLVER') }}
                            </a>
                        </div>
                    </div>
                </div>
           
                <div class="card-body">
        <form action="{{ route('blendings.store') }}" method="POST">
            @csrf
            <div class="d-flex align-items-center g-3">
                <div class="form-group col-md-3">
                    <label for="lista" class="text-muted">{{ __('PREPARACION BLENDING') }}</label>
                    <select name="lista" id="lista" class="form-control @error('lista') is-invalid @enderror">
                        <option value="">Seleccione tipo preparacion</option>
                        @foreach(['COBRE', 'COBRE TIPO 1', 'COBRE TIPO 2', 'PLATA', 'ORO','PLOMO','ZINC'] as $lista)
                            <option value="{{ $lista }}" {{ old('lista') == $lista ? 'selected' : '' }}>{{ $lista }}</option>
                        @endforeach
                    </select>
                    @error('lista')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-3 g-1">
                    <label for="cod" class="text-muted">CODIGO BLENDING</label>
                    <input type="text" name="cod" id="cod" class="form-control" required>
                </div>
                <div class="form-group col-md-6 g-1">
                    <label for="notas" class="text-muted">NOTAS</label>
                    <input type="text" name="notas" id="notas" class="form-control" >
                </div>
            </div>
            <div class="form-group col-md-12 g-1">
                <label for="search" class="text-muted">Buscar</label>
                <input type="text" id="search" class="form-control" placeholder="Buscar en la tabla">
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('Seleccionar') }}</th>
                            <th>{{ __('Fecha de Ingreso') }}</th>
                            <th>{{ __('Codigo') }}</th>
                            <th>{{ __('Cliente') }}</th>
                            <th>{{ __('Ubicacion') }}</th>
                            <th>{{ __('Ticket') }}</th>
                            <th>{{ __('Lote') }}</th>
                            <th>{{ __('Peso') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($ingresos->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">{{ __('No hay ingresos disponibles') }}</td>
                            </tr>
                        @else
                            @foreach($ingresos as $ingreso)
                            <tr>
                                <td>
                                    <input type="checkbox" class="peso-checkbox" data-peso="{{ $ingreso->peso_total }}" name="ingresos[]" value="{{ $ingreso->id }}">
                                </td>
                                <td>{{ $ingreso->fecha_ingreso }}</td>
                                <td>{{ $ingreso->codigo }}</td>
                                <td>{{ $ingreso->nom_iden }}</td>
                                <td>{{ $ingreso->lote }}</td>
                                <td>{{ $ingreso->NroSalida }}</td>
                                <td>{{ $ingreso->ref_lote }}</td>
                                <td>{{ $ingreso->peso_total }}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class='row'>
                <div class="form-group  col-md-3 g-1">
                    <label for="pesoTotal">{{ __('Peso Total Seleccionado') }}</label>
                    <input type="text" id="pesoTotal" class="form-control" readonly>
                </div>
                <div class="form-group col-md-3 g-1">
                    <label for="lote" class="text-muted">CAMPO</label>
                    <select name="lote" id="lote" class="form-control @error('lote') is-invalid @enderror" required>
                        <option value="">Seleccione un espacio...</option>
                        @for ($i = 1; $i <= 504; $i++)
                            @if (!in_array($i, $lotesRegistrados))
                                <option value="{{ $i }}" {{ old('lote') == $i ? 'selected' : '' }}>Seccion {{ $i }}</option>
                            @endif
                        @endfor
                    </select>
                    @error('lote')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

                <input type="hidden" name="pesoblending" id="pesoblending" value="0"> <!-- Campo oculto para almacenar el peso total -->
                
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
    
    document.querySelectorAll('.peso-checkbox').forEach(element => {
        element.addEventListener('change', updateTotalPeso);
    });

    function updateTotalPeso() {
        let total = 0;
        document.querySelectorAll('.peso-checkbox:checked').forEach(checkedCheckbox => {
            const peso = parseFloat(checkedCheckbox.getAttribute('data-peso'));
            total += peso;
        });
        document.getElementById('pesoTotal').value = total.toFixed(3); // Ajustar a dos decimales
        document.getElementById('pesoblending').value = total.toFixed(3); // Actualizar el campo oculto
    }
</script>
<script>
    // Escucha el evento de búsqueda
    document.getElementById('search').addEventListener('input', function() {
        let filter = this.value.toLowerCase();  // Obtener el texto de búsqueda en minúsculas
        let rows = document.querySelectorAll('table tbody tr');  // Obtener todas las filas de la tabla
        
        // Itera sobre cada fila de la tabla
        rows.forEach(row => {
            let cells = row.querySelectorAll('td');  // Obtener todas las celdas de la fila
            let match = false;
            
            // Itera sobre cada celda y verifica si el contenido coincide con el filtro
            cells.forEach(cell => {
                if (cell.textContent.toLowerCase().includes(filter)) {
                    match = true;  // Si alguna celda coincide, marcar la fila como coincidente
                }
            });

            // Mostrar u ocultar la fila dependiendo de si hay coincidencias
            row.style.display = match ? '' : 'none';
        });
    });
</script>

@endsection
