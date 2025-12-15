@extends('layouts.app')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
  body{background:#132436}
  .dash-wrap{max-width:1200px;margin:0 auto;padding:18px}
  .title{color:#fff;text-align:center;margin-bottom:10px}
  .btn-row{display:flex;flex-wrap:wrap;gap:.75rem;justify-content:center;margin-bottom:16px}
  .btn-pill{border-radius:999px;padding:.5rem .9rem;font-weight:600;display:inline-flex;align-items:center;gap:.5rem;border:1px solid transparent}
  .btn-pill i{font-size:14px}
  .btn-liq{background:#193a2c;color:#27d17f;border-color:#27d17f}
  .btn-ing{background:#092e4a;color:#44a7ff;border-color:#44a7ff}
  .btn-bl{background:#3a2a00;color:#ffc107;border-color:#ffc107}
  .btn-desp{background:#0f2b33;color:#23c6d1;border-color:#23c6d1}
  .btn-flujo{background:#002a67;color:#2ea1ff;border-color:#2ea1ff}

  .kpi-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(230px,1fr));gap:12px;margin-top:6px}
  .kpi{background:#0f2234;border-radius:12px;padding:12px;color:#e9f0f5;box-shadow:0 2px 10px rgba(0,0,0,.15)}
  .kpi small{color:#9bb0bf}
  .kpi h3{margin:.25rem 0 0;font-weight:800}

  .bar{background:#0f2234;border-radius:12px;padding:10px;box-shadow:0 2px 10px rgba(0,0,0,.15)}
  .bar h6{color:#cfe3f5;margin:0 0 6px;text-align:center}

  .grid-3{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:14px;margin-top:12px}
  .filters{display:flex;justify-content:center;gap:10px;margin:10px 0}
  .input-chip{padding:6px 10px;border-radius:8px;border:1px solid #3e5b74;background:#0f2234;color:#e8f1f7}
  .chip{display:inline-flex;gap:6px;align-items:center;border-radius:999px;padding:2px 8px;font-size:12px;margin-left:6px}
  .chip-g{background:#1f513a;color:#9ff0c7}
  .chip-s{background:#4d4608;color:#ffe178}
  .chip-c{background:#233f86;color:#99b9ff}
</style>
@endpush

@section('content')
<div class="dash-wrap">
  <h2 class="title"><i class="fa-solid fa-chart-column"></i> Dashboard General de Reportes</h2>

  <!-- Botones -->
  <div class="btn-row">
    <a class="btn-pill btn-liq" href="{{ route('reportes.liq') }}"><i class="fa-solid fa-file-invoice-dollar"></i> Liquidaciones</a>
    <a class="btn-pill btn-ing" href="{{ route('reportes.loza') }}"><i class="fa-solid fa-warehouse"></i> Ingresos</a>
    <a class="btn-pill btn-bl" href="{{ route('reportes.blendings') }}"><i class="fa-solid fa-flask"></i> Blendings</a>
    <a class="btn-pill btn-desp" href="{{ route('reportes.despachos') }}"><i class="fa-solid fa-truck"></i> Despachos</a>
    <a class="btn-pill btn-flujo" href="{{ route('reportes.flujos') }}"><i class="fa-solid fa-diagram-project"></i> Flujo</a>
  </div>

  <!-- Filtros -->
  <div class="filters">
    <input id="rangoFechas" class="input-chip" placeholder="📅 Rango (opcional)" readonly>
    <button id="btnAplicar" class="input-chip" style="cursor:pointer;">Aplicar</button>
    <button id="btnLimpiar" class="input-chip" style="cursor:pointer;">Limpiar</button>
  </div>

  <!-- KPIs -->
  <div class="kpi-grid">
    <div class="kpi">
      <small>Ingresos (conteo)</small>
      <h3 id="kpiIngresos">0</h3>
      <small>TMH Stock = Ingresado + Blending <span id="chipStock" class="chip chip-c">0.000 TMH</span></small>
    </div>
    <div class="kpi">
      <small>Blendings (conteo)</small>
      <h3 id="kpiBlendings">0</h3>
      <small>Mezcla:
        <span class="chip chip-g" id="chipOro">Oro 0%</span>
        <span class="chip chip-s" id="chipPlata">Plata 0%</span>
        <span class="chip chip-c" id="chipCobre">Cobre 0%</span>
      </small>
    </div>
    <div class="kpi">
      <small>Despachos (conteo)</small>
      <h3 id="kpiDespachos">0</h3>
      <small>Top destino: <span id="kpiTopDestino">—</span></small>
    </div>
  </div>

  <!-- Gráficos -->
  <div class="grid-3">
    <div class="bar">
      <h6>🧪 Mezcla de Blendings por Lista (TMH)</h6>
      <canvas id="chBlendMix" height="170"></canvas>
    </div>
    <div class="bar">
      <h6>📦 Ingresos – TMH por Producto</h6>
      <canvas id="chIngProducto" height="170"></canvas>
    </div>
    <div class="bar">
      <h6>🚚 Despachos – TMH por Destino (Top 5)</h6>
      <canvas id="chDespDestino" height="170"></canvas>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
let C1=null,C2=null,C3=null;

function safeDestroy(ch){ if(ch && typeof ch.destroy==='function'){ ch.destroy(); } }

function pct(value,total){ return total>0 ? Math.round((value/total)*100) : 0; }

async function loadResumen(){
  const val = document.getElementById('rangoFechas').value.trim();
  let params='';
  if(val){
    const parts = val.split(' a ');
    if(parts.length===2){
      params = `?desde=${encodeURIComponent(parts[0])}&hasta=${encodeURIComponent(parts[1])}`;
    }
  }

  const res = await fetch(`{{ route('reportes.resumen') }}${params}`, {headers:{'X-Requested-With':'XMLHttpRequest'}});
  if(!res.ok){
    const t = await res.text();
    console.error('Resumen error', res.status, t);
    alert('No se pudo cargar el resumen ('+res.status+'). Revisa permisos/sesión.');
    return;
  }
  const data = await res.json();
  renderKPIs(data);
  renderCharts(data);
}

function renderKPIs(d){
  // Totales
  document.getElementById('kpiIngresos').textContent  = Number(d.total_ingresos||0);
  document.getElementById('kpiBlendings').textContent = Number(d.total_blendings||0);
  document.getElementById('kpiDespachos').textContent = Number(d.total_despachos||0);

  // Stock (ingresado + blending)
  const tmhFase = d.ingresos_tmh_por_fase || {};
  const stock = Number(tmhFase['ingresado']||0) + Number(tmhFase['blending']||0);
  document.getElementById('chipStock').textContent = (stock||0).toFixed(3)+' TMH';

  // Porcentajes de mezcla (TMH por lista)
  const mix = d.blendings_tmh_por_lista || {};
  const totalMix = Object.values(mix).reduce((a,b)=>a+Number(b||0),0);
  const pOro   = pct(Number(mix['oro']||0), totalMix);
  const pPlata = pct(Number(mix['plata']||0), totalMix);
  const pCobre = pct(Number(mix['cobre']||0), totalMix);
  document.getElementById('chipOro').textContent   = `Oro ${pOro}%`;
  document.getElementById('chipPlata').textContent = `Plata ${pPlata}%`;
  document.getElementById('chipCobre').textContent = `Cobre ${pCobre}%`;

  // Top destino
  const destinos = Array.isArray(d.destinos_top) ? d.destinos_top : [];
  const top = destinos[0]?.destino || '—';
  document.getElementById('kpiTopDestino').textContent = top;
}

function renderCharts(d){
  // Mezcla de blendings (TMH)
  const mix = d.blendings_tmh_por_lista || {};
  const labelsMix = Object.keys(mix).map(x=>x.toUpperCase());
  const dataMix   = Object.keys(mix).map(k=>Number(mix[k]||0));
  safeDestroy(C1);
  C1 = new Chart(document.getElementById('chBlendMix'), {
    type:'doughnut',
    data:{ labels:labelsMix, datasets:[{ data:dataMix }] },
    options:{ plugins:{legend:{position:'bottom'}}, responsive:true }
  });

  // TMH por producto (Ingresos)
  const byProd = d.ingresos_tmh_por_producto || {};
  const lProd  = Object.keys(byProd).map(x=>x.toUpperCase());
  const vProd  = Object.keys(byProd).map(k=>Number(byProd[k]||0));
  safeDestroy(C2);
  C2 = new Chart(document.getElementById('chIngProducto'), {
    type:'bar',
    data:{ labels:lProd, datasets:[{ label:'TMH', data:vProd }] },
    options:{ scales:{ y:{ beginAtZero:true }}, plugins:{legend:{display:false}}, responsive:true }
  });

  // TMH por destino (Top 5)
  const destinos = Array.isArray(d.destinos_top) ? d.destinos_top : [];
  const lDest = destinos.map(x=>x.destino);
  const vDest = destinos.map(x=>Number(x.tmh||0));
  safeDestroy(C3);
  C3 = new Chart(document.getElementById('chDespDestino'), {
    type:'bar',
    data:{ labels:lDest, datasets:[{ label:'TMH', data:vDest }] },
    options:{ scales:{ y:{ beginAtZero:true }}, plugins:{legend:{display:false}}, responsive:true }
  });
}

document.addEventListener('DOMContentLoaded', ()=>{
  flatpickr('#rangoFechas', {mode:'range', dateFormat:'Y-m-d', locale:'es'});
  document.getElementById('btnAplicar').addEventListener('click', loadResumen);
  document.getElementById('btnLimpiar').addEventListener('click', ()=>{ document.getElementById('rangoFechas').value=''; loadResumen(); });
  loadResumen();
});
</script>
@endpush
