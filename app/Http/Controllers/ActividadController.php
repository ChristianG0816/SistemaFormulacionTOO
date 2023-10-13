<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Actividad;
use App\Models\Proyecto;
use App\Models\EstadoActividad;
use App\Models\Comentario;
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
        return view('proyectos.mostrar', compact('proyecto'));
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
        $comentarios = Comentario::where('id_actividad', $actividad->id)->orderBy('created_at', 'desc')->get();
        return view('actividades.mostrar', compact('actividad', 'estadosActividad', 'proyecto', 'usuario', 'comentarios'));
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
        return view('actividades.editar', compact('actividad', 'estadosActividad'));
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
        return view('proyectos.mostrar', compact('proyecto'));
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
        $proyecto = $actividad->id_proyecto;
        $actividad->delete();
        return view('proyectos.mostrar', compact('proyecto'));
    }
}
