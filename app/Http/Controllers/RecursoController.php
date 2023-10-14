<?php

namespace App\Http\Controllers;

use App\Models\Recurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('recursos.index');
    }

    public function data()
    {
        $data = Recurso::all();
        foreach ($data as $d) {
             $d->disponibilidad = $d->disponibilidad == 1 ? 'Disponible' : 'No Disponible';
        }

        return datatables()->of($data)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Mostrar el formulario para crear un nuevo recurso
    public function create()
    {
        $disponibilidades = [
            'Disponible' => 'Disponible',
            'No Disponible' => 'No Disponible',
        ];

        return view('recursos.create',compact('disponibilidades'));
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
            'disponibilidad'=>'required',
            'costo'=> ['required', 'regex:/^\d+(\.\d+)?$/']
        ]);

        // Obten el valor de disponibilidad del request
        $disponibilidad = $request->input('disponibilidad')[0] == 'Disponible' ? 1 : 0;

        // Crear un nuevo recurso utilizando el modelo Recurso
        Recurso::create([
            'nombre' => $request->input('nombre'),
            'disponibilidad' => $disponibilidad,
            'costo' => $request->input('costo')
        ]);

        // Redirigir a alguna ruta después de guardar los datos
        return redirect()->route('recursos.index')->with('success', 'Recurso creado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recurso = Recurso::find($id);
        $recurso->disponibilidad = $recurso->disponibilidad == 1 ? 'Disponible' : 'No Disponible';
        //dd($recurso);

        return view('recursos.show', compact('recurso'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $recurso = Recurso::find($id);

        $disponibilidades = [
            'Disponible' => 'Disponible',
            'No Disponible' => 'No Disponible',
        ];

        // Convierte el valor numérico de disponibilidad a texto para la opción seleccionada en el formulario
        $recurso->disponibilidad = $recurso->disponibilidad == 1 ? 'Disponible' : 'No Disponible';

        return view('recursos.edit', compact('recurso','disponibilidades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'disponibilidad'=>'required',
            'costo'=> ['required', 'regex:/^\d+(\.\d+)?$/']
        ]);

        $recurso = Recurso::find($id);

         // Actualiza el objeto $recurso con los datos del request
        $recurso->nombre = $request->input('nombre');
        $recurso->disponibilidad = $request->input('disponibilidad') == 'Disponible' ? 1 : 0;
        $recurso->costo = $request->input('costo');

        // Guarda el objeto $recurso actualizado en la base de datos
        $recurso->save();

        // Redirige a alguna ruta después de actualizar los datos
        return redirect()->route('recursos.index');
    }

    public function RecursosDisponibles(){
        $data = Recurso::where('disponibilidad', 1)->get();
        return response()->json($data);
    }

    public function getRecurso($id){
        $data = Recurso::find($id);
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Recurso::find($id)->delete();
        
        return redirect()->route('recursos.index');
    }
}
