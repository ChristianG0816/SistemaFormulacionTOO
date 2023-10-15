<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use Illuminate\Support\Facades\Auth;
use App\Models\EquipoTrabajo;
use App\Models\ManoObra;
use App\Models\MiembroActividad;
use App\Models\Proyecto;

class CalendarioController extends Controller
{

    public function index()
    {
        $usuarioLogueado = Auth::user();
        $manoObra = ManoObra::where('id_usuario', $usuarioLogueado->id)->first();

        if ($manoObra) {
            $proyectos = Proyecto::whereIn('id', function ($query) use ($manoObra) {
                $query->select('id_proyecto')
                    ->from('equipo_trabajo')
                    ->where('id_mano_obra', $manoObra->id);
            })->get();
        } else {
            $proyectos = [];
        }

        return view('calendario.index', ['proyectos' => $proyectos]);
    }

    public function show($idProyecto)
    {
        // Obtener el usuario logueado
        $usuarioLogueado = Auth::user();
        
        // Obtener la mano de obra del usuario logueado
        $manoObra = ManoObra::where('id_usuario', $usuarioLogueado->id)->first();

        if ($manoObra) {
            $equipoTrabajo = EquipoTrabajo::where('id_mano_obra', $manoObra->id)->get();
            
            $eventos = [];
            
            foreach ($equipoTrabajo as $equipo) {
                $miembrosActividad = MiembroActividad::where('id_equipo_trabajo', $equipo->id)->get();
                foreach ($miembrosActividad as $miembroActividad) {
                    $actividad = Actividad::find($miembroActividad->id);
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
        }
        
        return response()->json([]); // En caso de que no se encuentren datos.
    }
    
    public function consultarActividad($id)
    {
        $actividad = Actividad::find($id);
        return response()->json($actividad);
    }

}
