<?php

namespace App\Http\Controllers;

use App\Models\AsignacionRecurso;
use App\Models\Proyecto;
use App\Models\EquipoTrabajo;
use App\Models\Recurso;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AsignacionRecursoController extends Controller
{
    /**
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function crearAsignacionRecurso(Request $request)
    {
        $this->validate($request, [
            'cantidad'=> ['required', 'regex:/^[1-9]\d*$/']
        ]);

        try {
            if (!empty($request->input('id_proyecto')) && !empty($request->input('id_recurso'))) {

                $id_proyecto = intval($request->input('id_proyecto'));
                $id_actividad = intval($request->input('id_actividad'));
                $costo_recurso = 0;
                $costo_mano_obra = 0;
                $costo_equipo_trabajo = 0;

                $proyecto = Proyecto::find($id_proyecto);

                $costo_equipo_trabajo = EquipoTrabajo::where('id_proyecto', $id_proyecto)
                ->with('mano_obra') // Cargar la relación miembros
                ->get()
                ->pluck('mano_obra.costo_servicio') // Obtener los valores de costo_servicio de la relación
                ->sum();

                $recurso = Recurso::find($request->input('id_recurso'));

                if( $recurso->disponibilidad - intval($request->input('cantidad')) < 0){
                    return response()->json([
                        'success' => false,
                        'message' => 'Error al agregar Recurso: Cantidad sobrepasa Disponibilidad'
                    ]);
                }
                
                $recurso->disponibilidad -= intval($request->input('cantidad'));
                $recurso->save();

                AsignacionRecurso::create([
                    'id_actividad' => $request->input('id_actividad'),
                    'id_recurso' => $request->input('id_recurso'),
                    'cantidad' => $request->input('cantidad')
                ]);

                return response()->json(['success' => true], 200);
            }
        } catch (\Throwable $th) {
            // Captura el mensaje de error
            $errorMessage = $th->getMessage();

            // Retorna el error como respuesta JSON
            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ]);
        }
    }

    public function list(Request $request, $actividadId){
        // Convertir a un entero
        $actividadId = (int)$actividadId;

        $data = AsignacionRecurso::where('id_actividad', $actividadId)
        ->with('recurso')
        ->get();

        return datatables()->of($data)
            ->addColumn('nombre', function ($row) {
                return $row->recurso->nombre;
            })
            ->addColumn('cantidad', function ($row) {
                return $row->cantidad;
            }) 
            ->addColumn('costo', function ($row) {
                return $row->recurso->costo;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AsignacionRecurso  $asignacionRecurso
     * @return \Illuminate\Http\Response
     */
    public function show(AsignacionRecurso $asignacionRecurso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AsignacionRecurso  $asignacionRecurso
     * @return \Illuminate\Http\Response
     */
    public function edit($idAsignacionRecurso)
    {   
        $id = (int)$idAsignacionRecurso;

        $data = AsignacionRecurso::find($id)
        ->with('recurso')
        ->get();

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AsignacionRecurso  $asignacionRecurso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AsignacionRecurso $asignacionRecurso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AsignacionRecurso  $asignacionRecurso
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ar = AsignacionRecurso::find($id);
        $recurso = Recurso::find($ar->id_recurso);
        $recurso->disponibilidad += $ar->cantidad;
        $recurso->save();
        $ar->delete();
        //AsignacionRecurso::find($id)->delete();
    }
}
