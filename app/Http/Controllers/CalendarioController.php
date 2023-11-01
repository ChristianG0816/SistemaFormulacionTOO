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
use App\Models\Notificacion;
use App\Models\TipoNotificacion;
use App\Models\Cliente;

class CalendarioController extends Controller
{

    public function index(){
    $usuarioLogueado = Auth::user();
    
    $manoObra = ManoObra::where('id_usuario', $usuarioLogueado->id)->first();
    $gerenteProyecto = Proyecto::where('id_gerente_proyecto', $usuarioLogueado->id)->first();

    //Obtener el id del usuario logueado - En este caso el cliente
    $cliente = Cliente::where('id_usuario', $usuarioLogueado->id)->first();

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
       // Obtén proyectos iniciados relacionados con el cliente
       $proyectosIniciados = Proyecto::where('id_estado_proyecto', EstadoProyecto::where('nombre', 'Iniciado')->first()->id)
       ->where('id_cliente', $cliente->id)
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
        //Obtener el id del usuario logueado - En este caso el cliente
        $cliente = Cliente::where('id_usuario', $usuarioLogueado->id)->first();
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
        } elseif ($cliente) {
            if ($idProyecto == 0) {
                $proyectosDelCliente = Proyecto::where('id_cliente', $cliente->id)
                    ->where('id_estado_proyecto', EstadoProyecto::where('nombre', 'Iniciado')->first()->id)
                    ->pluck('id');
                $actividades = Actividad::whereIn('id_proyecto', $proyectosDelCliente)->get();
            } else {
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
        }
        elseif ($gerenteProyecto) {
        if ($idProyecto == 0) {
            // Si idProyecto es igual a 0, se obtienen todas las actividades relacionadas con proyectos del usuario.
            $proyectosUsuario = Proyecto::where(function ($query) use ($usuarioLogueado) {
                $query->where('id_gerente_proyecto', $usuarioLogueado->id);
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
    
    $request->validate([
        'nombre' => 'required',
        'descripcion' => 'required',
        'direccion' => 'required',
        'fecha_inicio' => 'required',
        'fecha_fin' => 'required|after:fecha_inicio',
        'hora_inicio' => 'required|before:hora_fin',
        'hora_fin' => 'required|after:hora_inicio',
        'fecha_recordatorio' => 'required|after_or_equal:fecha_inicio|before_or_equal:fecha_fin',
        'hora_recordatorio' => 'required',
        'link_reunion' => 'required',
        'proyecto' => 'required|not_in: ""', // Nueva regla de validación
    ]);

    // Obtiene el valor seleccionado del select en el formulario.
    $id_proyecto = $request->input('proyecto');

    // Crea un nuevo evento con "id_proyecto" establecido.

    $evento = new Evento($request->all());
    $evento->id_proyecto = $id_proyecto;
    $evento->save();  

    // Llama a la función envio_notificacion_evento
    $tipo_notificacion_valor = 7;
    $this->envio_notificacion_evento($tipo_notificacion_valor, $evento);
    
}

public function showEvento($idProyecto){
    
    // Obtener el usuario logueado
    $usuarioLogueado = Auth::user();

    // Obtener el mano de obra del usuario logueado
    $manoObra = ManoObra::where('id_usuario', $usuarioLogueado->id)->first();
    // Obtener el id del usuario logueado - En este caso del supervisor
    $gerenteProyecto = Proyecto::where('id_gerente_proyecto', $usuarioLogueado->id)->first();
    // Obtener el id del usuario logueado - En este caso el cliente
    $cliente = Cliente::where('id_usuario', $usuarioLogueado->id)->first();
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
    }elseif($cliente) {
        if ($idProyecto == 0) {
            // Si es cliente y $idProyecto es igual a 0, puedes agregar la lógica que deseas aquí.
            // Por ejemplo, puedes obtener todos los eventos relacionados con los proyectos iniciados del cliente.
            $proyectosDelCliente = Proyecto::where('id_cliente', $cliente->id)
                ->where('id_estado_proyecto', EstadoProyecto::where('nombre', 'Iniciado')->first()->id)
                ->pluck('id');
            $eventos = Evento::whereIn('id_proyecto', $proyectosDelCliente)->get();
        } else {
            // Si es cliente y $idProyecto no es igual a 0, verifica si el proyecto específico está iniciado.
            $proyecto = Proyecto::find($idProyecto);
            if ($proyecto && $proyecto->estado_proyecto->nombre === 'Iniciado') {
                $eventos = Evento::where('id_proyecto', $idProyecto)->get();
            } else {
                $eventos = [];
            }
        }
    } elseif ($gerenteProyecto) {
        if ($idProyecto == 0) {
            // Si idProyecto es igual a 0, obtén todos los proyectos iniciados relacionados con el gerente.
            $proyectosIniciados = Proyecto::where('id_estado_proyecto', EstadoProyecto::where('nombre', 'Iniciado')->first()->id)
                ->where('id_gerente_proyecto', $usuarioLogueado->id)
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

    public function envio_notificacion_evento($tipo_notificacion_valor, $evento){
        
        $usuario = Auth::user();

        if($evento->proyecto->id_gerente_proyecto!=$usuario->id){
        //Envío de notificacion a supervisor
        $notificacion = new Notificacion();
        $notificacion->id_usuario = $evento->proyecto->id_gerente_proyecto;
        $notificacion->id_tipo_notificacion = $tipo_notificacion_valor;
        $tipoNotificacion = TipoNotificacion::find($tipo_notificacion_valor);

        if ($tipoNotificacion) {
            $descripcion=$tipoNotificacion->descripcion;
            $descripcion2 = str_replace('{{nombre}}', $evento->nombre, $descripcion);
            $notificacion->descripcion = $descripcion2;
            $notificacion->ruta = $tipoNotificacion->ruta;
        }
        
        $notificacion->id_proyecto = $evento->id_proyecto;
        $notificacion->leida = false;
        $notificacion->save();

    }

        //Envio de notificación para mano de obra
        $EquipoTrabajo = EquipoTrabajo::where("id_proyecto", $evento->id_proyecto)->get();
            foreach ($EquipoTrabajo as $miembro) {
                if($miembro->mano_obra->id_usuario!=$usuario->id){
                $notificacion = new Notificacion();
                $notificacion->id_usuario = $miembro->mano_obra->id_usuario;
                $notificacion->id_tipo_notificacion = $tipo_notificacion_valor;
                $tipoNotificacion = TipoNotificacion::find($tipo_notificacion_valor);
                if ($tipoNotificacion) {
                    $descripcion=$tipoNotificacion->descripcion;
                    $descripcion2 = str_replace('{{nombre}}', $evento->nombre, $descripcion);
                    $notificacion->descripcion = $descripcion2;
                    $notificacion->ruta = $tipoNotificacion->ruta;
                }

                $notificacion->id_proyecto = $evento->id_proyecto;
                $notificacion->leida = false;
                $notificacion->save();
            }
        }

        //Envio de notificación para un cliente
        if($evento->proyecto->cliente->id_usuario!=$usuario->id){
        $notificacion = new Notificacion();
        $notificacion->id_usuario = $evento->proyecto->cliente->id_usuario;
        $notificacion->id_tipo_notificacion = $tipo_notificacion_valor;
        $tipoNotificacion = TipoNotificacion::find($tipo_notificacion_valor);
        if ($tipoNotificacion) {
            $descripcion=$tipoNotificacion->descripcion;
            $descripcion2 = str_replace('{{nombre}}', $evento->nombre, $descripcion);
            $notificacion->descripcion = $descripcion2;
            $notificacion->ruta = $tipoNotificacion->ruta;
        }
        $notificacion->id_proyecto = $evento->id_proyecto;
        $notificacion->leida = false;
        $notificacion->save();
        }
    }

}
