<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EquipoTrabajo;
use App\Models\ManoObra;
use App\Models\User;
use App\Models\MiembroActividad;
use DataTables;

class MiembroActividadController extends Controller
{
    public function list(Request $request, $actividadId)
    {
        // Convertir $proyectoId a un entero
        $actividadId = (int)$actividadId;

        $data = MiembroActividad::where('id_actividad', $actividadId)
        ->with(['equipo_trabajo.mano_obra'])
        ->with(['equipo_trabajo.mano_obra.usuario'])
        ->get();
        return datatables()->of($data)
            ->addColumn('usuario_name', function ($row) {
                // Acceder a la columna 'name' de la relación 'id_mano_obra.id_usuario'
                return $row->equipo_trabajo->mano_obra->usuario->name . ' ' . $row->equipo_trabajo->mano_obra->usuario->last_name;
            })
            ->addColumn('usuario_email', function ($row) {
                // Acceder a la columna 'email' de la relación 'id_mano_obra.id_usuario'
                return $row->equipo_trabajo->mano_obra->usuario->email;
            })
            ->addColumn('costo', function ($row) {
                // Verificar si la relación 'mano_obra' existe
                if ($row->equipo_trabajo->mano_obra) {
                    return $row->equipo_trabajo->mano_obra->costo_servicio;
                } else {
                    // Si la relación 'mano_obra' no existe, puedes manejarlo de alguna manera
                    return 'Sin costo'; // O cualquier otro valor predeterminado que desees
                }
            })            
            ->addColumn('action', function ($row) {
                // Agregar botones de acciones (editar, eliminar, etc.) si es necesario
                $btnDetalle = '<a href="' . route('miembros.show', $row->equipo_trabajo->mano_obra->id) . '" class="edit btn btn-primary btn-sm">Detalle</a>';
                $btnEliminar = '<button class="delete btn btn-danger btn-sm" data-id="' . $row->id . '">Eliminar</button>';
                return $btnDetalle . ' ' . $btnEliminar;
            })            
            ->rawColumns(['action'])
            ->make(true);
    }

    public function listMiembrosNoAsignados($actividadId, $proyectoId)
    {
        // Convertir $actividadId a un entero
        $actividadId = (int)$actividadId;
        $proyectoId = (int)$proyectoId;

        // Obtener los registros de EquipoTrabajo que no están asociados a la actividad y que si pertenecen al proyecto al cual esta asociado la actividad
        
        // Obtener los registros de EquipoTrabajo que no están asociados a la actividad y que pertenecen al proyecto
        $miembrosNoAsignados = EquipoTrabajo::where('id_proyecto', $proyectoId)
        ->whereDoesntHave('miembros', function ($query) use ($actividadId) {
            $query->where('id_actividad', $actividadId);
        })
        ->get();

        // Concatenar 'name' y 'last_name' y asignar el resultado a un nuevo atributo 'full_name'
        $miembrosNoAsignados->each(function ($miembro) {
            $miembro->full_name = $miembro->mano_obra->usuario->name . ' ' . $miembro->mano_obra->usuario->last_name;
        });

        return response()->json($miembrosNoAsignados);
    }

    public function getMiembroEquipo(Request $request, $id)
    {
        $miembro = EquipoTrabajo::findOrFail($id);
    
        // Concatenar 'name' y 'last_name' en un nuevo atributo 'full_name'
        $miembro->full_name = $miembro->mano_obra->usuario->name . ' ' . $miembro->mano_obra->usuario->last_name;
    
        return response()->json($miembro);
    }
    
    public function crearMiembrosActividad(Request $request)
    {
        $data = $request->all();
    
        if (!empty($data['id_actividad']) && !empty($data['id_equipo_trabajo'])) {
            $id_actividad = intval($data['id_actividad']);
            $id_equipo_trabajo = intval($data['id_equipo_trabajo']);
            
            // Crea un registro en el modelo EquipoTrabajo con los datos recibidos
            $miembroActividad = MiembroActividad::create([
                'id_actividad' => $id_actividad,
                'id_equipo_trabajo' => $id_equipo_trabajo,
                // Agrega más campos aquí según tus necesidades
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Miembro agregado a la actividad correctamente',
                'equipo_creado' => $miembroActividad
            ]);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Datos inválidos para agregar el miembro a la actividad'
        ]);
    }

    public function eliminarMiembrosActividad(Request $request)
    {
        try {
            $id = intval($request->input('id'));

            if (!empty($id)) {
                // Busca y elimina el equipo de trabajo correspondiente según los IDs recibidos
                $miembroActividad = MiembroActividad::where('id', $id)
                    ->delete();

                if ($miembroActividad) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Miembro de la actividad eliminado correctamente'
                    ]);
                }
            }
            return response()->json([
                'success' => false,
                'message' => 'No se encontró ningún miembro de la actividad para eliminar'
            ]);
        } catch (\Exception $e) {
            // Registra la excepción en el archivo de registro o devuelve un mensaje de error detallado
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al eliminar el miembro de la actividad: ' . $e->getMessage()
            ]);
        }
    }

}
