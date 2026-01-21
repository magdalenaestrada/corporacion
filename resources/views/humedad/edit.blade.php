@extends('layouts.app')

@section('content')
<style>
    @media (min-width: 768px) {
        .col-md-2_4 { flex: 0 0 20%; max-width: 20%; }
    }
</style>

<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Editar Humedad #{{ $humedad->id }}</h5>
            <a href="{{ route('humedad.index') }}" class="btn btn-danger btn-sm">Volver</a>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form id="humedadForm" action="{{ route('humedad.update', $humedad->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-2">
                    <div class="col-md-3">
                        <label class="text-muted">Mineral</label>
                        <select name="estado_mineral_id" class="form-control" required>
                            <option value="">Seleccione...</option>
                            @foreach($minerales as $m)
                                <option value="{{ $m->id }}" {{ old('estado_mineral_id', $humedad->estado_mineral_id)==$m->id?'selected':'' }}>
                                    {{ $m->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-1">
                        <label class="text-muted">Lote</label>
                        <input type="text"
                            name="cliente_detalle"
                            class="form-control"
                            maxlength="50"
                            value="{{ old('cliente_detalle', $humedad->cliente_detalle) }}"
                            placeholder="">
                    </div>

                    <div class="col-md-5">
                        <label class="text-muted">Razón social</label>
                        <select name="cliente_id" class="form-control" required>
                            <option value="">Seleccione...</option>
                            @foreach($clientes as $c)
                                <option value="{{ $c->id }}" {{ old('cliente_id', $humedad->cliente_id)==$c->id?'selected':'' }}>
                                    {{ $c->razon_social }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="text-muted">Fecha recepción</label>
                        <input type="date" name="fecha_recepcion" class="form-control"
                               value="{{ old('fecha_recepcion', optional($humedad->fecha_recepcion)->format('Y-m-d')) }}">
                    </div>

                    <div class="col-md-2">
                        <label class="text-muted">Fecha emisión</label>
                        <input type="date" name="fecha_emision" class="form-control"
                               value="{{ old('fecha_emision', optional($humedad->fecha_emision)->format('Y-m-d')) }}">
                    </div>
                </div>

                <div class="row g-2 mt-2">
                    <div class="col-md-2">
                        <label class="text-muted">Periodo inicio</label>
                        <input type="date" name="periodo_inicio" class="form-control"
                               value="{{ old('periodo_inicio', optional($humedad->periodo_inicio)->format('Y-m-d')) }}">
                    </div>

                    <div class="col-md-2">
                        <label class="text-muted">Periodo fin</label>
                        <input type="date" name="periodo_fin" class="form-control"
                               value="{{ old('periodo_fin', optional($humedad->periodo_fin)->format('Y-m-d')) }}">
                    </div>

                    <div class="col-md-2">
                        <label class="text-muted">Humedad</label>
                        <input type="number" step="0.01" name="humedad" class="form-control"
                               value="{{ old('humedad', $humedad->humedad) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted">Observaciones</label>
                        <input type="text" name="observaciones" class="form-control" maxlength="500"
                               value="{{ old('observaciones', $humedad->observaciones) }}">
                    </div>
                </div>

                <hr class="my-3">

                {{-- Mensaje específico si no selecciona tickets --}}
                @if($errors->has('pesos'))
                    <div class="alert alert-danger">{{ $errors->first('pesos') }}</div>
                @endif

                {{-- TOTAL GLOBAL (dinámico) --}}
                <div class="text-center mb-3">
                    <span class="badge bg-primary" style="font-size: 14px;">
                        TOTAL NETO: <span id="totalNetoGlobal">0</span>
                    </span>
                </div>

                <div class="row">
                    {{-- ALFA --}}
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Seleccionar Pesos ALFA (A)</h6>
                            <span class="badge bg-dark">
                                Total Neto ALFA: <span id="totalNetoAlfa">0</span>
                            </span>
                        </div>

                        <input type="text" id="searchAlfa" class="form-control mt-2 mb-2" placeholder="Buscar ticket...">

                        <div id="alfaList" class="row">
                            @foreach($pesosAlfa as $p)
                                @php
                                    $oldA = old('pesos_alfa', $selectedAlfa ?? []);
                                    $isChecked = in_array((string)$p->NroSalida, array_map('strval', (array)$oldA), true);
                                @endphp
                                <div class="col-6 col-md-2_4 mb-2 alfa-item" data-nro="{{ $p->NroSalida }}">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                            type="checkbox"
                                            name="pesos_alfa[]"
                                            value="{{ $p->NroSalida }}"
                                            id="alfa_{{ $p->NroSalida }}"
                                            data-neto="{{ (int)$p->Neto }}"
                                            {{ $isChecked ? 'checked' : '' }}>
                                        <label class="form-check-label" for="alfa_{{ $p->NroSalida }}">
                                            {{ $p->NroSalida }} - Neto: {{ $p->Neto }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-2">
                            {{ $pesosAlfa->links() }}
                        </div>
                    </div>

                    {{-- KILATE --}}
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Seleccionar Pesos KILATE (K)</h6>
                            <span class="badge bg-dark">
                                Total Neto KILATE: <span id="totalNetoKilate">0</span>
                            </span>
                        </div>

                        <input type="text" id="searchKilate" class="form-control mt-2 mb-2" placeholder="Buscar ticket...">

                        <div id="kilateList" class="row">
                            @foreach($pesosKilate as $p)
                                @php
                                    $oldK = old('pesos_kilate', $selectedKilate ?? []);
                                    $isChecked = in_array((string)$p->NroSalida, array_map('strval', (array)$oldK), true);
                                @endphp
                                <div class="col-6 col-md-2_4 mb-2 kilate-item" data-nro="{{ $p->NroSalida }}">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                            type="checkbox"
                                            name="pesos_kilate[]"
                                            value="{{ $p->NroSalida }}"
                                            id="kilate_{{ $p->NroSalida }}"
                                            data-neto="{{ (int)$p->Neto }}"
                                            {{ $isChecked ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kilate_{{ $p->NroSalida }}">
                                            {{ $p->NroSalida }} - Neto: {{ $p->Neto }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-2">
                            {{ $pesosKilate->links() }}
                        </div>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <button id="btnGuardar" class="btn btn-primary" type="submit">Actualizar Humedad</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
  // =========================
  //  TOTALES DINÁMICOS (A, K, TOTAL)
  // =========================
  function formatInt(n){
    return new Intl.NumberFormat('es-PE').format(n);
  }

  function calcularTotales(){
    let sumA = 0, sumK = 0;

    document.querySelectorAll('input[name="pesos_alfa[]"]:checked').forEach(cb=>{
      sumA += parseInt(cb.dataset.neto || '0', 10);
    });
    document.querySelectorAll('input[name="pesos_kilate[]"]:checked').forEach(cb=>{
      sumK += parseInt(cb.dataset.neto || '0', 10);
    });

    document.getElementById('totalNetoAlfa').textContent   = formatInt(sumA);
    document.getElementById('totalNetoKilate').textContent = formatInt(sumK);
    document.getElementById('totalNetoGlobal').textContent = formatInt(sumA + sumK);
  }

  document.addEventListener('change', function(e){
    if (e.target.matches('input[name="pesos_alfa[]"], input[name="pesos_kilate[]"]')) {
      calcularTotales();
    }
  });

  // Inicial
  calcularTotales();

  // =========================
  //  FILTRO EN PANTALLA (NO AJAX)
  // =========================
  const searchAlfa = document.getElementById('searchAlfa');
  const searchKilate = document.getElementById('searchKilate');

  if (searchAlfa) {
    searchAlfa.addEventListener('input', function(){
      const q = this.value.trim();
      document.querySelectorAll('.alfa-item').forEach(el=>{
        const nro = el.dataset.nro || '';
        el.style.display = nro.includes(q) ? '' : 'none';
      });
    });
  }

  if (searchKilate) {
    searchKilate.addEventListener('input', function(){
      const q = this.value.trim();
      document.querySelectorAll('.kilate-item').forEach(el=>{
        const nro = el.dataset.nro || '';
        el.style.display = nro.includes(q) ? '' : 'none';
      });
    });
  }

  // =========================
  //  ANTI DOBLE ENVIO + MINIMO 1 TICKET
  // =========================
  (function () {
    const form = document.getElementById('humedadForm');
    const btn  = document.getElementById('btnGuardar');
    if (!form || !btn) return;

    let submitted = false;

    function haySeleccion() {
      const a = document.querySelectorAll('input[name="pesos_alfa[]"]:checked').length;
      const k = document.querySelectorAll('input[name="pesos_kilate[]"]:checked').length;
      return (a + k) >= 1;
    }

    form.addEventListener('submit', function (e) {
      if (!haySeleccion()) {
        e.preventDefault();
        alert('Debes seleccionar al menos 1 ticket (ALFA o KILATE).');
        return;
      }

      if (submitted) { e.preventDefault(); return; }
      submitted = true;

      btn.disabled = true;
      btn.innerHTML = 'Actualizando...';
    });
  })();
</script>
@endsection
