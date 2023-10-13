<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;

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
    public function show() {
    
    //en este metodo tendria que filtrar en base a usuario y proyecto 
    //para que me los muestre en el calendario.    

    $actividades = Actividad::all();

    $eventos = [];
    foreach ($actividades as $actividad) {
        $evento = [
            //aqui me traigo todo lo relacionado a la actividad y mostrarlo en el formulario
            'id' => $actividad->id,
            'title' => $actividad->nombre,
            'start' => $actividad->fecha_inicio,
            'end' => $actividad->fecha_fin,
        ];
        array_push($eventos, $evento);
    }

    return response()->json($eventos);
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
