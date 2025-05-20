<?php

use App\Http\Controllers\AdolescentesController;
use App\Http\Controllers\AdultosController;
use App\Http\Controllers\BebesController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\JovenesController;
use App\Http\Controllers\LongevosController;
use App\Http\Controllers\MayoresController;
use App\Http\Controllers\NinosController;
use Illuminate\Support\Facades\Route;

// Ruta para el formulario de edad (pública)
Route::get('/', function () {
    return view('age_form');
})->name('age.form');

// Ruta para procesar la edad
Route::post('/procesar-edad', function () {
    // La lógica está en el middleware
    return redirect()->route('age.form');
})->middleware('age.validator')->name('age.process');

// Ruta para olvidar la edad
Route::post('/forget-age', function () {
    // La lógica está en el middleware
    return redirect()->route('age.form');
})->middleware('age.validator')->name('age.forget');

// Rutas para cada categoría (protegidas por el mismo middleware)
Route::middleware('age.validator')->group(function () {
    Route::get('/bebes', [BebesController::class, 'index'])->name('bebes.index');
    Route::get('/ninos', [NinosController::class, 'index'])->name('ninos.index');
    Route::get('/adolescentes', [AdolescentesController::class, 'index'])->name('adolescentes.index');
    Route::get('/jovenes', [JovenesController::class, 'index'])->name('jovenes.index');
    Route::get('/adultos', [AdultosController::class, 'index'])->name('adultos.index');
    Route::get('/mayores', [MayoresController::class, 'index'])->name('mayores.index');
    Route::get('/longevos', [LongevosController::class, 'index'])->name('longevos.index');
});

// Ruta de error (pública)
Route::get('/error', [ErrorController::class, 'index'])->name('error.index');