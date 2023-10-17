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
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\AsignacionRecursoController;
use App\Http\Controllers\MiembroActividadController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Auth\PerfilController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\EventoController;


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


Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::get('/autenticar', [TwoFactorController::class, 'index'])->name('autenticar');
    Route::post('/verificarFA', [TwoFactorController::class, 'verificarCodigo'])->name('verificar');
    Route::get('/cancelTwoFactor', [TwoFactorController::class, 'cancelTwoFactorResponse'])->name('cancel');
});

Route::group(['middleware' => ['auth']], function() {
    
    Route::get('/', function () {return view('home');});
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');
    Route::get('/perfil/desFA', [PerfilController::class, 'disableFA'])->name('deshabilitarFA');
    Route::get('/perfil/habFA', [PerfilController::class, 'enableFA'])->name('habilitarFA');
    Route::patch('/perfil/updateInfo/{id}', [PerfilController::class, 'updateInfo'])->name('perfil.updateInfo');
    Route::post('/perfil/updatePass', [PerfilController::class, 'updatePass'])->name('perfil.updatePass');
    
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
    Route::resource('comentarios', ComentarioController::class);
    Route::get('tareas/data/{id}', [TareaController::class, 'data'])->name('tareas.data');
    Route::resource('tareas', TareaController::class);

    Route::get('/miembrosactividades/list/{id}', [MiembroActividadController::class, 'list'])->name('miembrosactividades.list');
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

    //Ruta de Calendario
    Route::get('/calendario', [App\Http\Controllers\CalendarioController::class, 'index']);
    Route::get('/calendario/mostrar/{idProyecto}', [App\Http\Controllers\CalendarioController::class, 'show']);
    Route::post('/calendario/consultar/{id}', [App\Http\Controllers\CalendarioController::class, 'consultarActividad']);
    Route::post('/calendario/agregar', [App\Http\Controllers\CalendarioController::class, 'GuardarEvento']);
    Route::get('/calendario/mostrarEvento/{idProyecto}', [App\Http\Controllers\CalendarioController::class, 'showEvento']);
    Route::post('/calendario/consultarEvento/{id}', [App\Http\Controllers\CalendarioController::class, 'consultarEvento']);
    Route::post('/calendario/ActualizarEvento/{evento}', [App\Http\Controllers\CalendarioController::class, 'actualizarEvento']);
    Route::post('/calendario/eliminarEvento/{id}', [App\Http\Controllers\CalendarioController::class, 'eliminarEvento']);

    //Ruta de Notificaciones
    Route::get('/notificaciones/get', [NotificationsController::class, 'getNotificationsData'])->name('notifications.get');
    Route::get('abrir_notificacion/{id}', [NotificationsController::class, 'abrirNotificacion'])->name('notifications.abrirNotificacion');
    Route::get('/notificaciones/data', [NotificationsController::class, 'getNotificationsTable'])->name('notifications.data');
    Route::post('/notificaciones/eliminar/{id}', [NotificationsController::class, 'eliminarNotificacion'])->name('notifications.eliminarNotificacion');
    Route::post('/notificaciones/eliminar', [NotificationsController::class, 'eliminarTodasNotificacion'])->name('notifications.eliminarTodasNotificacion');
    Route::post('/notificaciones/marcar_leida/{id}', [NotificationsController::class, 'marcarLeida'])->name('notifications.marcarLeidaNotificacion');
    Route::post('/notificaciones/marcar_leida', [NotificationsController::class, 'marcarTodasLeida'])->name('notifications.marcarTodasLeidaNotificacion');
    Route::resource('notificaciones', NotificationsController::class)->except(['show', 'eliminarNotificacion', 'marcarLeida', 'eliminarTodasNotificacion', 'marcarTodasLeida']);
});