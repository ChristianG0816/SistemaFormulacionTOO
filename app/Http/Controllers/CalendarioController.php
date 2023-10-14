<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use Illuminate\Support\Facades\Auth;
use App\Models\EquipoTrabajo;
use App\Models\ManoObra;
use App\Models\MiembroActividad;

class CalendarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('calendario.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

/*http://127.0.0.1:8000/calendario/mostrar ruta*/

/*public function show() {

    //Debo de obtener el idManodeObra del usuario que esta en el sistema
    $usuarioLogueado = Auth::user();
    // Busca la mano de obra asociada al usuario logueado
    $manoObra = ManoObra::where('id_usuario', $usuarioLogueado->id)->first();

    
    //Busco el equipo al cual esta asociado la mano de obra
    $equipoTrabajo = EquipoTrabajo::where('id_mano_obra', $manoObra->id)->first();
    //miembro de la actividad
    $miembroDeActividad = MiembroActividad::where('id_equipo_trabajo', $equipoTrabajo->id)->first();
    //actividades
    $actividades = Actividad::where('id', $miembroDeActividad->id)->first();
    

    //$actividades = Actividad::all();

    $eventos = [];
    foreach ($actividades as $actividad) {
        $evento = [
            //aqui me traigo todo lo relacionado a la actividad y mostrarlo en el formulario
            'id' => $actividad->id,
            'title' => $actividad->nombre,
            'start' => $actividad->fecha_fin,
            'end' => $actividad->fecha_fin,
        ];
        array_push($eventos, $evento);
    }
    

    return response()->json($actividades);
}*/

public function show() {
    //Debo de obtener el idManodeObra del usuario que esta en el sistema
    $usuarioLogueado = Auth::user();
    $manoObra = ManoObra::where('id_usuario', $usuarioLogueado->id)->first();

    if ($manoObra) {
        $equipoTrabajo = EquipoTrabajo::where('id_mano_obra', $manoObra->id)->get();

        $eventos = [];

        foreach ($equipoTrabajo as $equipo) {
            $miembrosActividad = MiembroActividad::where('id_equipo_trabajo', $equipo->id)->get();
            foreach ($miembrosActividad as $miembroActividad) {
                $actividad = Actividad::where('id', $miembroActividad->id)->first();
                if ($actividad) {
                    $evento = [
                        'id' => $actividad->id,
                        'title' => $actividad->nombre,
                        'start' => $actividad->fecha_fin,
                        'end' => $actividad->fecha_fin,
                    ];
                    array_push($eventos, $evento);
                }
            }
        }

        return response()->json($eventos);
    }

    return response()->json([]); // En caso de que no se encuentren datos.
}





    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function consultarActividad($id){
        $actividad = Actividad::find($id);
        return response()->json($actividad);
    }

}
