<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use Illuminate\Support\Facades\Auth;
use App\Models\EquipoTrabajo;
use App\Models\ManoObra;
use App\Models\EstadoProyecto;
use App\Models\Proyecto;
use App\Models\User; 
use Spatie\Permission\Traits\HasRoles;
use App\Models\Evento;
use PhpParser\Node\Expr\BinaryOp\Equal;
use App\Models\EstadoActividad;

class CalendarioController extends Controller
{

    public function index(){
    $usuarioLogueado = Auth::user();
    $manoObra = ManoObra::where('id_usuario', $usuarioLogueado->id)->first();
    $gerenteProyecto = Proyecto::where('id_gerente_proyecto', $usuarioLogueado->id)->first();

    //Obtener el id del usuario logueado - En este caso el cliente
    $cliente = Proyecto::where('id_cliente', $usuarioLogueado->id)->first();

    $GerenteGeneral = $usuarioLogueado->hasRole('Gerente');

    if ($manoObra) {
        // Obtén proyectos iniciados relacionados con la mano de obra
        $proyectosIniciados = Proyecto::where('id_estado_proyecto', EstadoProyecto::where('nombre', 'Iniciado')->first()->id)
            ->whereIn('id', function ($query) use ($manoObra) {
                $query->select('id_proyecto')
                    ->from('equipo_trabajo')
                    ->where('id_mano_obra', $manoObra->id);
            })->get();
    } elseif ($gerenteProyecto) {
        // Obtén proyectos iniciados relacionados con el gerente de proyecto
        $proyectosIniciados = Proyecto::where('id_estado_proyecto', EstadoProyecto::where('nombre', 'Iniciado')->first()->id)
            ->where('id_gerente_proyecto', $usuarioLogueado->id)
            ->get();
    }  elseif ($cliente) {
       // Obtén proyectos iniciados relacionados con el gerente de proyecto
       $proyectosIniciados = Proyecto::where('id_estado_proyecto', EstadoProyecto::where('nombre', 'Iniciado')->first()->id)
       ->where('id_cliente', $usuarioLogueado->id)
       ->get();
    } 
    elseif ($GerenteGeneral) {
        // Si es un Gerente General, obtén todos los proyectos iniciados
        $proyectosIniciados = Proyecto::where('id_estado_proyecto', EstadoProyecto::where('nombre', 'Iniciado')->first()->id)->get();
    } else {
        $proyectosIniciados = [];
    }

    return view('calendario.index', ['proyectos' => $proyectosIniciados]);
}



    public function show($idProyecto)
    {
        // Obtener el usuario logueado
        $usuarioLogueado = Auth::user();

        // Obtener el mano de obra del usuario logueado
        $manoObra = ManoObra::where('id_usuario', $usuarioLogueado->id)->first();
        // Obtener el id del usuario logueado - En este caso del supervisor
        $gerenteProyecto = Proyecto::where('id_gerente_proyecto', $usuarioLogueado->id)->first();
        // Obtener el id del usuario logueado - En este caso el cliente
        $cliente = Proyecto::where('id_cliente', $usuarioLogueado->id)->first();
        // Obtener el rol de gerente
        $GerenteGeneral = $usuarioLogueado->hasRole('Gerente');

        if ($manoObra) {
            $equipoTrabajo = EquipoTrabajo::where('id_mano_obra', $manoObra->id)->get();
            $eventos = [];
        
            foreach ($equipoTrabajo as $equipo) {
                $actividades = Actividad::where('id_responsable', $equipo->id)->get();
                foreach ($actividades as $actividad) {
                    // Verificar si el proyecto relacionado con la actividad está iniciado
                    $proyecto = Proyecto::find($actividad->id_proyecto);
                    if ($proyecto && $proyecto->estado_proyecto->nombre === 'Iniciado') {
                        if ($idProyecto == 0 || ($actividad && $actividad->id_proyecto == $idProyecto)) {
                            $evento = [
                                'id' => $actividad->id,
                                'title' => $actividad->nombre,
                                'start' => $actividad->fecha_fin,
                                'end' => $actividad->fecha_fin,
                                'tipo' => 'actividad',
                            ];
                            array_push($eventos, $evento);
                        }
                    }
                }
            }
            return response()->json($eventos);
        } elseif ($GerenteGeneral) {
            if ($idProyecto == 0) {
                
                // Si es Gerente y $idProyecto es igual a 0, obtén todas las actividades.
                $proyectosIniciados = Proyecto::whereHas('estado_proyecto', function ($query) {
                    $query->where('nombre', 'Iniciado');
                })->pluck('id');
                $actividades = Actividad::whereIn('id_proyecto', $proyectosIniciados)->get();

            } else {
                // Si es Gerente y $idProyecto no es igual a 0, filtra las actividades por proyecto.
                $proyecto = Proyecto::find($idProyecto);
                if ($proyecto && $proyecto->estado_proyecto->nombre === 'Iniciado') {
                    $actividades = Actividad::where('id_proyecto', $idProyecto)->get();
                } else {
                    $actividades = [];
                }
            }

            $eventos = [];

            foreach ($actividades as $actividad) {
                $evento = [
                    'id' => $actividad->id,
                    'title' => $actividad->nombre,
                    'start' => $actividad->fecha_fin,
                    'end' => $actividad->fecha_fin,
                    'tipo' => 'actividad',
                ];
                array_push($eventos, $evento);
            }

            return response()->json($eventos);
        } elseif ($gerenteProyecto || $cliente) {
        if ($idProyecto == 0) {
            // Si idProyecto es igual a 0, se obtienen todas las actividades relacionadas con proyectos del usuario.
            $proyectosUsuario = Proyecto::where(function ($query) use ($usuarioLogueado) {
                $query->where('id_gerente_proyecto', $usuarioLogueado->id)
                ->orWhere('id_cliente', $usuarioLogueado->id);
            })->pluck('id');

            // Filtrar proyectos iniciados
            $proyectosIniciados = Proyecto::where('id_estado_proyecto', EstadoProyecto::where('nombre', 'Iniciado')->first()->id)->pluck('id');

            // Obtener las actividades relacionadas con proyectos iniciados del usuario
            $actividades = Actividad::whereIn('id_proyecto', $proyectosUsuario)
                ->whereIn('id_proyecto', $proyectosIniciados)
                ->get();
        } else {
            // Si idProyecto no es igual a 0, se obtienen las actividades relacionadas con el proyecto específico.
            $proyecto = Proyecto::find($idProyecto);

        if ($proyecto && $proyecto->estado_proyecto->nombre === 'Iniciado') {
            $actividades = Actividad::where('id_proyecto', $idProyecto)->get();
        } else {
            $actividades = [];
        }
    }
            //dd($actividades);
            $eventos = [];

            foreach ($actividades as $actividad) {
                $evento = [
                    'id' => $actividad->id,
                    'title' => $actividad->nombre,
                    'start' => $actividad->fecha_fin,
                    'end' => $actividad->fecha_fin,
                    'tipo' => 'actividad',
                ];
                array_push($eventos, $evento);
            }

            return response()->json($eventos);
        }

        return response()->json([]); // En caso de que no se encuentren datos.
    }

    public function consultarActividad($id)
    {
        $actividad = Actividad::find($id);
        return response()->json($actividad);
    }

    //Funcionalidades de Eventos

public function GuardarEvento(Request $request){
    request()->validate(Evento::$rules);

    // Obtiene el valor seleccionado del select en el formulario.
    $id_proyecto = $request->input('proyecto');

    // Crea un nuevo evento con "id_proyecto" establecido.

    $evento = new Evento($request->all());
    $evento->id_proyecto = $id_proyecto;
    $evento->save();

}

public function showEvento($idProyecto){
    
    // Obtener el usuario logueado
    $usuarioLogueado = Auth::user();

    // Obtener el mano de obra del usuario logueado
    $manoObra = ManoObra::where('id_usuario', $usuarioLogueado->id)->first();
    // Obtener el id del usuario logueado - En este caso del supervisor
    $gerenteProyecto = Proyecto::where('id_gerente_proyecto', $usuarioLogueado->id)->first();
    // Obtener el id del usuario logueado - En este caso el cliente
    $cliente = Proyecto::where('id_cliente', $usuarioLogueado->id)->first();
    // Obtener el rol de gerente
    $GerenteGeneral = $usuarioLogueado->hasRole('Gerente');

    if ($manoObra) {
        if ($idProyecto == 0) {
            $mano = ManoObra::where(function ($query) use ($usuarioLogueado) {
                $query->where('id_usuario', $usuarioLogueado->id);
            })->pluck('id');
    
            // Obtén proyectos iniciados relacionados con la mano de obra
            $proyectosIniciados = Proyecto::where('id_estado_proyecto', EstadoProyecto::where('nombre', 'Iniciado')->first()->id)
                ->whereIn('id', function ($query) use ($mano) {
                    $query->select('id_proyecto')
                        ->from('equipo_trabajo')
                        ->whereIn('id_mano_obra', $mano);
                })
                ->pluck('id');
    
            // Obtén los eventos relacionados con los proyectos iniciados
            $eventos = Evento::whereIn('id_proyecto', $proyectosIniciados)->get();
        } else {
            // Si $idProyecto no es igual a 0, verifica si el proyecto específico está iniciado.
            $proyecto = Proyecto::find($idProyecto);
    
            if ($proyecto && $proyecto->estado_proyecto->nombre === 'Iniciado') {
                $eventos = Evento::where('id_proyecto', $idProyecto)->get();
            } else {
                $eventos = [];
            }
        }
    }
    elseif ($gerenteProyecto || $cliente) {
        if ($idProyecto == 0) {
            // Si idProyecto es igual a 0, obtén todos los proyectos iniciados relacionados con el gerente.
            $proyectosIniciados = Proyecto::where('id_estado_proyecto', EstadoProyecto::where('nombre', 'Iniciado')->first()->id)
                ->where('id_gerente_proyecto', $usuarioLogueado->id)
                ->orWhere('id_cliente', $usuarioLogueado->id)
                ->pluck('id');
    
            // Obtén los eventos relacionados con los proyectos iniciados
            $eventos = Evento::whereIn('id_proyecto', $proyectosIniciados)->get();
        } else {
            // Si idProyecto no es igual a 0, verifica si el proyecto específico está iniciado.
            $proyecto = Proyecto::find($idProyecto);
    
            if ($proyecto && $proyecto->estado_proyecto->nombre === 'Iniciado') {
                $eventos = Evento::where('id_proyecto', $idProyecto)->get();
            } else {
                $eventos = [];
            }
        }
    }
    elseif ($GerenteGeneral) {
        if ($idProyecto == 0) {
            // Si idProyecto es igual a 0, obtén todos los proyectos iniciados.
            $proyectosIniciados = Proyecto::where('id_estado_proyecto', EstadoProyecto::where('nombre', 'Iniciado')->first()->id)->pluck('id');
    
            // Obtén los eventos relacionados con los proyectos iniciados
            $eventos = Evento::whereIn('id_proyecto', $proyectosIniciados)->get();
        } else {
            // Si idProyecto no es igual a 0, verifica si el proyecto específico está iniciado.
            $proyecto = Proyecto::find($idProyecto);
    
            if ($proyecto && $proyecto->estado_proyecto->nombre === 'Iniciado') {
                $eventos = Evento::where('id_proyecto', $idProyecto)->get();
            } else {
                $eventos = [];
            }
        }
    }
    
    $eventosData = [];
    foreach ($eventos as $evento) {
        $eventoData = [
            'id' => $evento->id,
            'title' => $evento->nombre,
            'start' => $evento->fecha_fin,
            'end' => $evento->fecha_fin,
            'descripcion' => $evento->descripcion,
            'tipo' => 'evento', // Se agrega para que abra el modal dependiendo del evento que tenga
            'color' => '#FF5733', 
            
        ];
        array_push($eventosData, $eventoData);
    }

    return response()->json($eventosData);
}

public function consultarEvento($id)
    {
        $evento = Evento::find($id);
        return response()->json($evento);
    }

    public function eliminarEvento($id)
    {
        $evento = Evento::find($id)->delete();
        return response()->json($evento);
    }

    public function actualizarEvento(Request $request, Evento $evento)
    {
        request()->validate(Evento::$rules);
        $evento->update($request->all());
        return response()->json($evento);

    }

    //Obtenemos el nombre del proyecto
    public function showId($id){
        $proyecto=Proyecto::find($id);
        return response()->json($proyecto);
    }

    //Obtenemos el nombre del estadoDeLaActividad
    public function showEstadoId($id){
        $estado=EstadoActividad::find($id);
        return response()->json($estado);
    }


}
