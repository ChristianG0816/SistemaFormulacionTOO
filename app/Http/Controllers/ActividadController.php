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
use App\Models\ManoObra;
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
        $miembrosEquipoTrabajo = EquipoTrabajo::where('id_proyecto', $proyecto->id)
        ->with(['mano_obra.usuario' => function ($query) {
            $query->select('id', 'name', 'last_name', DB::raw('name || \' \' || last_name AS full_name'));
        }])
        ->get()
        ->pluck('mano_obra.usuario.full_name', 'id');
        $prioridades = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
        ];
        return view('actividades.crear', compact('estadosActividad', 'proyecto', 'miembrosEquipoTrabajo', 'prioridades'));
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
            'id_responsable' => 'required',
        ]);
        $input = $request->all();
        $actividad = Actividad::create($input);
        $proyecto = Proyecto::find($actividad->id_proyecto);
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
        $usuario= Auth::user();
        $userRole = $usuario->roles->pluck('name')->first();
        $comentarios = Comentario::where('id_actividad', $actividad->id)->orderBy('created_at', 'desc')->get();
        return view('actividades.mostrar', compact('actividad', 'estadosActividad', 'proyecto', 'usuario', 'comentarios', 'userRole'));
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
        $miembrosEquipoTrabajo = EquipoTrabajo::where('id_proyecto', $proyecto->id)
        ->with(['mano_obra.usuario' => function ($query) {
            $query->select('id', 'name', 'last_name', DB::raw('name || \' \' || last_name AS full_name'));
        }])
        ->get()
        ->pluck('mano_obra.usuario.full_name', 'id');
        $prioridades = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
        ];
        return view('actividades.editar', compact('proyecto','actividad','estadosActividad', 'miembrosEquipoTrabajo', 'prioridades'));
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
            'id_responsable' => 'required',
        ]);
        $input = $request->all();

        // Verificar si el estado de la actividad es "Finalizada"
        if ($input['id_estado_actividad'] == 3) {
            // Si es finalizada, guarda la fecha actual en el atributo fecha_fin_real
            $input['fecha_fin_real'] = date('Y-m-d');
        } else {
            // Si no es finalizada, asegúrate de que fecha_fin_real sea null
            $input['fecha_fin_real'] = null;
        }

        $actividad->update($input);
        $proyecto = Proyecto::find($actividad->id_proyecto);
        return redirect()->route('proyectos.show', ['proyecto' => $proyecto])->with('success', 'Actividad actualizada con éxito');
    }

    public function actualizar(Request $request, $id)
    {
        $actividad = Actividad::find($id);
        $this->validate($request, [
            'nombre' => 'required',
            'prioridad'=>['required', 'regex:/^\d{1}(?:\d{1,4})?$/'],
            'fecha_inicio' => 'required|fecha_menor_igual:fecha_fin',
            'fecha_fin' => 'required',
            'responsabilidades' => 'required',
            'id_estado_actividad' => 'required',
            'id_responsable' => 'required',
        ]);
        $input = $request->all();
        $actividad->update($input);
        $proyecto = Proyecto::find($actividad->id_proyecto);
        if($actividad->estado_actividad->nombre == "Pendiente"){
            $this->envio_notificacion_actividad(8, $actividad);
        }else if($actividad->estado_actividad->nombre == "En Proceso"){
            $this->envio_notificacion_actividad(9, $actividad);
        }else if($actividad->estado_actividad->nombre == "Finalizada"){
            $this->envio_notificacion_actividad(10, $actividad);
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
        $actividad = Actividad::find($id);
        $Notificaciones = Notificacion::where("id_actividad",$actividad->id)->delete();
        $actividad->delete();
    }

    public function envio_notificacion_actividad($tipo_notificacion_valor, $actividad)
    {
        //Envío de notificacion a supervisor
        $notificacion = new Notificacion();
        $notificacion->id_usuario = $actividad->proyecto->id_gerente_proyecto;
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

    public function enviarRecordatorio(Request $request, $id){
        $data = $request->input('actividades');

        // Iterar sobre los datosFiltrados y buscar las actividades en la base de datos
        try {
            foreach ($data as $actividad) {
                // Buscar la actividad por su ID en la base de datos
                $actividadEncontrada = Actividad::find($actividad['id']);
    
                // Verificar si la actividad fue encontrada
                if ($actividadEncontrada) {
                    //proyecto
                    $nombre_proyecto = Proyecto::select('nombre')->find($id);
                    //busca el miembro del equipo
                    $miembroequipo = EquipoTrabajo::select('id_mano_obra')->find($actividadEncontrada->id_responsable);
                    //busca dentro de mano de obra
                    $usuarioAnotificar = ManoObra::select('id_usuario')->find($miembroequipo->id_mano_obra);

                    //actividad recordatorio
                    $tipo_notificacion_valor = 5;
                    // Crear notificación para cada miembro
                    $notificacion = new Notificacion();
                    $notificacion->id_usuario = $usuarioAnotificar->id_usuario;
                    $notificacion->id_tipo_notificacion = $tipo_notificacion_valor;
                    $tipoNotificacion = TipoNotificacion::find($tipo_notificacion_valor);
                    if ($tipoNotificacion) {
                        $descripcion = str_replace(['{{nombre}}', '{{nombre_proyecto}}'], [$actividadEncontrada->nombre, $nombre_proyecto], $tipoNotificacion->descripcion);
                        $notificacion->descripcion = $descripcion;
                        $notificacion->ruta = str_replace('{id}', $actividadEncontrada->id, $tipoNotificacion->ruta);
                    }
                    $notificacion->id_actividad = $actividadEncontrada->id;
                    $notificacion->id_proyecto = $id;
                    $notificacion->leida = false;
                    $notificacion->save();
                }
            }
            return response()->json(['success' => true], 200);

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
}
