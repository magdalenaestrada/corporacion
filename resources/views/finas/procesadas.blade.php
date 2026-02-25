@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        {{ __('TODAS LAS OPERACIONES REGISTRADAS') }}
                        <a class="btn btn-sm btn-secondary" href="{{ route('finas.index') }}">
                            {{ __('CREAR NUEVO BLENDING') }}
                        </a>
                    </div>
                    <div class="card-body">


                        <table class="table table-striped table-hover text-center mb-0">
                            @if (count($finas) > 0)
                                <thead>
                                    <div class="mb-3">
    <input type="text" id="searchInput" class="form-control"
           placeholder="Buscar por ID, código, ticket, estado...">
</div>
                                    <tr>
                                        <th scope="col">{{ __('ID') }}</th>
                                        <th scope="col">{{ __('CODIGO BLENDING') }}</th>
                                        <th scope="col">{{ __('NRO TICKET') }}</th>
                                        <th scope="col">{{ __('TOTAL TMH') }}</th>
                                        <th scope="col">{{ __('PORCENTAJE H2O') }}</th>
                                        <th scope="col">{{ __('TOTAL TMS') }}</th>
                                        <th scope="col">{{ __('CU PROMEDIO') }}</th>
                                        <th scope="col">{{ __('AG PROMEDIO') }}</th>
                                        <th scope="col">{{ __('AU PROMEDIO') }}</th>
                                        <th scope="col">{{ __('ESTADO') }}</th>
                                        <th scope="col">{{ __('ACCIONES') }}</th>
                                    </tr>
                                </thead>
                                                                <tbody>
                                                                    @foreach ($finas as $fina)
                                                                    <tr>
                                                                        <td>{{ $fina->id }}</td>
                                                                        <td>{{ $fina->codigoBlending }}</td>
                                                                       <td>
                                                                    @if(!empty($fina->tickets_list) && count($fina->tickets_list))
                                                                        @foreach($fina->tickets_list as $t)
                                                                            <span class="badge bg-secondary me-1 mb-1">{{ $t }}</span>
                                                                        @endforeach
                                                                    @else
                                                                        <span class="text-muted">Sin tickets</span>
                                                                    @endif
                                                                </td>
                                        <td>{{ $fina->total_tmh }}</td>
                                        <td>{{ $fina->porcentaje_h2o }}</td>
                                        <td>{{ $fina->total_tms }}</td>
                                        <td>{{ number_format($fina->cu_promedio, 3) }}</td>
                                        <td>{{ number_format($fina->ag_promedio, 3) }}</td>
                                        <td>{{ number_format($fina->au_promedio, 3) }}</td>
                                        
                                        <td>{{ $fina->estado ?? 'PROVISIONAL' }}</td>
                                        <td>
                                            <a href="{{ route('finas.show', $fina->id) }}" class="btn btn-secondary btn-sm">{{ __('VER') }}</a>
                                            <a href="{{ route('finas.edit', $fina->id) }}" class="btn btn-warning btn-sm">{{ __('EDITAR') }}</a>
                                            <a href="{{ route('fina.print', $fina->id) }}" class="btn btn-primary btn-sm" target="_blank">
                                                 🖨️IMPRIMIR
                                            </a>
                                            <form action="{{ route('finas.destroy', $fina->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">{{ __('ELIMINAR') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            @else
                                <tr>
                                    <td colspan="17" class="text-center text-muted">{{ __('No hay datos disponibles') }}</td>
                                </tr>
                            @endif
                        </table>

                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                <li class="page-item {{ $finas->currentPage() == 1 ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $finas->previousPageUrl() ?: '#' }}">{{ __('Anterior') }}</a>
                                </li>
                                @for ($i = 1; $i <= $finas->lastPage(); $i++)
                                    <li class="page-item {{ $finas->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $finas->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ !$finas->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $finas->nextPageUrl() ?: '#' }}">{{ __('Siguiente') }}</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
.table td .badge {
    font-size: 11px;
    margin: 2px;
    display: inline-block;
    white-space: nowrap;
}
</style>
@push('js')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('searchInput');
    const rows = document.querySelectorAll('table tbody tr');

    input.addEventListener('keyup', () => {
        const q = input.value.toLowerCase();
        rows.forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(q)
                ? ''
                : 'none';
        });
    });
});
</script>
@endpush