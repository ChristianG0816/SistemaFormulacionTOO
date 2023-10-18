<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Actividad;
use App\Models\Proyecto;
use App\Models\EstadoActividad;
use App\Models\Comentario;
use App\Models\Notificacion;
use App\Models\TipoNotificacion;
use App\Models\EquipoTrabajo;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $actividades = Actividad::where('id_proyecto', $proyecto->id)->get();
        return view('actividades.index', compact('actividades', 'proyecto'));
    }

    public function data($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $data = Actividad::where('id_proyecto', $proyecto->id)->with(['estado_actividad']) ->get();
        return datatables()->of($data)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $estadosActividad = EstadoActividad::pluck('nombre', 'id')->all();
        return view('actividades.crear', compact('estadosActividad', 'proyecto'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'prioridad'=>['required', 'regex:/^\d{1}(?:\d{1,4})?$/'],
            'fecha_inicio' => 'required|fecha_menor_igual:fecha_fin',
            'fecha_fin' => 'required',
            'responsabilidades' => 'required',
            'id_estado_actividad' => 'required',
        ]);
        $input = $request->all();
        $actividad = Actividad::create($input);
        $proyecto = Proyecto::find($actividad->id_proyecto);
        $this->envio_notificacion_actividad(9, $actividad);
        return redirect()->route('proyectos.show', ['proyecto' => $proyecto])->with('success', 'Actividad creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $actividad = Actividad::find($id);
        $proyecto = Proyecto::findOrFail($actividad->id_proyecto);
        $estadosActividad = EstadoActividad::pluck('nombre', 'id')->all();
        $estadosTarea = [
            '0' => 'Sin Iniciar',
            '1' => 'Finalizada',
        ];
        $usuario= Auth::user();
        $comentarios = Comentario::where('id_actividad', $actividad->id)->orderBy('created_at', 'desc')->get();
        return view('actividades.mostrar', compact('actividad', 'estadosActividad', 'estadosTarea', 'proyecto', 'usuario', 'comentarios'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $actividad = Actividad::find($id);
        $proyecto = Proyecto::findOrFail($actividad->id_proyecto);
        $estadosActividad = EstadoActividad::pluck('nombre', 'id')->all();
        return view('actividades.editar', compact('proyecto','actividad','estadosActividad'));
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
        $actividad = Actividad::find($id);
        $this->validate($request, [
            'nombre' => 'required',
            'prioridad'=>['required', 'regex:/^\d{1}(?:\d{1,4})?$/'],
            'fecha_inicio' => 'required|fecha_menor_igual:fecha_fin',
            'fecha_fin' => 'required',
            'responsabilidades' => 'required',
            'id_estado_actividad' => 'required',
        ]);
        $input = $request->all();
        $actividad->update($input);
        $proyecto = Proyecto::find($actividad->id_proyecto);
        $this->envio_notificacion_actividad(10, $actividad);
        return redirect()->route('proyectos.show', ['proyecto' => $proyecto])->with('success', 'Actividad actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $actividad = Actividad::find($id);
        $Notificaciones = Notificacion::where("id_actividad",$actividad->id)->delete();
        $actividad->delete();
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
            $notificacion->leida = false;
            $notificacion->save();
        }
    }
}
