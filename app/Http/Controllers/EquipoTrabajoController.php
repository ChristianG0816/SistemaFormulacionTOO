<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyecto;
use App\Models\EquipoTrabajo;
use App\Models\ManoObra;
use App\Models\User;
use App\Models\Actividad;
use App\Models\Recurso;
use App\Models\AsignacionRecurso;
use DataTables;

class EquipoTrabajoController extends Controller
{
    function __construct(){
        //Defincion de permisos
        //$this->middleware('permission:ver-equipo-trabajo')->only(['index']);
        //$this->middleware('permission:crear-equipo-trabajo')->only(['create', 'store']);
        //$this->middleware('permission:eliminar-equipo-trabajo')->only(['destroy']);
    }

    public function list(Request $request, $proyectoId)
    {
        // Convertir $proyectoId a un entero
        $proyectoId = (int)$proyectoId;

        $data = EquipoTrabajo::where('id_proyecto', $proyectoId)
        ->with(['mano_obra.usuario'])
        ->get();

        return datatables()->of($data)
            ->addColumn('usuario_name', function ($row) {
                // Acceder a la columna 'name' de la relación 'id_mano_obra.id_usuario'
                return $row->mano_obra->usuario->name . ' ' . $row->mano_obra->usuario->last_name;
            })
            ->addColumn('usuario_email', function ($row) {
                // Acceder a la columna 'email' de la relación 'id_mano_obra.id_usuario'
                return $row->mano_obra->usuario->email;
            })
            ->addColumn('telefono', function ($row) {
                // Acceder a la columna 'telefono' de la relación 'id_mano_obra'
                return $row->mano_obra->persona->telefono;
            })
            ->addColumn('action', function ($row) {
                $btnDetalle = '<a href="' . route('miembros.show', $row->mano_obra->id) . '" class="btn btn-outline-secondary btn-sm">Mostrar</a>';
                $btnEliminar = '<button class="delete btn btn-outline-danger btn-sm ml-1" data-id="' . $row->mano_obra->id . '">Eliminar</button>';
                return $btnDetalle . ' ' . $btnEliminar;
            })            
            ->rawColumns(['action'])
            ->make(true);
    }

    public function listMiembrosNoAsignados($proyectoId)
    {
        // Convertir $proyectoId a un entero
        $proyectoId = (int)$proyectoId;

        // Obtener los registros de ManoObra que no están asociados al proyecto
        $miembrosNoAsignados = ManoObra::whereDoesntHave('equipos', function ($query) use ($proyectoId) {
            $query->where('id_proyecto', $proyectoId);
        })
        ->with('usuario:id,name,last_name') // Cargamos la relación 'usuario' y seleccionamos los campos necesarios
        ->with('persona:telefono')
        ->select('id','id_usuario')
        ->get();

        // Concatenar 'name' y 'last_name' y asignar el resultado a un nuevo atributo 'full_name'
        $miembrosNoAsignados->each(function ($miembro) {
            $miembro->full_name = $miembro->usuario->name . ' ' . $miembro->usuario->last_name;
        });

        return response()->json($miembrosNoAsignados);
    }

    public function getMiembro(Request $request, $id)
    {
        $miembro = ManoObra::with('usuario', 'persona')->findOrFail($id);

        // Concatenar 'name' y 'last_name' en un nuevo atributo 'full_name'
        $miembro->full_name = $miembro->usuario->name . ' ' . $miembro->usuario->last_name;

        return response()->json($miembro);
    }

    public function crearEquiposTrabajo(Request $request)
    {
        $data = $request->all();
        try {
        if (!empty($data['id_proyecto']) && !empty($data['id_mano_obra'])) {
            $id_proyecto = intval($data['id_proyecto']);
            $id_mano_obra = intval($data['id_mano_obra']);
            $costo_recurso = 0;
            $costo_mano_obra = 0;
            $costo_equipo_trabajo = 0;

            $proyecto = Proyecto::find($id_proyecto);
            
            $costo_mano_obra = ManoObra::where('id', $id_mano_obra)->sum('costo_servicio');

            $costo_equipo_trabajo = EquipoTrabajo::where('id_proyecto', $id_proyecto)
            ->with('mano_obra') // Cargar la relación miembros
            ->get()
            ->pluck('mano_obra.costo_servicio') // Obtener los valores de costo_servicio de la relación
            ->sum();

            //Obtener actividades por id_proyecto
            $actividades = Actividad::where('id_proyecto', $id_proyecto)->get();
            if($actividades){
                foreach($actividades as $actividad){
                    $recursos = AsignacionRecurso::where('id_actividad', $actividad->id)->get();
                    if($recursos){
                        foreach($recursos as $recurso){
                            $costo_recurso_individual = Recurso::where('id', $recurso->id_recurso)->sum('costo');
                            $costo_recurso += $costo_recurso_individual * $recurso->cantidad;
                        }
                    }
                }
            }

            $costo_total = intval($costo_mano_obra) + intval($costo_equipo_trabajo) + intval($costo_recurso);
            if (intval($proyecto->presupuesto) >= intval($costo_total)) {
                // Crea un registro en el modelo EquipoTrabajo con los datos recibidos
                $equipoTrabajo = EquipoTrabajo::create([
                    'id_proyecto' => $id_proyecto,
                    'id_mano_obra' => $id_mano_obra,
                ]);
        
                return response()->json([
                    'success' => true,
                    'message' => 'Se ha agregado un miembro al equipo de trabajo con éxito',
                    'equipo_creado' => $equipoTrabajo
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Error al agregar el miembro al equipo de trabajo. El presupuesto del proyecto no es suficiente'
            ]);
        }
        } catch (\Exception $e) {
            // Registra la excepción en el archivo de registro o devuelve un mensaje de error detallado
            return response()->json([
                'success' => false,
                'message' => 'Error al agregar el miembro al equipo de trabajo'
            ]);
        }
    }
       
    
    public function eliminarEquipos(Request $request)
    {
        try {
            $id_proyecto = intval($request->input('id_proyecto'));
            $id_mano_obra = intval($request->input('id_mano_obra'));

            if (!empty($id_proyecto) && !empty($id_mano_obra)) {
                // Busca y elimina el equipo de trabajo correspondiente según los IDs recibidos
                $equipoTrabajo = EquipoTrabajo::where('id_proyecto', $id_proyecto)
                    ->where('id_mano_obra', $id_mano_obra)
                    ->delete();

                if ($equipoTrabajo) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Se ha eliminado el miembro del equipo de trabajo con éxito'
                    ]);
                }
            }
            return response()->json([
                'success' => false,
                'message' => 'No se encontró ningún miembro del equipo de trabajo para eliminar'
            ]);
        } catch (\Exception $e) {
            // Registra la excepción en el archivo de registro o devuelve un mensaje de error detallado
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al eliminar el miembro del equipo de trabajo. Verifica que el miembro no esté asignado a una actividad'
            ]);
        }
    }
    
}
