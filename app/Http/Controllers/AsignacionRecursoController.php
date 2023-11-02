<?php

namespace App\Http\Controllers;

use App\Models\AsignacionRecurso;
use App\Models\Proyecto;
use App\Models\EquipoTrabajo;
use App\Models\Recurso;
use App\Models\Actividad;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AsignacionRecursoController extends Controller
{   

    function __construct()
    {
        $this->middleware('permission:crear-asignacionRecurso', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-asignacionRecurso', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-asignacionRecurso', ['only' => ['destroy']]);
        $this->middleware('permission:mostrar-asignacionRecurso', ['only' => ['show']]);
    }
    
    public function RecursosDisponibles($id){
        //trae recursos disponibles no asignados a esta actividad
        $data = Recurso::where('disponibilidad', '>=', 1)
        ->whereNotIn('id', function($query) use ($id) {
            $query->select('id_recurso')
                ->from('asignacion_recurso')
                ->where('id_actividad', $id);
        })
        ->get();

        return response()->json($data);
    }

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
                $costo_recurso_actual = 0;
                $costo_equipo_trabajo = 0;

                $proyecto = Proyecto::find($id_proyecto);

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

                $recurso = Recurso::find($request->input('id_recurso'));

                if( $recurso->disponibilidad - intval($request->input('cantidad')) < 0){
                    return response()->json([
                        'success' => false,
                        'message' => 'Error al agregar Recurso: Cantidad sobrepasa Disponibilidad'
                    ]);
                }
                
                $costo_recurso_actual = intval($request->input('cantidad')*$request->input('costo'));

                $costo_total =  $costo_recurso_actual + intval($costo_equipo_trabajo) + intval($costo_recurso);

                if (intval($proyecto->presupuesto) < intval($costo_total)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Error al agregar Recurso: El presupuesto del proyecto es insuficiente'
                    ]);
                }

                AsignacionRecurso::create([
                    'id_actividad' => $request->input('id_actividad'),
                    'id_recurso' => $request->input('id_recurso'),
                    'cantidad' => $request->input('cantidad')
                ]);

                $recurso->disponibilidad -= intval($request->input('cantidad'));
                $recurso->save();

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
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'cantidad'=> ['required', 'regex:/^[1-9]\d*$/']
        ]);

        $data = $request->all();
        $recursoAsignado = AsignacionRecurso::find($id);
        $recurso = Recurso::find($data['id_recurso']);

        $disponiblidadTotal = $recursoAsignado->cantidad + $recurso->disponibilidad;

        if(intval($data['cantidad']) > intval($disponiblidadTotal)){
            return response()->json([
                'success' => false,
                'message' => 'Error al agregar Recurso: Cantidad sobrepasa Disponibilidad'
            ]);
        }

        $recurso->disponibilidad = intval($disponiblidadTotal); //21
        $recurso->disponibilidad -= intval($data['cantidad']);
        $recursoAsignado->cantidad = intval($data['cantidad']);

        $recurso->save();
        $recursoAsignado->save();

        return response()->json(['success' => true], 200);
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
