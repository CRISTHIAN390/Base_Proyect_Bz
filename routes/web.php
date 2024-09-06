<?php

use App\Http\Controllers\DetalleFVControlle;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\FleteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ViaticoController;
use Illuminate\Support\Facades\Route;

Route::get('/',[HomeController::class,'IndexLogin']);
Route::get('/dashboard', function () {return view('dashboard');})->middleware(['auth', 'verified'])->name('dashboard');


//Implementacion de rutas
//Empleado
Route::resource('empleado', EmpleadoController::class);
Route::get('cancelar', function(){return redirect()->route('empleado.index')->with('datos','¡ Acción Cancelada... !');})->name('cancelarempleado');
//Flete
Route::resource('flete', FleteController::class);
//Viatico
Route::resource('viatico', ViaticoController::class);

//Detalles
Route::resource('detalleFV', DetalleFVControlle::class);



Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
