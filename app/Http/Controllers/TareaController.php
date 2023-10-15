<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Actividad;
use App\Models\Proyecto;
use App\Models\EstadoActividad;
use App\Models\Comentario;
use App\Models\Tarea;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
    }

    public function data($id)
    {
        $data = Tarea::where('id_actividad', $id)->get();
        return datatables()->of($data)->toJson();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        if(!empty($input['nombre-tarea'])){
            $tarea = Tarea::create([
                'id_actividad' => $request->input('id-actividad-tarea'),
                'nombre'=>$request->input('nombre-tarea'),
                'finalizada'=>$request->input('finalizada-tarea')
            ]);
            $tareaActualizada = Actividad::find($tarea->id_actividad);
            $estadoActividad = EstadoActividad::where('nombre', 'En Proceso')->first();
            if ($estadoActividad) {
                $tareaActualizada->id_estado_actividad = $estadoActividad->id;
                $tareaActualizada->save();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $tarea = Tarea::find($id);
        return response()->json($tarea);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $tarea = Tarea::find($id);
        $cantidad_tareas_completadas=0;
        if(!empty($input['nombre-tarea-editar'])){
            $tarea->id_actividad = $request->input('id-actividad-tarea-editar');
            $tarea->nombre = $request->input('nombre-tarea-editar');
            $tarea->finalizada = $request->input('finalizada-tarea-editar');
            $tarea->save();
        }
        $tareas = Tarea::where('id_actividad', $tarea->id_actividad)->get();
        foreach ($tareas as $tarea) {
            if (!$tarea->finalizada==true) {
                $cantidad_tareas_completadas++;
            }
        }
        if ($cantidad_tareas_completadas == 0) {
            $tareaActualizada = Actividad::find($tarea->id_actividad);
            $estadoActividad = EstadoActividad::where('nombre', 'Finalizada')->first();
            if ($estadoActividad) {
                $tareaActualizada->id_estado_actividad = $estadoActividad->id;
                $tareaActualizada->save();
            }
        }else{
            $tareaActualizada = Actividad::find($tarea->id_actividad);
            $estadoActividad = EstadoActividad::where('nombre', 'En Proceso')->first();
            if ($estadoActividad) {
                $tareaActualizada->id_estado_actividad = $estadoActividad->id;
                $tareaActualizada->save();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tarea = Tarea::find($id);
        $tarea->delete();
        $cantidad_tareas_completadas=0;
        $tareas = Tarea::where('id_actividad', $tarea->id_actividad)->get();
        if(!$tareas->isEmpty()){
            foreach ($tareas as $tarea) {
                if (!$tarea->finalizada==true) {
                    $cantidad_tareas_completadas++;
                }
            }
            if ($cantidad_tareas_completadas == 0) {
                $tareaActualizada = Actividad::find($tarea->id_actividad);
                $estadoActividad = EstadoActividad::where('nombre', 'Finalizada')->first();
                if ($estadoActividad) {
                    $tareaActualizada->id_estado_actividad = $estadoActividad->id;
                    $tareaActualizada->save();
                }
            }else{
                $tareaActualizada = Actividad::find($tarea->id_actividad);
                $estadoActividad = EstadoActividad::where('nombre', 'En Proceso')->first();
                if ($estadoActividad) {
                    $tareaActualizada->id_estado_actividad = $estadoActividad->id;
                    $tareaActualizada->save();
                }
            }
        }else{
            $tareaActualizada = Actividad::find($tarea->id_actividad);
            $estadoActividad = EstadoActividad::where('nombre', 'Pendiente')->first();
            if ($estadoActividad) {
                $tareaActualizada->id_estado_actividad = $estadoActividad->id;
                $tareaActualizada->save();
            }
        }
    }
}
