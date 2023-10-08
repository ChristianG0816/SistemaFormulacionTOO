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
        $data = $request->all(); // Recupera los datos enviados desde la solicitud AJAX

        $equiposTrabajoCreados = [];

        foreach ($data as $equipoData) {
            if (!empty($equipoData['id_proyecto']) && !empty($equipoData['id_mano_obra'])) {
                // Crea un registro en el modelo EquipoTrabajo con los datos recibidos
                $equipoTrabajo = EquipoTrabajo::create([
                    'id_proyecto' => $equipoData['id_proyecto'],
                    'id_mano_obra' => $equipoData['id_mano_obra'],
                    // Agrega más campos aquí según tus necesidades
                ]);

                $equiposTrabajoCreados[] = $equipoTrabajo;
            }
        }

        if (!empty($equiposTrabajoCreados)) {
            return response()->json([
                'success' => true,
                'message' => 'Equipos de trabajo creados correctamente',
                'equipos_creados' => $equiposTrabajoCreados
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Datos inválidos para crear equipos de trabajo'
        ]);
    }
    
    public function eliminarEquipos(Request $request)
    {
        $ids = $request->input('ids'); // Recupera los IDs enviados desde la solicitud AJAX

        if (!empty($ids)) {
            // Elimina los equipos de trabajo correspondientes según los IDs recibidos
            EquipoTrabajo::whereIn('id', $ids)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Miembros del equipo de trabajo eliminados correctamente'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Ocurrió un error al eliminar los miembros del equipo de trabajo'
        ]);
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
                return $row->mano_obra->usuario->name;
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
                // Agregar botones de acciones (editar, eliminar, etc.) si es necesario
                $btn = '<a href="#" class="edit btn btn-primary btn-sm">Editar</a>';
                $btn .= ' <a href="#" class="delete btn btn-danger btn-sm">Eliminar</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    

}
