<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use Illuminate\Support\Facades\Auth;
use App\Models\EquipoTrabajo;
use App\Models\ManoObra;
use App\Models\MiembroActividad;
use App\Models\Proyecto;
use App\Models\User;
use Spatie\Permission\Traits\HasRoles;

class CalendarioController extends Controller
{

    public function index()
    {
        $usuarioLogueado = Auth::user();
        $manoObra = ManoObra::where('id_usuario', $usuarioLogueado->id)->first();
        // Obtener el id del usuario logueado - En este caso del supervisor
        $Supervisor = Proyecto::where('id_dueno', $usuarioLogueado->id)->first();
        //Obtener el id del usuario logueado - En este caso el cliente
        $cliente = Proyecto::where('id_cliente', $usuarioLogueado->id)->first();

        $esGerente = $usuarioLogueado->hasRole('Gerente');

        if ($manoObra) {
            $proyectos = Proyecto::whereIn('id', function ($query) use ($manoObra) {
                $query->select('id_proyecto')
                    ->from('equipo_trabajo')
                    ->where('id_mano_obra', $manoObra->id);
            })->get();
        } elseif ($Supervisor) {
            $proyectos = Proyecto::where('id_dueno', $usuarioLogueado->id)->get();
        } elseif ($cliente) {
            $proyectos = Proyecto::where('id_cliente', $usuarioLogueado->id)->get();
        } elseif ($esGerente) {
            $proyectos = Proyecto::all();
        } else {
            $proyectos = [];
        }

        return view('calendario.index', ['proyectos' => $proyectos]);
    }

    public function show($idProyecto)
    {
        // Obtener el usuario logueado
        $usuarioLogueado = Auth::user();

        // Obtener el mano de obra del usuario logueado
        $manoObra = ManoObra::where('id_usuario', $usuarioLogueado->id)->first();
        // Obtener el id del usuario logueado - En este caso del supervisor
        $Supervisor = Proyecto::where('id_dueno', $usuarioLogueado->id)->first();
        // Obtener el id del usuario logueado - En este caso el cliente
        $cliente = Proyecto::where('id_cliente', $usuarioLogueado->id)->first();
        // Obtener el rol de gerente
        $Gerente = $usuarioLogueado->hasRole('Gerente');

        if ($manoObra) {
            $equipoTrabajo = EquipoTrabajo::where('id_mano_obra', $manoObra->id)->get();
            $eventos = [];

            foreach ($equipoTrabajo as $equipo) {
                $miembrosActividad = MiembroActividad::where('id_equipo_trabajo', $equipo->id)->get();
                foreach ($miembroActividad as $miembroActividad) {
                    $actividad = Actividad::find($miembroActividad->id_actividad);
                    if ($idProyecto == 0 || ($actividad && $actividad->id_proyecto == $idProyecto)) {
                        $evento = [
                            'id' => $actividad->id,
                            'title' => $actividad->nombre,
                            'start' => $actividad->fecha_fin,
                            'end' => $actividad->fecha_fin,
                            //'proyecto' => $actividad->id_proyecto,
                        ];
                        array_push($eventos, $evento);
                    }
                }
            }

            return response()->json($eventos);
        } elseif ($Gerente) {
            if ($idProyecto == 0) {
                // Si es Gerente y $idProyecto es igual a 0, obtén todas las actividades.
                $actividades = Actividad::all();
            } else {
                // Si es Gerente y $idProyecto no es igual a 0, filtra las actividades por proyecto.
                $actividades = Actividad::where('id_proyecto', $idProyecto)->get();
            }
            $eventos = [];

            foreach ($actividades as $actividad) {
                $evento = [
                    'id' => $actividad->id,
                    'title' => $actividad->nombre,
                    'start' => $actividad->fecha_fin,
                    'end' => $actividad->fecha_fin,
                ];
                array_push($eventos, $evento);
            }

            return response()->json($eventos);
        } elseif ($Supervisor || $cliente) {
            if ($idProyecto == 0) {
                // Si idProyecto es igual a 0, se obtienen todas las actividades relacionadas con proyectos del usuario.
                $proyectosUsuario = Proyecto::where(function ($query) use ($usuarioLogueado) {
                    $query->where('id_dueno', $usuarioLogueado->id)
                        ->orWhere('id_cliente', $usuarioLogueado->id);
                })->pluck('id');
                $actividades = Actividad::whereIn('id_proyecto', $proyectosUsuario)->get();
            } else {
                // Si idProyecto no es igual a 0, se obtienen las actividades relacionadas con el proyecto específico.
                $actividades = Actividad::where('id_proyecto', $idProyecto)->get();
            }

            //dd($actividades);
            $eventos = [];

            foreach ($actividades as $actividad) {
                $evento = [
                    'id' => $actividad->id,
                    'title' => $actividad->nombre,
                    'start' => $actividad->fecha_fin,
                    'end' => $actividad->fecha_fin,
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
}
