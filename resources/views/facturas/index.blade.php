@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="text-center"> Facturas de Liquidaciones</h2>
    
    <div class="row mb-3">
        <!-- Campo de Búsqueda -->
        <div class="col-md-8">
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar en la tabla...">
        </div>
        
        <!-- Botón de Exportación -->
        <div class="col-md-4 text-md-end mt-2 mt-md-0">
            
            <a href="{{ route('export.facturas') }}" class="btn btn-success">
                <i class="bi bi-file-earmark-excel-fill"></i> Exportar a Excel
            </a>
        </div>
    </div>
    <style>
        
    
        thead th {
            background-color: #2b4a6a !important;
            color: white !important;
            
        }
    </style>
   <table class="table table-bordered">
        <thead class="custom-header">
            <tr>
                <th>ID</th>
                <th>Liquidación ID</th>
                <th>RUC</th>
                <th>Cliente</th>
                <th>Número de Factura</th>
                <th>Monto</th>
                <th>Creado</th>
                <th>Actualizado</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @foreach($facturasLiquidaciones as $factura)
            <tr>
                <td>{{ $factura->id }}</td>
                <td>{{ $factura->liquidacion_id }}</td>
                <td>{{ optional($factura->liquidacion->cliente)->documento_cliente ?? 'Sin Cliente' }}</td>
                <td>{{ optional($factura->liquidacion->cliente)->datos_cliente ?? 'N/A' }}</td>
                <td>{{ $factura->factura_numero }}</td>
                <td>{{ number_format($factura->monto, 2) }}</td>
                <td>{{ $factura->created_at }}</td>   
                <td>{{ $factura->updated_at }}</td>   
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<script>
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#tableBody tr");

        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let thead = document.querySelector("thead");
        if (thead) {
            thead.style.setProperty("background-color", "#007bff", "important");
            thead.style.setProperty("color", "white", "important");
        }
    });
</script>

@endsection