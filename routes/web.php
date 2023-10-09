<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EquipoTrabajoController;
use App\Http\Controllers\ManoObraController;
use App\Http\Controllers\ActividadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::get('miembros/data', [ManoObraController::class, 'data'])->name('miembros.data');
    Route::resource('miembros', ManoObraController::class);
    Route::get('actividades/{id}', [ActividadController::class, 'index'])->name('actividades.index');
    Route::get('actividades/create/{id}', [ActividadController::class, 'create'])->name('actividades.create');
    Route::get('actividades/show/{id}', [ActividadController::class, 'show'])->name('actividades.show');
    Route::get('actividades/data/{id}', [ActividadController::class, 'data'])->name('actividades.data');
    Route::resource('actividades', ActividadController::class)->except(['index','create','show']);
    //Route::post('/eliminar-equipos', [EquipoDeTrabajoController::class, 'eliminarEquipos']);
    //Route::post('/crear-equipos-trabajo', [EquipoTrabajoController::class, 'crearEquiposTrabajo']);
    // Ruta para mostrar la lista de equipos relacionados con un proyecto específico
    Route::get('/equipos/list/{proyectoId}', [EquipoTrabajoController::class, 'list']);
    // Ruta para las otras acciones CRUD (opcional)
    Route::resource('equipos', EquipoTrabajoController::class)->except(['list']);

});