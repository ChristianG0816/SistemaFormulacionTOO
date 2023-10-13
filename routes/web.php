<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EquipoTrabajoController;
use App\Http\Controllers\ManoObraController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\AsignacionRecursoController;
use App\Http\Controllers\MiembroActividadController;


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
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::get('roles/data', [RolController::class, 'data'])->name('roles.data');
    Route::resource('roles', RolController::class);
    Route::get('usuarios/data', [UsuarioController::class, 'data'])->name('usuarios.data');
    Route::resource('usuarios', UsuarioController::class);
    
    Route::get('proyectos/data', [ProyectoController::class, 'data'])->name('proyectos.data');
    Route::resource('proyectos', ProyectoController::class);
    
    Route::get('miembros/data', [ManoObraController::class, 'data'])->name('miembros.data');
    Route::resource('miembros', ManoObraController::class);
    
    //Rutas para recursos
    Route::get('recursos/detalle/{id}', [RecursoController::class, 'getRecurso']);
    Route::get('recursos/disponibles', [RecursoController::class, 'RecursosDisponibles']);
    Route::get('recursos/data', [RecursoController::class, 'data'])->name('recursos.data');
    Route::resource('recursos', RecursoController::class);
    Route::post('asignacionrecurso/crear', [AsignacionRecursoController::class,'crearAsignacionRecurso']);
    Route::get('asignacionrecurso/list/{id}', [AsignacionRecursoController::class, 'list']);

    Route::get('actividades/{id}', [ActividadController::class, 'index'])->name('actividades.index');
    Route::get('actividades/create/{id}', [ActividadController::class, 'create'])->name('actividades.create');
    Route::get('actividades/show/{id}', [ActividadController::class, 'show'])->name('actividades.show');
    Route::get('actividades/data/{id}', [ActividadController::class, 'data'])->name('actividades.data');
    Route::resource('actividades', ActividadController::class)->except(['index','create','show']);
    Route::get('miembrosactividades/list/{id}', [MiembroActividadController::class, 'list'])->name('miembrosactividades.list');
    Route::get('/miembrosactividades/nolist/{actividadId}/{proyectoId}', [MiembroActividadController::class, 'listMiembrosNoAsignados']);
    Route::get('/miembrosactividades/detalle/{id}', [MiembroActividadController::class, 'getMiembroEquipo']);
    Route::post('/miembrosactividades/crear', [MiembroActividadController::class, 'crearMiembrosActividad']);
    Route::post('/miembrosactividades/eliminar', [MiembroActividadController::class, 'eliminarMiembrosActividad']);
    // Ruta para mostrar la lista de equipos relacionados con un proyecto específico
    Route::get('/equipos/list/{proyectoId}', [EquipoTrabajoController::class, 'list']);
    Route::get('/equipos/nolist/{proyectoId}', [EquipoTrabajoController::class, 'listMiembrosNoAsignados']);
    Route::get('/equipos/detalle/{id}', [EquipoTrabajoController::class, 'getMiembro']);
    Route::post('/equipos/crear', [EquipoTrabajoController::class, 'crearEquiposTrabajo']);
    Route::post('/equipos/eliminar', [EquipoTrabajoController::class, 'eliminarEquipos']);

    // Ruta para las otras acciones CRUD (opcional)
    Route::resource('equipos', EquipoTrabajoController::class)->except(['list', 'listMiembrosNoAsignados', 'getMiembro', 'crearEquiposTrabajo']);

});