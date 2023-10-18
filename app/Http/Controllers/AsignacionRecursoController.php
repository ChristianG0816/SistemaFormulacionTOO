<?php

namespace App\Http\Controllers;

use App\Models\AsignacionRecurso;
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
        // $this->validate($request, [
        //     'id_recurso'=>'required',
        //     'cantidad'=> ['required', 'regex:/^\d+$/']
        // ]);

        $recurso = Recurso::find($request->input('id_recurso'));

        if( $recurso->disponibilidad - intval($request->input('cantidad')) < 0){
            return response()->json(['message' => 'Mensaje de error'], 200);
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

    public function list(Request $request, $actividadId){
        // Convertir $proyectoId a un entero
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
    public function edit(AsignacionRecurso $asignacionRecurso)
    {
        //
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
