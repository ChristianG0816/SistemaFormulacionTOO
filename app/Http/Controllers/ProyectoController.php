<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Proyecto;
use App\Models\EstadoProyecto;
use App\Models\Evento;
use App\Models\EquipoTrabajo;
use App\Models\Actividad;
use App\Models\MiembroActividad;
use App\Models\AsignacionRecurso;
use App\Models\Tarea;
use App\Models\Comentario;
use App\Models\Notificacion;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class ProyectoController extends Controller
{
    /**
     * Funcion para mostrar la vista de todos los proyectos.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = Auth::user();
        $proyectos = null;
        if ($user->hasRole('Supervisor')) {
            $proyectos = Proyecto::where('id_dueno', $user->id)->get();
        } elseif ($user->hasRole('Cliente')) {
            $proyectos = Proyecto::where('id_cliente', $user->id)->get();
        } elseif ($user->hasRole('Colaborador')) {
            $proyectos = Proyecto::whereIn('id', function ($query) use ($user) {
                $query->select('id_proyecto')
                    ->from('equipo_trabajo')
                    ->join('mano_obra', 'equipo_trabajo.id_mano_obra', '=', 'mano_obra.id')
                    ->where('mano_obra.id_usuario', $user->id);
            })->get();
        }
        //dd($proyectos->toSql());
        //dd($proyectos);
    
        return view('proyectos.index', compact('proyectos'));
    }  

    public function data()
{
    $user = Auth::user();
    $proyectosQuery = Proyecto::query();

    if ($user->hasRole('Supervisor')) {
        $proyectosQuery->where('id_dueno', $user->id);
    } elseif ($user->hasRole('Cliente')) {
        $proyectosQuery->where('id_cliente', $user->id);
    } elseif ($user->hasRole('Colaborador')) {
        $proyectosQuery->whereIn('id', function ($query) use ($user) {
            $query->select('id_proyecto')
                ->from('equipo_trabajo')
                ->join('mano_obra', 'equipo_trabajo.id_mano_obra', '=', 'mano_obra.id')
                ->where('mano_obra.id_usuario', $user->id);
        });
    }

    $data = $proyectosQuery->with('estado_proyecto', 'dueno')->get();

    return datatables()->of($data)
        ->addColumn('cliente_nombre', function ($row) {
            return $row->cliente->name . ' ' . $row->cliente->last_name;
        })
        ->addColumn('dueno_nombre', function ($row) {
            return $row->dueno->name . ' ' . $row->dueno->last_name;
        })             
        ->rawColumns(['action'])
        ->make(true);
}

    /**
     * Funcion para crear un nuevo proyecto
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prioridades = ['1' => '1','2' => '2','3' => '3','4' => '4','5' => '5',];

        $dueno = Role::where('name', 'Supervisor')->first();
        $usuariosDuenos = $dueno->users;
        $duenos = $usuariosDuenos->mapWithKeys(function ($usuario) {return [$usuario->id => $usuario->name . ' ' . $usuario->last_name];})->all();

        $cliente = Role::where('name', 'Cliente')->first();
        $usuariosClientes = $cliente->users;        
        $clientes = $usuariosClientes->mapWithKeys(function ($usuario) {return [$usuario->id => $usuario->name . ' ' . $usuario->last_name];})->all();
        return view('proyectos.crear', compact('duenos','prioridades','clientes'));
    }

    /**
     * Funcion para guardar proyecto.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required|unique:proyecto',
            'objetivo' => 'required',
            'id_cliente'=>['required'],
            'id_dueno'=>['required'],
            'descripcion'=>['required'],
            'fecha_inicio'=>'required|fecha_menor_igual:fecha_fin',
            'fecha_fin'=> 'required',
            'presupuesto'=>['required', 'regex:/^\d+(\.\d+)?$/'],
            'prioridad' => ['required'],
            'entregable'=>'required'
        ]);

        $input = $request->all();
        $input['id_estado_proyecto'] = 1;
        
        $proyecto = Proyecto::create($input);
        return redirect()->route('proyectos.index')->with('success', 'Proyecto creado con éxito');
        
    }

    /**
     * Funcion para mostrar gestion de proyecto
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proyecto = Proyecto::find($id);
        return view('proyectos.mostrar', compact('proyecto'));
    }

    /**
     * Funcion para editar proyecto
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proyecto = Proyecto::find($id);

        $prioridades = ['1' => '1','2' => '2','3' => '3','4' => '4','5' => '5',];

        $dueno = Role::where('name', 'Supervisor')->first();
        $usuariosDuenos = $dueno->users;
        $duenos = $usuariosDuenos->mapWithKeys(function ($usuario) {return [$usuario->id => $usuario->name . ' ' . $usuario->last_name];})->all();

        $cliente = Role::where('name', 'Cliente')->first();
        $usuariosClientes = $cliente->users;        
        $clientes = $usuariosClientes->mapWithKeys(function ($usuario) {return [$usuario->id => $usuario->name . ' ' . $usuario->last_name];})->all();
        
        return view('proyectos.editar', compact('proyecto','duenos','prioridades','clientes'));
    }

    /**
     * Funcion para guardar edicion de proyecto
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required|unique:proyecto,nombre,' . $id,
            'objetivo' => 'required',
            'id_cliente'=>['required'],
            'id_dueno'=>['required'],
            'descripcion'=>['required'],
            'fecha_inicio'=>'required|fecha_menor_igual:fecha_fin',
            'fecha_fin'=> 'required',
            'presupuesto'=>['required', 'regex:/^\d+(\.\d+)?$/'],
            'prioridad' => ['required'],
            'entregable'=>'required'
        ]);

        $input = $request->all();
        $proyecto = Proyecto::find($id);
        $proyecto->update($input);

        if ($request->input('origin') === 'detalle') {
            return redirect()->route('proyectos.show', ['proyecto' => $proyecto->id])->with('success', 'Proyecto actualizado con éxito');
        } else {
            return redirect()->route('proyectos.index')->with('success', 'Proyecto actualizado con éxito');
        }
    }

    /**
     * Funcion para enviar a revision el proyecto
     */
    public function revision(Request $request, $id)
    {
        $proyecto = Proyecto::find($id);
        $proyecto->id_estado_proyecto=2;
        $proyecto->save();
        return redirect()->route('proyectos.index');
    }
    /**
     * Funcion para aprobar el proyecto
     */
    public function aprobar(Request $request, $id)
    {
        $proyecto = Proyecto::find($id);
        $proyecto->id_estado_proyecto=3;
        $proyecto->save();
        return redirect()->route('proyectos.index');
    }
    /**
     * Funcion para rechazar el proyecto
     */
    public function rechazar(Request $request, $id)
    {
        $proyecto = Proyecto::find($id);
        $proyecto->id_estado_proyecto=4;
        $proyecto->save();
        return redirect()->route('proyectos.index');
    }
    /**
     * Funcion para iniciar el proyecto
     */
    public function iniciar(Request $request, $id)
    {
        $proyecto = Proyecto::find($id);
        $proyecto->id_estado_proyecto=5;
        $proyecto->save();
        return redirect()->route('proyectos.index');
    }
    /**
     * Funcion para finalizar el proyecto
     */
    public function finalizar(Request $request, $id)
    {
        $proyecto = Proyecto::find($id);
        $proyecto->id_estado_proyecto=6;
        $proyecto->save();
        return redirect()->route('proyectos.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proyecto = Proyecto::find($id);    
        if ($proyecto) {    
            // Obtiene las actividades relacionadas al proyecto
            $actividades = DB::table('actividad')->where('id_proyecto', $proyecto->id)->get();
    
            foreach ($actividades as $actividad) {
                $id_actividad = $actividad->id;
    
                // Elimina asignaciones de recursos relacionadas
                DB::table('asignacion_recurso')->where('id_actividad', $id_actividad)->delete();
    
                // Elimina comentarios relacionados a la actividad
                DB::table('comentario')->where('id_actividad', $id_actividad)->delete();
                
                // Elimina tareas relacionadas a la actividad
                DB::table('tarea')->where('id_actividad', $id_actividad)->delete();
    
                // Elimina miembros relacionados a la actividad
                DB::table('miembro_actividad')->where('id_actividad', $id_actividad)->delete();
            }
    
            // Elimina notificaciones relacionadas al proyecto
            DB::table('notificacion')->where('id_proyecto', $proyecto->id)->delete();

            // Elimina eventos relacionados al proyecto
            DB::table('evento')->where('id_proyecto', $proyecto->id)->delete();

            // Elimina equipo de trabajos relacionados al proyecto
            DB::table('equipo_trabajo')->where('id_proyecto', $proyecto->id)->delete();
    
            // Elimina las actividades relacionadas al proyecto
            DB::table('actividad')->where('id_proyecto', $proyecto->id)->delete();
    
            // Se elimina el proyecto
            $proyecto->delete();
        }
        return redirect()->route('proyectos.index');
    }

        /**
     * Funcion para crear copia de proyecto
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function backup(Request $request, $id)
    {
        $proyecto = Proyecto::find($id);
        
        if (!$proyecto) {
            return redirect()->route('proyectos.index')->with('error', 'No se pudo realizar un respaldo del proyecto');
        }
    
        // Creando una copia del proyecto
        $copiaProyecto = $proyecto->replicate();
        $copiaProyecto->nombre = $proyecto->nombre . '_' . now()->format('Ymd_His');
        $copiaProyecto->save();
    
        // Crear una copia de los eventos del proyecto
        $eventos = Evento::where('id_proyecto', $proyecto->id)->get();
        foreach ($eventos as $evento) {
            $copiaEvento = $evento->replicate();
            $copiaEvento->id_proyecto = $copiaProyecto->id; 
            $copiaEvento->save();

            // Copiar notificaciones de eventos relacionadas a la actividad
            $notificacionesEventos = Evento::where('id_evento', $evento->id)->get();
            foreach ($notificacionesEventos as $notificacionEve) {
                $copiaNotificacionEvento = $notificacionEve->replicate();
                $copiaNotificacionEvento->id_evento = $copiaEvento->id; 
                $copiaNotificacionEvento->id_proyecto = $copiaProyecto->id;
                $copiaNotificacionEvento->save();
            }
        }
     
        // Crear una copia del equipo de trabajo del proyecto
        $equipoTrabajo = EquipoTrabajo::where('id_proyecto', $proyecto->id)->get();

        // Crear una copia de los equipos de trabajo
        $copiasEquiposTrabajo = [];
        foreach ($equipoTrabajo as $equipo) {
            $copiaEquipoTrabajo = $equipo->replicate();
            $copiaEquipoTrabajo->id_proyecto = $copiaProyecto->id;
            $copiaEquipoTrabajo->save();
            $copiasEquiposTrabajo[$equipo->id] = $copiaEquipoTrabajo; // Almacenar copias de equipos de trabajo en un array asociativo por id original
        }
    
        // Crear una copia de las actividades
        $actividades = Actividad::where('id_proyecto', $proyecto->id)->get();
        foreach ($actividades as $actividad) {
            $copiaActividad = $actividad->replicate();
            $copiaActividad->id_proyecto = $copiaProyecto->id;
            $copiaActividad->save();
    
            // Crear una copia de los miembros de la actividad
            $miembrosActividad = MiembroActividad::where('id_actividad', $actividad->id)->get();
            foreach ($miembrosActividad as $miembro) {
                $copiaMiembro = $miembro->replicate();
                $copiaMiembro->id_actividad = $copiaActividad->id;
                if (isset($copiasEquiposTrabajo[$miembro->id_equipo_trabajo])) {
                    $copiaMiembro->id_equipo_trabajo = $copiasEquiposTrabajo[$miembro->id_equipo_trabajo]->id;
                }

                $copiaMiembro->save();
            }
    
            // Crear una copia de la asignacion de recursos de la actividad
            $asignacionesRecursos = AsignacionRecurso::where('id_actividad', $actividad->id)->get();
            foreach ($asignacionesRecursos as $asignacion) {
                $copiaAsignacion = $asignacion->replicate();
                $copiaAsignacion->id_actividad = $copiaActividad->id; 
                $copiaAsignacion->save();
            }
    
            // Crear una copia de las tareas de la actividad
            $tareas = Tarea::where('id_actividad', $actividad->id)->get();
            foreach ($tareas as $tarea) {
                $copiaTarea = $tarea->replicate();
                $copiaTarea->id_actividad = $copiaActividad->id; 
                $copiaTarea->save();
            }
    
            // Copiar registros de comentarios relacionados a la actividad
            $comentarios = Comentario::where('id_actividad', $actividad->id)->get();
            foreach ($comentarios as $comentario) {
                $copiaComentario = $comentario->replicate();
                $copiaComentario->id_actividad = $copiaActividad->id; 
                $copiaComentario->save();
            }
    
            // Copiar notificaciones de activvidades relacionadas a la actividad
            $notificaciones = Notificacion::where('id_actividad', $actividad->id)->get();
            foreach ($notificaciones as $notificacion) {
                $copiaNotificacion = $notificacion->replicate();
                $copiaNotificacion->id_actividad = $copiaActividad->id; 
                $copiaNotificacion->id_proyecto = $copiaProyecto->id;
                $copiaNotificacion->save();
            }
        }
    
        return redirect()->route('proyectos.index')->with('success', 'Se ha realizado un backup del proyecto');
    }    
}
