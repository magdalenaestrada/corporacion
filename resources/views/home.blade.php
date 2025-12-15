@extends('layouts.app')

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
@endpush

@section('content')
<style>
    body { background-color: #f0f4f8; }

    /* Página más angosta y compacta */
    .dashboard-wrap { max-width: 1200px; margin: 0 auto; }

    .dashboard-container{
        position: relative;
        background: linear-gradient(145deg,#ffffff,#f8f9fa);
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0,0,0,.06);
        padding: 1rem; /* ↓ antes 1.5rem */
    }
    .dashboard-watermark{
        position:absolute;top:50%;left:50%;
        transform:translate(-50%,-50%);opacity:.035;max-width:80%;z-index:0;
    }
    .dashboard-content{ position:relative; z-index:1; }
    .dashboard-content h1{
        font-size:1.3rem; /* ↓ */
        font-weight:700;color:#212529;text-align:center;margin-bottom:.25rem;
    }
    .dashboard-content p{
        color:#6c757d;font-size:.85rem; /* ↓ */
        text-align:center;margin-bottom:.6rem; /* ↓ */
    }

    /* ===== Un solo cajón de KPIs ===== */
    .kpi-card-wrap{border-radius:12px;box-shadow:0 3px 12px rgba(0,0,0,.06);background:#fff}
    .kpi-head{display:flex;justify-content:space-between;align-items:center}
    .kpi-head h5{margin:0;font-weight:700}
    .kpi-head small{color:#6c757d}
    .kpi-hr{margin:.6rem 0 .8rem;border:none;border-top:1px solid #e9ecef}

    .kpi-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:.75rem}
    .kpi-box{
        display:flex;align-items:center;gap:.6rem;
        border:1px solid #eef0f3;border-radius:10px;padding:.75rem;background:#fff
    }
    .kpi-ico{
        width:40px;height:40px;border-radius:10px;display:grid;place-items:center;
        background:#f2f6ff;color:#0d6efd;font-size:18px;flex:0 0 40px
    }
    .kpi-title{font-size:.82rem;color:#6c757d;margin:0}
    .kpi-value{margin:.1rem 0 0;font-weight:700;color:#212529}

    .kpi-ico--green{background:#eaf9f1;color:#198754}
    .kpi-ico--orange{background:#fff5e6;color:#fd7e14}
    .kpi-ico--purple{background:#f3ecff;color:#6f42c1}
    .kpi-ico--cyan{background:#e7f7fb;color:#0dcaf0}
    .kpi-ico--blue{background:#e9f1ff;color:#0d6efd}

    /* ===== Charts / Table ===== */
    #chart-container{
        margin-top:1.2rem; /* ↓ */
        background:#fff;padding:.8rem;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,.05);
    }
    #chart-container h5{ font-size:.95rem;margin-bottom:.6rem;text-align:center; } /* ↓ */

    .charts-row{
        display:flex;flex-wrap:wrap;gap:.8rem;justify-content:space-between;margin-top:.6rem;
    }
    .chart-box{
        flex:1 1 49%;
        min-width:360px; /* ↓ */
        background:#fff;border-radius:10px;padding:.6rem; /* ↓ */
        box-shadow:0 2px 6px rgba(0,0,0,.05);
    }
    @media (max-width: 992px){ .chart-box{ flex:1 1 100%; min-width: 100%; } }

    .table-container{
        margin-top:.8rem; /* ↓ */
        background:#fff;padding:.8rem;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,.05);
        font-size:.92rem; /* ↓ */
    }
</style>

<div class="container-fluid dashboard-wrap">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="dashboard-container">
                <img src="{{ asset('images/innovalogo.png') }}" class="dashboard-watermark" alt="Marca de Agua">

                <div class="dashboard-content">
                    <h1>Bienvenido, {{ Auth::user()->name }}</h1>
                    <p>Panel principal del Sistema Corporativo Innova</p>

                    {{-- ===== INDICADORES EN UN SOLO CAJÓN ===== --}}
                    <div class="card kpi-card-wrap mb-3">
                      <div class="card-body">
                        <div class="kpi-head">
                          <h5>Indicadores Generales</h5>
                          <small>Actualizado: {{ now()->format('d/m/Y H:i') }}</small>
                        </div>
                        <div class="kpi-hr"></div>

                        <div class="kpi-grid">
                          {{-- PESOS --}}
                          <div class="kpi-box">
                            <div class="kpi-ico kpi-ico--green"><i class="fa-solid fa-balance-scale"></i></div>
                            <div><div class="kpi-title">Pesos Total</div>
                                 <div class="kpi-value">{{ number_format($pesoTotal,2) }} TM</div></div>
                          </div>
                          <div class="kpi-box">
                            <div class="kpi-ico kpi-ico--green"><i class="fa-solid fa-calendar-alt"></i></div>
                            <div><div class="kpi-title">Pesos Mes</div>
                                 <div class="kpi-value">{{ number_format($pesoMensual,2) }} TM</div></div>
                          </div>
                          <div class="kpi-box">
                            <div class="kpi-ico kpi-ico--green"><i class="fa-solid fa-calendar-week"></i></div>
                            <div><div class="kpi-title">Pesos Semana</div>
                                 <div class="kpi-value">{{ number_format($pesoSemanal,2) }} TM</div></div>
                          </div>
                          <div class="kpi-box">
                            <div class="kpi-ico kpi-ico--green"><i class="fa-solid fa-calendar-day"></i></div>
                            <div><div class="kpi-title">Pesos Hoy</div>
                                 <div class="kpi-value">{{ number_format($pesoDiario,2) }} TM</div></div>
                          </div>

                          {{-- INGRESOS --}}
                          <div class="kpi-box">
                            <div class="kpi-ico kpi-ico--orange"><i class="fa-solid fa-wallet"></i></div>
                            <div><div class="kpi-title">Ingresos Total</div>
                                 <div class="kpi-value">{{ $totalIngresos }}</div></div>
                          </div>
                          <div class="kpi-box">
                            <div class="kpi-ico kpi-ico--orange"><i class="fa-solid fa-calendar-alt"></i></div>
                            <div><div class="kpi-title">Ingresos Mes</div>
                                 <div class="kpi-value">{{ $ingresosMes }}</div></div>
                          </div>
                          <div class="kpi-box">
                            <div class="kpi-ico kpi-ico--orange"><i class="fa-solid fa-calendar-week"></i></div>
                            <div><div class="kpi-title">Ingresos Semana</div>
                                 <div class="kpi-value">{{ $ingresosSemana }}</div></div>
                          </div>
                          <div class="kpi-box">
                            <div class="kpi-ico kpi-ico--orange"><i class="fa-solid fa-calendar-day"></i></div>
                            <div><div class="kpi-title">Ingresos Hoy</div>
                                 <div class="kpi-value">{{ $ingresosHoy }}</div></div>
                          </div>

                          {{-- BLENDING --}}
                          <div class="kpi-box">
                            <div class="kpi-ico kpi-ico--purple"><i class="fa-solid fa-flask"></i></div>
                            <div><div class="kpi-title">Blending Total</div>
                                 <div class="kpi-value">{{ $totalBlending }}</div></div>
                          </div>
                          <div class="kpi-box">
                            <div class="kpi-ico kpi-ico--purple"><i class="fa-solid fa-calendar-alt"></i></div>
                            <div><div class="kpi-title">Blending Mes</div>
                                 <div class="kpi-value">{{ $blendingMes }}</div></div>
                          </div>
                          <div class="kpi-box">
                            <div class="kpi-ico kpi-ico--purple"><i class="fa-solid fa-calendar-week"></i></div>
                            <div><div class="kpi-title">Blending Semana</div>
                                 <div class="kpi-value">{{ $blendingSemana }}</div></div>
                          </div>
                          <div class="kpi-box">
                            <div class="kpi-ico kpi-ico--purple"><i class="fa-solid fa-calendar-day"></i></div>
                            <div><div class="kpi-title">Blending Hoy</div>
                                 <div class="kpi-value">{{ $blendingHoy }}</div></div>
                          </div>

                          {{-- DESPACHOS --}}
                          <div class="kpi-box">
                            <div class="kpi-ico kpi-ico--cyan"><i class="fa-solid fa-truck"></i></div>
                            <div><div class="kpi-title">Despachos Total</div>
                                 <div class="kpi-value">{{ $totalDespachos }}</div></div>
                          </div>
                          <div class="kpi-box">
                            <div class="kpi-ico kpi-ico--cyan"><i class="fa-solid fa-calendar-alt"></i></div>
                            <div><div class="kpi-title">Despachos Mes</div>
                                 <div class="kpi-value">{{ $despachosMes }}</div></div>
                          </div>
                          <div class="kpi-box">
                            <div class="kpi-ico kpi-ico--cyan"><i class="fa-solid fa-calendar-week"></i></div>
                            <div><div class="kpi-title">Despachos Semana</div>
                                 <div class="kpi-value">{{ $despachosSemana }}</div></div>
                          </div>
                          <div class="kpi-box">
                            <div class="kpi-ico kpi-ico--cyan"><i class="fa-solid fa-calendar-day"></i></div>
                            <div><div class="kpi-title">Despachos Hoy</div>
                                 <div class="kpi-value">{{ $despachosHoy }}</div></div>
                          </div>

                          {{-- LIQUIDACIONES --}}
                          <div class="kpi-box">
                            <div class="kpi-ico kpi-ico--blue"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                            <div><div class="kpi-title">Liquidaciones Total</div>
                                 <div class="kpi-value">{{ $totalLiquidaciones }}</div></div>
                          </div>
                          <div class="kpi-box">
                            <div class="kpi-ico kpi-ico--blue"><i class="fa-solid fa-calendar-alt"></i></div>
                            <div><div class="kpi-title">Liquidaciones Mes</div>
                                 <div class="kpi-value">{{ $cierresMensuales }}</div></div>
                          </div>
                          <div class="kpi-box">
                            <div class="kpi-ico kpi-ico--blue"><i class="fa-solid fa-calendar-week"></i></div>
                            <div><div class="kpi-title">Liquidaciones Semana</div>
                                 <div class="kpi-value">{{ $cierresSemanales }}</div></div>
                          </div>
                          <div class="kpi-box">
                            <div class="kpi-ico kpi-ico--blue"><i class="fa-solid fa-calendar-day"></i></div>
                            <div><div class="kpi-title">Liquidaciones Hoy</div>
                                 <div class="kpi-value">{{ $cierresDiarios }}</div></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    {{-- ===== /INDICADORES EN UN SOLO CAJÓN ===== --}}

                    {{-- ================= GRÁFICOS & TABLA ================= --}}
                    <div id="chart-container">
                        <div class="charts-row">
                            <div class="chart-box">
                                <h5>📦 Liquidaciones por Producto</h5>
                                <canvas id="chartProductos" height="200"></canvas>
                            </div>
                            <div class="chart-box">
                                <h5>🏆 Podio de Liquidadores</h5>
                                <canvas id="chartLiquidadores" height="200"></canvas>
                            </div>
                        </div>

                        <div class="table-container">
                            <h6 class="text-center">📊 Top Clientes</h6>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Posición</th>
                                        <th>Cliente</th>
                                        <th>Liquidaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rankingClientes as $index => $cli)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $cli->cliente }}</td>
                                        <td>{{ $cli->total }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- ====== NUEVO: ÚLTIMAS OPERACIONES REGISTRADAS ====== --}}
                        <div class="table-container">
                            <h6 class="text-center">🕒 Últimas operaciones registradas</h6>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ultimasOperaciones as $op)
                                        <tr>
                                            <td>{{ $op->id }}</td>
                                            <td>{{ $op->razon_social }}</td>
                                            <td>
                                                @php
                                                    $estado = strtoupper($op->estado);
                                                    $badge = 'secondary';
                                                    if ($estado === 'CIERRE') $badge = 'success';
                                                    elseif ($estado === 'PENDIENTE') $badge = 'warning';
                                                    elseif ($estado === 'ANULADO' || $estado === 'CANCELADO') $badge = 'danger';
                                                @endphp
                                                <span class="badge bg-{{ $badge }}">{{ $estado }}</span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($op->created_at)->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Sin movimientos recientes.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{-- ====== /ÚLTIMAS OPERACIONES REGISTRADAS ====== --}}
                    </div><!-- /chart-container -->

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome JS (opcional para algunas funciones) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Doughnut: Productos
    new Chart(document.getElementById('chartProductos'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($porProducto->pluck('producto')) !!},
            datasets: [{
                data: {!! json_encode($porProducto->pluck('total')) !!},
                backgroundColor: ['#0d6efd','#198754','#ffc107','#dc3545','#6f42c1','#20c997','#6c757d']
            }]
        },
        options: { responsive:true, plugins:{ legend:{ position:'bottom' } } }
    });

    // Podio: Liquidadores (horizontal)
    new Chart(document.getElementById('chartLiquidadores'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(
                $rankingLiquidadores->pluck('name')->map(function($n){
                    return explode(' ', trim($n))[0];
                })
            ) !!},
            datasets: [{
                label: 'Liquidaciones Cerradas',
                data: {!! json_encode($rankingLiquidadores->pluck('total')) !!},
                backgroundColor: ['#FFD700','#C0C0C0','#CD7F32','#198754','#198754']
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: { legend: { display:false } },
            scales: { x: { beginAtZero:true } }
        }
    });
</script>
@endsection