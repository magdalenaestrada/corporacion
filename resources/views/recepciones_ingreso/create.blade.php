@extends('layouts.app')

@section('content')
<div class="container-fluid">

  @if (session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('recepciones-ingreso.store') }}">
   @csrf

@if(!empty($pesoInfo))
<div class="card mb-3">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Nueva Recepción de Ingreso</h5>
    <small class="text-muted">Datos de la salida (solo lectura)</small>
  </div>

  <div class="card-body">
    <div class="row g-2">
      <div class="col-6 col-md-2">
      <label class="form-label">N° Salida <span class="text-danger">*</span></label>
      <input
        type="text"
        name="nro_salida"  {{-- <-- IMPORTANTE --}}
        class="form-control form-control-sm @error('nro_salida') is-invalid @enderror"
        value="{{ old('nro_salida', $prefill['nro_salida'] ?? request('nro_salida')) }}"
        readonly
      >
      @error('nro_salida') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

      <div class="col-6 col-md-1">
        <label class="form-label">Fecha Salida</label>
        <input type="text" class="form-control form-control-sm"
               value="{{ !empty($pesoInfo['fechas']) ? \Carbon\Carbon::parse($pesoInfo['fechas'])->format('d-m-Y') : '' }}" disabled>
      </div>

      <div class="col-6 col-md-1">
        <label class="form-label">Hora Salida</label>
        <input type="text" class="form-control form-control-sm"
               value="{{ !empty($pesoInfo['horas']) ? \Carbon\Carbon::parse($pesoInfo['horas'])->format('H:i:s') : '' }}" disabled>
      </div>

      <div class="col-4 col-md-1">
        <label class="form-label">Bruto</label>
        <input type="text" class="form-control form-control-sm" value="{{ $pesoInfo['bruto'] ?? '' }}" disabled>
      </div>
      <div class="col-4 col-md-1">
        <label class="form-label">Tara</label>
        <input type="text" class="form-control form-control-sm" value="{{ $pesoInfo['tara'] ?? '' }}" disabled>
      </div>
      <div class="col-4 col-md-1">
        <label class="form-label">Neto</label>
        <input type="text" class="form-control form-control-sm" value="{{ $pesoInfo['neto'] ?? '' }}" disabled>
      </div>

      <div class="col-6 col-md-2">
        <label class="form-label">Producto</label>
        <input type="text" class="form-control form-control-sm" value="{{ $pesoInfo['producto'] ?? '' }}" disabled>
      </div>
      <div class="col-6 col-md-1">
        <label class="form-label">Placa</label>
        <input type="text" class="form-control form-control-sm" value="{{ $pesoInfo['placa'] ?? '' }}" disabled>
      </div>
      <div class="col-6 col-md-1">
        <label class="form-label">Carreta</label>
        <input type="text" class="form-control form-control-sm" value="{{ $pesoInfo['carreta'] ?? '' }}" disabled>
      </div>
      <div class="col-6 col-md-2">
        <label class="form-label">Destino</label>
        <input type="text" class="form-control form-control-sm" value="{{ $pesoInfo['destino'] ?? '' }}" disabled>
      </div>
      <div class="col-6 col-md-2">
        <label class="form-label">Origen</label>
        <input type="text" class="form-control form-control-sm" value="{{ $pesoInfo['origen'] ?? '' }}" disabled>
      </div>
      <div class="col-6 col-md-2">
        <label class="form-label">Guia Remision</label>
        <input type="text" class="form-control form-control-sm" value="{{ $pesoInfo['guia'] ?? '' }}" disabled>
      </div>
      <div class="col-6 col-md-2">
        <label class="form-label">Guia Transporte</label>
        <input type="text" class="form-control form-control-sm" value="{{ $pesoInfo['guiat'] ?? '' }}" disabled>
      </div>
    </div>
  </div>
</div>
@endif

<div class="card">
  <div class="card-body">
   
    <div class="row g-2 align-items-end">
      <div class="col-12 col-md-4">
        <label for="nro_ruc" class="form-label text-success mb-1">RUC</label>
        <div class="input-group input-group-sm">
          <input type="text" name="nro_ruc" id="nro_ruc"
                 class="form-control @error('nro_ruc') is-invalid @enderror"
                 value="{{ old('nro_ruc') }}" placeholder="Ingrese N° RUC">
          <button class="btn btn-primary" type="button" id="buscar_nroruc_btn">
            {{-- ícono lupa --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 25 25" style="fill:#fff">
              <path d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z"/>
            </svg>
          </button>
          @error('nro_ruc') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
      </div>

      <div class="col-12 col-md-8">
        <label for="documento_ruc" class="form-label text-muted mb-1">DATOS RUC</label>
        <input type="text" name="documento_ruc" id="documento_ruc"
               class="form-control form-control-sm @error('documento_ruc') is-invalid @enderror"
               value="{{ old('documento_ruc', $prefill['documento_ruc'] ?? ($pesoInfo['razon_social'] ?? '')) }}"
               placeholder="Datos obtenidos automáticamente...">
        @error('documento_ruc') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
    </div>

    <hr class="my-3">

   
    <div class="row g-2 align-items-end">
  
      <div class="col-12 col-md-3">
        <label for="dni_conductor" class="form-label text-success mb-1">DNI CONDUCTOR</label>
        <div class="input-group input-group-sm">
          <input type="text" name="dni_conductor" id="dni_conductor"
                 class="form-control @error('dni_conductor') is-invalid @enderror"
                 value="{{ old('dni_conductor') }}" placeholder="Ingrese DNI">
          <button class="btn btn-primary" type="button" id="buscar_dniconductor_btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 25 25" style="fill:#fff">
              <path d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z"/>
            </svg>
          </button>
          @error('dni_conductor') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
      </div>

      
      <div class="col-12 col-md-7">
        <label for="datos_conductor" class="form-label text-muted mb-1">DATOS CONDUCTOR</label>
        <input type="text" name="datos_conductor" id="datos_conductor"
               class="form-control form-control-sm @error('datos_conductor') is-invalid @enderror"
               value="{{ old('datos_conductor', $prefill['datos_conductor'] ?? ($pesoInfo['conductor'] ?? '')) }}"
               placeholder="Datos obtenidos automáticamente...">
        @error('datos_conductor') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      
      <div class="col-12 col-md-2 d-flex align-items-end">
        <div class="form-check ms-md-2">
          <input class="form-check-input" type="checkbox" id="same_as_driver" name="same_as_driver" value="1"
                 {{ old('same_as_driver') ? 'checked' : '' }}>
          <label class="form-check-label small" for="same_as_driver" style="white-space:nowrap;">
            El conductor es también el encargado
          </label>
        </div>
      </div>
    </div>

    <hr class="my-3">

    {{-- ENCARGADO --}}
    <div class="row g-2 align-items-end">
      <div class="col-12 col-md-4">
        <label for="documento_encargado" class="form-label text-success mb-1">DNI ENCARGADO</label>
        <div class="input-group input-group-sm">
          <input type="text" name="documento_encargado" id="documento_encargado"
                 class="form-control @error('documento_encargado') is-invalid @enderror"
                 value="{{ old('documento_encargado') }}" placeholder="Ingrese DNI">
          <button class="btn btn-primary" type="button" id="buscar_dniencargado_btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 25 25" style="fill:#fff">
              <path d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z"/>
            </svg>
          </button>
          @error('documento_encargado') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
      </div>

      <div class="col-12 col-md-6">
        <label for="datos_encargado" class="form-label text-muted mb-1">DATOS DEL ENCARGADO</label>
        <input type="text" name="datos_encargado" id="datos_encargado"
               class="form-control form-control-sm @error('datos_encargado') is-invalid @enderror"
               value="{{ old('datos_encargado') }}" placeholder="Datos obtenidos automáticamente...">
        @error('datos_encargado') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="col-12 col-md-2">
        <label class="form-label mb-1">DOMICILIO ENCARGADO</label>
        <input type="text" name="domicilio_encargado" id="domicilio_encargado" class="form-control form-control-sm"
               value="{{ old('domicilio_encargado', $prefill['domicilio_encargado'] ?? '') }}">
      </div>
    </div>

    <div class="row g-2 mt-3">
      <div class="col-12">
        <label class="form-label">Observación</label>
        <textarea name="observacion" rows="3" class="form-control">{{ old('observacion') }}</textarea>
      </div>
    </div>
  </div>

  <div class="card-footer d-flex justify-content-end gap-2">
    <a href="{{ route('recepciones-ingreso.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">Guardar</button>
  </div>
</div>

  </form>
</div>
@endsection

@push('js')
<script>
(function(){
  const chk = document.getElementById('same_as_driver');

  const dniCon = document.getElementById('dni_conductor');
  const datCon = document.getElementById('datos_conductor');

  const dniEnc = document.getElementById('documento_encargado');
  const datEnc = document.getElementById('datos_encargado');
  const domEnc = document.getElementById('domicilio_encargado'); // <- se mantiene libre

  const btnEnc = document.getElementById('buscar_dniencargado_btn');

  // 1) Ya no guardamos/restauramos domEnc
  function snapshotEncargado() {
    if (dniEnc) dniEnc.dataset.prev = dniEnc.value || '';
    if (datEnc) datEnc.dataset.prev = datEnc.value || '';
  }
  function restoreEncargado() {
    if (dniEnc) dniEnc.value = dniEnc.dataset.prev || '';
    if (datEnc) datEnc.value = datEnc.dataset.prev || '';
  }

  // 2) Ya no bloqueamos domEnc (queda editable siempre)
  function setReadonlyEncargado(state) {
    [dniEnc, datEnc].forEach(el=>{
      if(!el) return;
      el.readOnly = state;
      el.classList.toggle('bg-light', state);
      el.classList.toggle('text-muted', state);
    });
    if (btnEnc) btnEnc.disabled = state;
    // domEnc queda libre; si quieres darle estilo cuando check activo:
    // domEnc.classList.toggle('bg-light', false);
    // domEnc.readOnly = false;
  }

  // 3) Copiamos solo DNI/Nombre del conductor (no domicilio)
  function copyFromDriver() {
    if (dniEnc && dniCon) dniEnc.value = dniCon.value || '';
    if (datEnc && datCon) datEnc.value = datCon.value || '';
  }

  function bindLiveSync(bind) {
    const handler = () => copyFromDriver();
    if (bind) {
      if (dniCon) { dniCon.addEventListener('input', handler); dniCon._syncHandler = handler; }
      if (datCon) { datCon.addEventListener('input', handler); datCon._syncHandler = handler; }
    } else {
      if (dniCon && dniCon._syncHandler) { dniCon.removeEventListener('input', dniCon._syncHandler); dniCon._syncHandler = null; }
      if (datCon && datCon._syncHandler) { datCon.removeEventListener('input', datCon._syncHandler); datCon._syncHandler = null; }
    }
  }

  function applyStateFromCheckbox() {
    if (!chk) return;
    if (chk.checked) {
      snapshotEncargado();
      copyFromDriver();
      setReadonlyEncargado(true);   // bloquea solo DNI/Nombre
    } else {
      bindLiveSync(false);
      setReadonlyEncargado(false);
      restoreEncargado();
    }
  }

  if (chk) {
    applyStateFromCheckbox();
    chk.addEventListener('change', applyStateFromCheckbox);
  }
})();
</script>
@endpush
