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
            <h5 class="mb-0">Crear Humedad</h5>
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

            <form action="{{ route('humedad.store') }}" method="POST">
                @csrf

                <div class="row g-2">
                    <div class="col-md-3">
                        <label class="text-muted">Mineral</label>
                        <select name="estado_mineral_id" class="form-control" required>
                            <option value="">Seleccione...</option>
                            @foreach($minerales as $m)
                                <option value="{{ $m->id }}" {{ old('estado_mineral_id')==$m->id?'selected':'' }}>
                                    {{ $m->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-5">
                        <label class="text-muted">Razón social</label>
                        <select name="cliente_id" class="form-control" required>
                            <option value="">Seleccione...</option>
                            @foreach($clientes as $c)
                                <option value="{{ $c->id }}" {{ old('cliente_id')==$c->id?'selected':'' }}>
                                    {{ $c->razon_social }}
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
                              value="{{ old('cliente_detalle') }}"
                              placeholder="">
                    </div>

                    <div class="col-md-1">
                        <label class="text-muted">Fecha recepción</label>
                        <input type="date" name="fecha_recepcion" class="form-control" value="{{ old('fecha_recepcion') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="text-muted">Fecha emisión</label>
                        <input type="date" name="fecha_emision" class="form-control" value="{{ old('fecha_emision') }}">
                    </div>
                </div>

                <div class="row g-2 mt-2">
                    <div class="col-md-2">
                        <label class="text-muted">Periodo inicio</label>
                        <input type="date" name="periodo_inicio" class="form-control" value="{{ old('periodo_inicio') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="text-muted">Periodo fin</label>
                        <input type="date" name="periodo_fin" class="form-control" value="{{ old('periodo_fin') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="text-muted">Humedad</label>
                        <input type="number" step="0.001" name="humedad" class="form-control" value="{{ old('humedad') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted">Observaciones</label>
                        <input type="text" name="observaciones" class="form-control" maxlength="500" value="{{ old('observaciones') }}">
                    </div>
                </div>

                <hr class="my-3">

                {{-- TOTAL GLOBAL --}}
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
                                <div class="col-6 col-md-2_4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="pesos_alfa[]"
                                               value="{{ $p->NroSalida }}"
                                               id="alfa_{{ $p->NroSalida }}"
                                               data-neto="{{ (int)$p->Neto }}"
                                               {{ in_array($p->NroSalida, old('pesos_alfa', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="alfa_{{ $p->NroSalida }}">
                                            {{ $p->NroSalida }} - Neto: {{ $p->Neto }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-2" id="alfaPager">
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
                                <div class="col-6 col-md-2_4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="pesos_kilate[]"
                                               value="{{ $p->NroSalida }}"
                                               id="kilate_{{ $p->NroSalida }}"
                                               data-neto="{{ (int)$p->Neto }}"
                                               {{ in_array($p->NroSalida, old('pesos_kilate', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kilate_{{ $p->NroSalida }}">
                                            {{ $p->NroSalida }} - Neto: {{ $p->Neto }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-2" id="kilatePager">
                            {{ $pesosKilate->links() }}
                        </div>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <button class="btn btn-primary">Guardar Humedad</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
  // =========================
  //  SUMA DE NETOS (A, K, TOTAL)
  // =========================
  const selectedAlfa = new Map();   // nroSalida -> neto
  const selectedKilate = new Map(); // nroSalida -> neto

  function formatInt(n){
    return new Intl.NumberFormat('es-PE').format(n);
  }

  function syncSelectedFromDOM(){
    document.querySelectorAll('input[name="pesos_alfa[]"]:checked').forEach(cb=>{
      selectedAlfa.set(cb.value, parseInt(cb.dataset.neto || '0', 10));
    });
    document.querySelectorAll('input[name="pesos_kilate[]"]:checked').forEach(cb=>{
      selectedKilate.set(cb.value, parseInt(cb.dataset.neto || '0', 10));
    });
  }

  function calcularTotales(){
    let sumA = 0, sumK = 0;
    selectedAlfa.forEach(v => sumA += v);
    selectedKilate.forEach(v => sumK += v);

    document.getElementById('totalNetoAlfa').textContent = formatInt(sumA);
    document.getElementById('totalNetoKilate').textContent = formatInt(sumK);
    document.getElementById('totalNetoGlobal').textContent = formatInt(sumA + sumK);
  }

  // Mantener mapas cuando check/uncheck
  document.addEventListener('change', function(e){
    if (e.target.matches('input[name="pesos_alfa[]"]')) {
      const nro = e.target.value;
      const neto = parseInt(e.target.dataset.neto || '0', 10);
      if (e.target.checked) selectedAlfa.set(nro, neto);
      else selectedAlfa.delete(nro);
      calcularTotales();
    }

    if (e.target.matches('input[name="pesos_kilate[]"]')) {
      const nro = e.target.value;
      const neto = parseInt(e.target.dataset.neto || '0', 10);
      if (e.target.checked) selectedKilate.set(nro, neto);
      else selectedKilate.delete(nro);
      calcularTotales();
    }
  });

  // Inicial (por si viene con old() chequeado)
  syncSelectedFromDOM();
  calcularTotales();


  // =========================
  //  BUSQUEDA REAL EN BD (AJAX)
  //  Requiere ruta: route('humedad.pesos.buscar')
  //  y método buscarPesos() en HumedadController
  // =========================

  function renderItems(origen, items){
    const isAlfa = origen === 'A';
    const listId = isAlfa ? 'alfaList' : 'kilateList';
    const name = isAlfa ? 'pesos_alfa[]' : 'pesos_kilate[]';
    const prefix = isAlfa ? 'alfa_' : 'kilate_';
    const selectedMap = isAlfa ? selectedAlfa : selectedKilate;

    const html = items.map(p => {
      const nro = p.NroSalida;
      const neto = parseInt(p.Neto || 0, 10);
      const checked = selectedMap.has(String(nro)) ? 'checked' : '';
      return `
        <div class="col-6 col-md-2_4 mb-2">
          <div class="form-check">
            <input class="form-check-input" type="checkbox"
              name="${name}" value="${nro}" id="${prefix}${nro}"
              data-neto="${neto}" ${checked}>
            <label class="form-check-label" for="${prefix}${nro}">
              ${nro} - Neto: ${neto}
            </label>
          </div>
        </div>
      `;
    }).join('');

    document.getElementById(listId).innerHTML = html;
  }

  function renderPager(origen, links){
    const isAlfa = origen === 'A';
    const pagerId = isAlfa ? 'alfaPager' : 'kilatePager';

    const current = links.current_page;
    const last = links.last_page;

    const prevDisabled = !links.prev_page_url ? 'disabled' : '';
    const nextDisabled = !links.next_page_url ? 'disabled' : '';

    let buttons = '';
    const start = Math.max(1, current - 2);
    const end   = Math.min(last, current + 2);

    buttons += `<li class="page-item ${prevDisabled}">
      <a class="page-link" href="#" data-page="${current-1}" data-origen="${origen}">Anterior</a>
    </li>`;

    for(let i=start; i<=end; i++){
      buttons += `<li class="page-item ${i===current?'active':''}">
        <a class="page-link" href="#" data-page="${i}" data-origen="${origen}">${i}</a>
      </li>`;
    }

    buttons += `<li class="page-item ${nextDisabled}">
      <a class="page-link" href="#" data-page="${current+1}" data-origen="${origen}">Siguiente</a>
    </li>`;

    document.getElementById(pagerId).innerHTML = `<ul class="pagination">${buttons}</ul>`;
  }

  async function buscar(origen, q, page=1){
    // guardar selecciones actuales antes de reemplazar
    syncSelectedFromDOM();

    const url = new URL("{{ route('humedad.pesos.buscar') }}", window.location.origin);
    url.searchParams.set('origen', origen);
    url.searchParams.set('q', (q || '').trim());
    url.searchParams.set('page', page);

    const res = await fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
    const json = await res.json();

    renderItems(origen, json.data);
    renderPager(origen, json.links);

    // recalcular totales luego de render
    calcularTotales();
  }

  // Debounce buscadores
  let t1=null, t2=null;

  document.getElementById('searchAlfa').addEventListener('input', function(){
    clearTimeout(t1);
    const q = this.value;
    t1 = setTimeout(()=> buscar('A', q, 1), 250);
  });

  document.getElementById('searchKilate').addEventListener('input', function(){
    clearTimeout(t2);
    const q = this.value;
    t2 = setTimeout(()=> buscar('K', q, 1), 250);
  });

  // Pager click (ambos)
  document.addEventListener('click', function(e){
    const a = e.target.closest('a.page-link[data-page][data-origen]');
    if (!a) return;
    e.preventDefault();

    const page = parseInt(a.dataset.page, 10);
    const origen = a.dataset.origen;
    if (page < 1) return;

    const q = (origen === 'A')
      ? document.getElementById('searchAlfa').value
      : document.getElementById('searchKilate').value;

    buscar(origen, q, page);
  });
</script>
@endsection
<script>
  // =========================
  //  ANTI DOBLE ENVIO (LENTO INTERNET)
  // =========================
  (function () {
    const form = document.getElementById('humedadForm');
    const btn  = document.getElementById('btnGuardar');
    if (!form || !btn) return;

    let submitted = false;

    form.addEventListener('submit', function () {
      if (submitted) return; // si ya se envió, no hacer nada
      submitted = true;

      // deshabilitar botón + evitar doble click
      btn.disabled = true;
      btn.innerHTML = 'Guardando...';

      // deshabilitar todos los inputs para que no cambien durante el envío
      form.querySelectorAll('input, select, textarea, button').forEach(el => {
        if (el !== btn) el.readOnly = true;
        el.disabled = true;
      });

      // permitir que el submit siga
    });
  })();
</script>