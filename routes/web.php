<?php

use App\Http\Controllers\DetalleFVControlle;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\FleteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ViaticoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\TestChatModuleController;
use Illuminate\Support\Facades\Route;

Route::get('/',[HomeController::class,'IndexLogin']);
//Route::get('/dashboard', function () {return view('indexx');})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', [HomeController::class, 'Dashboard'])->middleware(['auth', 'verified'])->name('dashboard');


//Implementacion de rutas
//Empleado
Route::resource('empleado', EmpleadoController::class);
Route::get('cancelar', function(){return redirect()->route('empleado.index')->with('datos','¡ Acción Cancelada... !');})->name('cancelarempleado');
//Flete
Route::resource('flete', FleteController::class);
//Viatico
Route::resource('viatico', ViaticoController::class);
//reporte
Route::resource('reporte', ReporteController::class)->except(['show']);
Route::get('/reporte/exportarexcel', [ReporteController::class, 'exportarExcel'])->name('expoexcel');
Route::get('/reporte/exportarpdf', [ReporteController::class, 'exportarPdf'])->name('expopdf');
//Detalles
Route::resource('detalleFV', DetalleFVControlle::class);
Route::get('cancelardetalle', function(){return redirect()->route('detalleFV.index')->with('datos','¡ Acción Cancelada... !');})->name('cancelardetalle');
//->middleware(['auth', 'verified'])->name('gastos.anio');
Route::get('/get-gastos', [HomeController::class, 'getGastosPorAnio']);
Route::get('/get-ingresos', [HomeController::class, 'getIngresosPorAnio']);


Route::get('/Consultabot' , [TestChatModuleController::class , 'Consultabot'])->name('Consultabot');
Route::post('/chat-fetch' , [TestChatModuleController::class , 'chat'])->name('chat');






Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
