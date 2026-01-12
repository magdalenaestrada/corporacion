<?php

use App\Http\Controllers\AdelantoController;
use App\Http\Controllers\RegistroController;
use App\Exports\LiquidacionesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MuestraController;
use App\Http\Controllers\PesoController;

use App\Http\Controllers\RequerimientoController;
use App\Http\Controllers\LiquidacionController;
use App\Http\Controllers\ResumenController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\PosicionController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\AcCategoriaController;
use App\Http\Controllers\AcActivoController;
use App\Http\Controllers\AcItemController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\BlendingController;
use App\Http\Controllers\DespachoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\FinaController;
use App\Http\Controllers\RecepcionController;
use App\Http\Controllers\FacturaLiquidacionController;
use App\Http\Controllers\RecepcionIngresoController;
use App\Http\Controllers\HumedadController;
use App\Http\Controllers\EstadoMineralController;

Route::group(['middleware' => ['auth']], function () {



    //RESOURCES ROUTES
    Route::resource('clientes', ClienteController::class);
    Route::resource('pesos', PesoController::class);
    Route::resource('muestras', MuestraController::class);
    Route::resource('requerimientos', RequerimientoController::class);
    Route::resource('liquidaciones', LiquidacionController::class);
    Route::resource('adelantos', AdelantoController::class);
    Route::resource('resumens', ResumenController::class);
    Route::resource('areas', AreaController::class);
    Route::resource('posiciones', PosicionController::class);
    Route::resource('empleados', EmpleadoController::class);
    Route::resource('accategorias', AcCategoriaController::class);
    Route::resource('acactivos', AcActivoController::class);
    Route::resource('acitems', AcItemController::class);


    Route::resource('ingresos', IngresoController::class);
    Route::resource('blendings', BlendingController::class);
    Route::resource('despachos', DespachoController::class);
    // Route::resource('reportes', ReporteController::class);
    Route::resource('finas', FinaController::class);
    Route::resource('recepciones', RecepcionController::class);

    Route::resource('permissions', PermissionController::class);
    Route::get('permissions/{permissionId}/delete', [PermissionController::class, 'destroy']);

    Route::resource('roles', RoleController::class);
    Route::get('roles/{roleId}/delete', [RoleController::class, 'destroy']);


    Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole']);


    Route::get('/adelantos/create', [AdelantoController::class, 'create'])->name('adelantos.create');
    Route::post('/adelantos', [AdelantoController::class, 'store'])->name('adelantos.store');


    Route::resource('users', UserController::class);
    Route::get('users/{userId}/delete', [UserController::class, 'destroy']);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/buscar-documento', [ClienteController::class, 'buscarDocumento'])->name('buscar.documento');

    Route::get('/soloChancado', [IngresoController::class, 'soloChancado'])->name('ingresos.soloChancado');

    // Ejemplo de ruta para almacenar el resumen
    Route::post('/resumens', [ResumenController::class, 'store'])->name('resumens.store');
    //Ruta para imprimir
    Route::get('/liquidaciones/{id}/print', [LiquidacionController::class, 'print'])->name('liquidaciones.print');
    Route::post('/duplicate/{id}', [LiquidacionController::class, 'duplicate'])->name('duplicate');
    Route::put('/liquidaciones/{id}', [LiquidacionController::class, 'update'])->name('liquidaciones.update');

    Route::get('ingresos/imprimir/{id}', [IngresoController::class, 'imprimir'])->name('ingresos.imprimir');
    Route::post('/ingresos/{id}/retirar', [IngresoController::class, 'retirar'])->name('ingresos.retirar');

    Route::resource('ingresos', IngresoController::class);

    Route::get('/lotizacion', [IngresoController::class, 'lotizar'])->name('lotizacion');
    Route::get('/chancado', [IngresoController::class, 'chancado'])->name('chancado');

    Route::get('despachos/create/{blendingId}', [DespachoController::class, 'create'])->name('despachos.create');
    Route::get('despachos/{despacho}/retiros', [DespachoController::class, 'showRetiros'])->name('despachos.retiros');

    Route::post('retiros/{retiro}/recepcion', [RecepcionController::class, 'store'])->name('retiros.recepcion');
    Route::get('retiros/{retiro}/recepcion', [RecepcionController::class, 'show'])->name('retiros.recepcion.show');
    Route::put('retiros/recepcion/{recepcion}', [RecepcionController::class, 'update'])->name('retiros.recepcion.update');

    Route::get('/finas', [FinaController::class, 'index'])->name('finas.index');
    Route::get('/procesadas', [FinaController::class, 'procesadas'])->name('procesadas');

    Route::post('/finas/create', [FinaController::class, 'create'])->name('finas.create');
    Route::post('/finas/store', [FinaController::class, 'store'])->name('finas.store');
    Route::get('/finas/{fina}', [FinaController::class, 'show'])->name('finas.show');
    Route::get('/fina/{id}/print', [FinaController::class, 'print'])->name('fina.print');


    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/liq', [ReporteController::class, 'liq'])->name('reportes.liq');
    Route::get('/reportes/export-excel', [ReporteController::class, 'exportExcel'])->name('reportes.export.excel');
    Route::get('/reportes/exportar-excel', [ReporteController::class, 'exportarExcel'])->name('reportes.exportar.excel');
    Route::get('/reportes/exportar-blendings', [ReporteController::class, 'exportarBlendingExcel'])->name('reportes.blendings.exportar');
    Route::get('/reportes/exportar-ingresos', [ReporteController::class, 'exportarIngresosExcel'])->name('reportes.exportar.ingresos');


    Route::get('reportes/resumen', [ReporteController::class, 'resumen'])->name('reportes.resumen');


    Route::get('/facturas/{liquidacion_id}', [FacturaLiquidacionController::class, 'obtenerFacturas']);
    Route::post('/facturas_liquidaciones', [FacturaLiquidacionController::class, 'store']);
    Route::get('/facturas-liquidaciones', [FacturaLiquidacionController::class, 'index'])->name('facturas.index');



    Route::get('/export-facturas', [FacturaLiquidacionController::class, 'export'])->name('export.facturas');
    Route::get('/reportes/ingresos', [ReporteController::class, 'loza'])->name('reportes.loza');
    Route::get('/reportes/blendings', [ReporteController::class, 'blendings'])->name('reportes.blendings');

    Route::get('/reportes/despachos', [ReporteController::class, 'despachos'])->name('reportes.despachos');
    Route::get('/reportes/despachos/exportar', [ReporteController::class, 'exportarDespachosExcel'])->name('reportes.despachos.exportar');

    Route::get('/reportes/flujo', [ReporteController::class, 'flujos'])->name('reportes.flujos');
    Route::resource('recepciones-ingreso', RecepcionIngresoController::class);

    Route::resource('humedad', HumedadController::class);

    Route::get('/pesos/export/excel', [PesoController::class, 'exportExcel'])
        ->name('pesos.export.excel');


    Route::get('pesos/{nro_salida}/recepcionar', [PesoController::class, 'recepcionar'])->name('pesos.recepcionar');
    Route::get('/recepciones-ingreso/{nro_salida}/acta', [RecepcionIngresoController::class, 'actaHtml'])->name('recepciones-ingreso.acta.html');

    Route::resource('estados_mineral', EstadoMineralController::class);

});


Route::get('/', function () {
    return view('welcome');
});




Auth::routes();
