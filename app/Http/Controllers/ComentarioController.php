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
                'id_actividad'=>$request->input('id_actividad_comentario')
            ]);
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
            $comentarioNew->id_actividad = $request->input($input_actividad);
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
}
