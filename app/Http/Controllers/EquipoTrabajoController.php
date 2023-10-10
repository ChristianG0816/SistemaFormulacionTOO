<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EquipoTrabajo;
use App\Models\ManoObra;
use App\Models\User;
use DataTables;

class EquipoTrabajoController extends Controller
{
    function __construct(){
        //Defincion de permisos
        //$this->middleware('permission:ver-equipo-trabajo')->only(['index']);
        //$this->middleware('permission:crear-equipo-trabajo')->only(['create', 'store']);
        //$this->middleware('permission:eliminar-equipo-trabajo')->only(['destroy']);
    }

    public function index()
    {
        $proyectoId = 1; // Aquí debes recuperar el ID del proyecto actual
        return view('equipos.crear', compact('proyectoId'));
    }

    public function crearEquiposTrabajo(Request $request)
    {
        $data = $request->all();
    
        if (!empty($data['id_proyecto']) && !empty($data['id_mano_obra'])) {
            $id_proyecto = intval($data['id_proyecto']);
            $id_mano_obra = intval($data['id_mano_obra']);
            
            // Crea un registro en el modelo EquipoTrabajo con los datos recibidos
            $equipoTrabajo = EquipoTrabajo::create([
                'id_proyecto' => $id_proyecto,
                'id_mano_obra' => $id_mano_obra,
                // Agrega más campos aquí según tus necesidades
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Equipo de trabajo creado correctamente',
                'equipo_creado' => $equipoTrabajo
            ]);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Datos inválidos para crear equipo de trabajo'
        ]);
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
                        'message' => 'Miembro del equipo de trabajo eliminado correctamente'
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
                'message' => 'Ocurrió un error al eliminar el miembro del equipo de trabajo: ' . $e->getMessage()
            ]);
        }
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
                return $row->mano_obra->telefono;
            })
            ->addColumn('action', function ($row) {
                $btnDetalle = '<a href="' . route('miembros.show', $row->mano_obra->id) . '" class="edit btn btn-primary btn-sm">Detalle</a>';
                $btnEliminar = '<button class="delete btn btn-danger btn-sm" data-id="' . $row->mano_obra->id . '">Eliminar</button>';
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
        ->select('id', 'telefono', 'id_usuario')
        ->get();

        // Concatenar 'name' y 'last_name' y asignar el resultado a un nuevo atributo 'full_name'
        $miembrosNoAsignados->each(function ($miembro) {
            $miembro->full_name = $miembro->usuario->name . ' ' . $miembro->usuario->last_name;
        });

        return response()->json($miembrosNoAsignados);
    }

    public function getMiembro(Request $request, $id)
    {
        $miembro = ManoObra::with('usuario')->findOrFail($id);

        // Concatenar 'name' y 'last_name' en un nuevo atributo 'full_name'
        $miembro->full_name = $miembro->usuario->name . ' ' . $miembro->usuario->last_name;

        return response()->json($miembro);
    }
}
