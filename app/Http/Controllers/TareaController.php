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
use App\Models\EquipoTrabajo;
use App\Models\Notificacion;
use App\Models\TipoNotificacion;
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
        $cantidad_tareas_completadas=0;
        $cantidad_tareas_sin_iniciar=0;
        $cantidad_tareas_iniciadas=0;
        if(!empty($input['nombre-tarea'])){
            $tarea = Tarea::create([
                'id_actividad' => $request->input('id-actividad-tarea'),
                'nombre'=>$request->input('nombre-tarea'),
                'finalizada'=>$request->input('finalizada-tarea')
            ]);
            if($tarea->finalizada != null){
                if($tarea->finalizada){
                    $this->envio_notificacion_tarea(13, $tarea);
                }else{
                    $this->envio_notificacion_tarea(12, $tarea);
                }
            }
            $tareas = Tarea::where('id_actividad', $tarea->id_actividad)->get();
            foreach ($tareas as $tarea) {
                if ($tarea->finalizada === null){
                    $cantidad_tareas_sin_iniciar++;
                }else if ($tarea->finalizada===true) {
                    $cantidad_tareas_completadas++;
                }else{
                    $cantidad_tareas_iniciadas++;
                }
            }
            if ($cantidad_tareas_completadas>0 && $cantidad_tareas_sin_iniciar==0 &&  $cantidad_tareas_iniciadas==0) {
                $tareaActualizada = Actividad::find($tarea->id_actividad);
                $estadoActividad = EstadoActividad::where('nombre', 'Finalizada')->first();
                if ($estadoActividad) {
                    $tareaActualizada->id_estado_actividad = $estadoActividad->id;
                    $tareaActualizada->save();
                }
                $this->envio_notificacion_actividad(10, $tarea->actividad);
            }else if($cantidad_tareas_sin_iniciar>=0 && $cantidad_tareas_iniciadas==0 && $cantidad_tareas_completadas==0 ){
                $tareaActualizada = Actividad::find($tarea->id_actividad);
                $estadoActividad = EstadoActividad::where('nombre', 'Pendiente')->first();
                if ($estadoActividad) {
                    $tareaActualizada->id_estado_actividad = $estadoActividad->id;
                    $tareaActualizada->save();
                }
                $this->envio_notificacion_actividad(8, $tarea->actividad);
            } else{
                $tareaActualizada = Actividad::find($tarea->id_actividad);
                $estadoActividad = EstadoActividad::where('nombre', 'En Proceso')->first();
                if ($estadoActividad) {
                    $tareaActualizada->id_estado_actividad = $estadoActividad->id;
                    $tareaActualizada->save();
                }
                $this->envio_notificacion_actividad(9, $tarea->actividad);
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
        $cantidad_tareas_sin_iniciar=0;
        $cantidad_tareas_iniciadas=0;
        if(!empty($input['nombre-tarea-editar'])){
            $tarea->id_actividad = $request->input('id-actividad-tarea-editar');
            $tarea->nombre = $request->input('nombre-tarea-editar');
            $tarea->finalizada = $request->input('finalizada-tarea-editar');
            $tarea->save();
        }
        $tareas = Tarea::where('id_actividad', $tarea->id_actividad)->get();
        foreach ($tareas as $tarea) {
            if ($tarea->finalizada === null){
                $cantidad_tareas_sin_iniciar++;
            }else if ($tarea->finalizada===true) {
                $cantidad_tareas_completadas++;
            }else{
                $cantidad_tareas_iniciadas++;
            }
        }
        if ($cantidad_tareas_completadas>0 && $cantidad_tareas_sin_iniciar==0 &&  $cantidad_tareas_iniciadas==0) {
            $tareaActualizada = Actividad::find($tarea->id_actividad);
            $estadoActividad = EstadoActividad::where('nombre', 'Finalizada')->first();
            if ($estadoActividad) {
                $tareaActualizada->id_estado_actividad = $estadoActividad->id;
                $tareaActualizada->save();
            }
            $this->envio_notificacion_actividad(10, $tarea->actividad);
        }else if($cantidad_tareas_sin_iniciar>=0 && $cantidad_tareas_iniciadas==0 && $cantidad_tareas_completadas==0 ){
            $tareaActualizada = Actividad::find($tarea->id_actividad);
            $estadoActividad = EstadoActividad::where('nombre', 'Pendiente')->first();
            if ($estadoActividad) {
                $tareaActualizada->id_estado_actividad = $estadoActividad->id;
                $tareaActualizada->save();
            }
            $this->envio_notificacion_actividad(8, $tarea->actividad);
        } else{
            $tareaActualizada = Actividad::find($tarea->id_actividad);
            $estadoActividad = EstadoActividad::where('nombre', 'En Proceso')->first();
            if ($estadoActividad) {
                $tareaActualizada->id_estado_actividad = $estadoActividad->id;
                $tareaActualizada->save();
            }
            $this->envio_notificacion_actividad(9, $tarea->actividad);
        }
        if($tarea->finalizada != null){
            if($tarea->finalizada){
                $this->envio_notificacion_tarea(13, $tarea);
            }else{
                $this->envio_notificacion_tarea(12, $tarea);
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
        $cantidad_tareas_sin_iniciar=0;
        $cantidad_tareas_iniciadas=0;
        $tareas = Tarea::where('id_actividad', $tarea->id_actividad)->get();
        foreach ($tareas as $tarea) {
            if ($tarea->finalizada === null){
                $cantidad_tareas_sin_iniciar++;
            }else if ($tarea->finalizada===true) {
                $cantidad_tareas_completadas++;
            }else{
                $cantidad_tareas_iniciadas++;
            }
        }
        if ($cantidad_tareas_completadas>0 && $cantidad_tareas_sin_iniciar==0 &&  $cantidad_tareas_iniciadas==0) {
            $tareaActualizada = Actividad::find($tarea->id_actividad);
            $estadoActividad = EstadoActividad::where('nombre', 'Finalizada')->first();
            if ($estadoActividad) {
                $tareaActualizada->id_estado_actividad = $estadoActividad->id;
                $tareaActualizada->save();
            }
            $this->envio_notificacion_actividad(10, $tarea->actividad);
        }else if($cantidad_tareas_sin_iniciar>=0 && $cantidad_tareas_iniciadas==0 && $cantidad_tareas_completadas==0 ){
            $tareaActualizada = Actividad::find($tarea->id_actividad);
            $estadoActividad = EstadoActividad::where('nombre', 'Pendiente')->first();
            if ($estadoActividad) {
                $tareaActualizada->id_estado_actividad = $estadoActividad->id;
                $tareaActualizada->save();
            }
            $this->envio_notificacion_actividad(8, $tarea->actividad);
        } else{
            $tareaActualizada = Actividad::find($tarea->id_actividad);
            $estadoActividad = EstadoActividad::where('nombre', 'En Proceso')->first();
            if ($estadoActividad) {
                $tareaActualizada->id_estado_actividad = $estadoActividad->id;
                $tareaActualizada->save();
            }
            $this->envio_notificacion_actividad(9, $tarea->actividad);
        } 
    }

    public function envio_notificacion_tarea($tipo_notificacion_valor, $tarea)
    {
        //Envío de notificacion a supervisor
        $notificacion = new Notificacion();
        $notificacion->id_usuario = $tarea->actividad->proyecto->id_dueno;
        $notificacion->id_tipo_notificacion = $tipo_notificacion_valor;
        $tipoNotificacion = TipoNotificacion::find($tipo_notificacion_valor);
        if ($tipoNotificacion) {
            $descripcion = str_replace(['{{nombre_tarea}}','{{nombre}}', '{{nombre_proyecto}}'], [$tarea->nombre, $tarea->actividad->nombre, $tarea->actividad->proyecto->nombre], $tipoNotificacion->descripcion);
            $notificacion->descripcion = $descripcion;
            $notificacion->ruta = str_replace('{{id}}', $tarea->actividad->id, $tipoNotificacion->ruta);
        }
        $notificacion->id_actividad = $tarea->actividad->id;
        $notificacion->leida = false;
        $notificacion->save();
        //Envío de notificacion a equipo de trabajo
        $EquipoTrabajo = EquipoTrabajo::where("id_proyecto",$tarea->actividad->proyecto->id);
        foreach ($EquipoTrabajo as $miembro) {
            // Crear notificación para cada miembro
            $notificacion = new Notificacion();
            $notificacion->id_usuario = $miembro->id;
            $notificacion->id_tipo_notificacion = $tipo_notificacion_valor;
            $tipoNotificacion = TipoNotificacion::find($tipo_notificacion_valor);
            if ($tipoNotificacion) {
                $descripcion = str_replace(['{{nombre_tarea}}','{{nombre}}', '{{nombre_proyecto}}'], [$tarea->nombre, $tarea->actividad->nombre, $tarea->actividad->proyecto->nombre], $tipoNotificacion->descripcion);
                $notificacion->descripcion = $descripcion;
                $notificacion->ruta = str_replace('{{id}}', $tarea->actividad->id, $tipoNotificacion->ruta);
            }
            $notificacion->id_actividad = $tarea->actividad->id;
            $notificacion->id_proyecto = $tarea->actividad->proyecto->id;
            $notificacion->leida = false;
            $notificacion->save();
        }
    }

    public function envio_notificacion_actividad($tipo_notificacion_valor, $actividad)
    {
        //Envío de notificacion a supervisor
        $notificacion = new Notificacion();
        $notificacion->id_usuario = $actividad->proyecto->id_dueno;
        $notificacion->id_tipo_notificacion = $tipo_notificacion_valor;
        $tipoNotificacion = TipoNotificacion::find($tipo_notificacion_valor);
        if ($tipoNotificacion) {
            $descripcion = str_replace(['{{nombre}}', '{{nombre_proyecto}}'], [$actividad->nombre, $actividad->proyecto->nombre], $tipoNotificacion->descripcion);
            $notificacion->descripcion = $descripcion;
            $notificacion->ruta = str_replace('{{id}}', $actividad->id, $tipoNotificacion->ruta);
        }
        $notificacion->id_actividad = $actividad->id;
        $notificacion->leida = false;
        $notificacion->save();
        //Envío de notificacion al cliente
        $notificacion = new Notificacion();
        $notificacion->id_usuario = $actividad->proyecto->id_cliente;
        $notificacion->id_tipo_notificacion = $tipo_notificacion_valor;
        $tipoNotificacion = TipoNotificacion::find($tipo_notificacion_valor);
        if ($tipoNotificacion) {
            $descripcion = str_replace(['{{nombre}}', '{{nombre_proyecto}}'], [$actividad->nombre, $actividad->proyecto->nombre], $tipoNotificacion->descripcion);
            $notificacion->descripcion = $descripcion;
            $notificacion->ruta = str_replace('{{id}}', $actividad->id, $tipoNotificacion->ruta);
        }
        $notificacion->id_actividad = $actividad->id;
        $notificacion->leida = false;
        $notificacion->save();
        //Envío de notificacion a equipo de trabajo
        $EquipoTrabajo = EquipoTrabajo::where("id_proyecto",$actividad->proyecto->id);
        foreach ($EquipoTrabajo as $miembro) {
            // Crear notificación para cada miembro
            $notificacion = new Notificacion();
            $notificacion->id_usuario = $miembro->id;
            $notificacion->id_tipo_notificacion = $tipo_notificacion_valor;
            $tipoNotificacion = TipoNotificacion::find($tipo_notificacion_valor);
            if ($tipoNotificacion) {
                $descripcion = str_replace(['{{nombre}}', '{{nombre_proyecto}}'], [$actividad->nombre, $actividad->proyecto->nombre], $tipoNotificacion->descripcion);
                $notificacion->descripcion = $descripcion;
                $notificacion->ruta = str_replace('{{id}}', $actividad->id, $tipoNotificacion->ruta);
            }
            $notificacion->id_actividad = $actividad->id;
            $notificacion->id_proyecto = $actividad->proyecto->id;
            $notificacion->leida = false;
            $notificacion->save();
        }
    }
}
