<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Proyecto;
use App\Models\EstadoActividad;
use App\Models\Comentario;
use App\Models\EquipoTrabajo;
use App\Models\Notificacion;
use App\Models\TipoNotificacion;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
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
        $usuario= Auth::user();
        if(!empty($input['linea_comentario_comentario'])){
            $comentario = Comentario::create([
                'id_usuario' => $usuario->id,
                'linea_comentario'=>$request->input('linea_comentario_comentario'),
                'id_paquete_actividades'=>$request->input('id_actividad_comentario')
            ]);
            $this->envio_notificacion_comentario(11, $comentario);
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
        $usuario = Auth::user();
        $input_linea = 'linea-comentario-update' . $id;
        $input_actividad = 'id-actividad-comentario-update' . $id;
        if (!empty($input[$input_linea])) {
            $comentarioNew = Comentario::find($id);
            $comentarioNew->id_usuario = $usuario->id;
            $comentarioNew->linea_comentario = $request->input($input_linea);
            $comentarioNew->id_paquete_actividades = $request->input($input_actividad);
            $comentarioNew->save();
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
        $comentario = Comentario::find($id);
        $comentario->delete();
    }

    public function envio_notificacion_comentario($tipo_notificacion_valor, $comentario)
    {
        //Envío de notificacion a supervisor
        $notificacion = new Notificacion();
        $notificacion->id_usuario = $comentario->paquete_actividades->proyecto->id_dueno;
        $notificacion->id_tipo_notificacion = $tipo_notificacion_valor;
        $tipoNotificacion = TipoNotificacion::find($tipo_notificacion_valor);
        if ($tipoNotificacion) {
            $nombre_usuario=$comentario->usuario->name . " " . $comentario->usuario->last_name;
            $descripcion=$tipoNotificacion->descripcion;
            $descripcion2 = str_replace('{{usuario}}', $nombre_usuario, $descripcion);
            $descripcion3 = str_replace('{{nombre}}', $comentario->paquete_actividades->nombre, $descripcion2);
            $descripcion4  = str_replace('{{nombre_proyecto}}', $comentario->paquete_actividades->proyecto->nombre, $descripcion3);
            $notificacion->descripcion = $descripcion4;
            $notificacion->ruta = str_replace('{{id}}', $comentario->paquete_actividades->id, $tipoNotificacion->ruta);
        }
        $notificacion->id_paquete_actividades = $comentario->paquete_actividades->id;
        $notificacion->leida = false;
        $notificacion->save();
        //Envío de notificacion a equipo de trabajo
        $EquipoTrabajo = EquipoTrabajo::where("id_proyecto",$comentario->paquete_actividades->proyecto->id);
        if($EquipoTrabajo!=null){
            foreach ($EquipoTrabajo as $miembro) {
                // Crear notificación para cada miembro
                $notificacion = new Notificacion();
                $notificacion->id_usuario = $miembro->id;
                $notificacion->id_tipo_notificacion = $tipo_notificacion_valor;
                $tipoNotificacion = TipoNotificacion::find($tipo_notificacion_valor);
                if ($tipoNotificacion) {
                    $nombre_usuario=$comentario->usuario->name . " " . $comentario->usuario->last_name;
                    $descripcion=$tipoNotificacion->descripcion;
                    $descripcion2 = str_replace('{{usuario}}', $nombre_usuario, $descripcion);
                    $descripcion3 = str_replace('{{nombre}}', $comentario->paquete_actividades->nombre, $descripcion2);
                    $descripcion4  = str_replace('{{nombre_proyecto}}', $comentario->paquete_actividades->proyecto->nombre, $descripcion3);
                    $notificacion->descripcion = $descripcion4;
                    $notificacion->ruta = str_replace('{{id}}', $comentario->paquete_actividades->id, $tipoNotificacion->ruta);
                }
                $notificacion->id_paquete_actividades = $comentario->paquete_actividades->id;
                $notificacion->id_proyecto = $comentario->paquete_actividades->proyecto->id;
                $notificacion->leida = false;
                $notificacion->save();
            }
        }
    }
}
