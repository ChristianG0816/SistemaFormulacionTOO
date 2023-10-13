<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Proyecto;
use App\Models\EstadoProyecto;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class ProyectoController extends Controller
{
    /**
     * Funcion para mostrar la vista de todos los proyectos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proyectos = Proyecto::all();
        return view('proyectos.index', compact('proyectos'));
    }

    public function data()
    {
        $data = Proyecto::with('estado_proyecto','dueno')->get();
        return datatables()->of($data)
        ->addColumn('cliente_nombre', function ($row) {
            return $row->cliente->name . ' ' . $row->cliente->last_name;
        })
        ->addColumn('dueno_nombre', function ($row) {
            return $row->dueno->name . ' ' . $row->dueno->last_name;
        })             
        ->rawColumns(['action'])
        ->make(true);
    }

    /**
     * Funcion para crear un nuevo proyecto
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estados = EstadoProyecto::pluck('nombre', 'id')->all();
        $prioridades = ['1' => '1','2' => '2','3' => '3','4' => '4','5' => '5',];

        $dueno = Role::where('name', 'Supervisor')->first();
        $usuariosDuenos = $dueno->users;
        $duenos = $usuariosDuenos->mapWithKeys(function ($usuario) {return [$usuario->id => $usuario->name . ' ' . $usuario->last_name];})->all();

        $cliente = Role::where('name', 'Cliente')->first();
        $usuariosClientes = $cliente->users;        
        $clientes = $usuariosClientes->mapWithKeys(function ($usuario) {return [$usuario->id => $usuario->name . ' ' . $usuario->last_name];})->all();
        return view('proyectos.crear', compact('estados','duenos','prioridades','clientes'));
    }

    /**
     * Funcion para guardar proyecto.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'objetivo' => 'required',
            'id_cliente'=>['required'],
            'id_dueno'=>['required'],
            'descripcion'=>['required'],
            'fecha_inicio'=>'required|fecha_menor_igual:fecha_fin',
            'fecha_fin'=> 'required',
            'presupuesto'=>['required', 'regex:/^\d+(\.\d+)?$/'],
            'prioridad' => ['required'],
            'entregable'=>'required',
            'id_estado_proyecto'=>'required'
        ]);

        $input = $request->all();
        
        $proyecto = Proyecto::create($input);
        return redirect()->route('proyectos.index')->with('success', 'Proyecto creado con éxito');
        
    }

    /**
     * Funcion para mostrar gestion de proyecto
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proyecto = Proyecto::find($id);
        return view('proyectos.mostrar', compact('proyecto'));
    }

    /**
     * Funcion para editar proyecto
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proyecto = Proyecto::find($id);

        $estados = EstadoProyecto::pluck('nombre', 'id')->all();
        $prioridades = ['1' => '1','2' => '2','3' => '3','4' => '4','5' => '5',];

        $dueno = Role::where('name', 'Supervisor')->first();
        $usuariosDuenos = $dueno->users;
        $duenos = $usuariosDuenos->mapWithKeys(function ($usuario) {return [$usuario->id => $usuario->name . ' ' . $usuario->last_name];})->all();

        $cliente = Role::where('name', 'Cliente')->first();
        $usuariosClientes = $cliente->users;        
        $clientes = $usuariosClientes->mapWithKeys(function ($usuario) {return [$usuario->id => $usuario->name . ' ' . $usuario->last_name];})->all();
        
        return view('proyectos.editar', compact('proyecto','estados','duenos','prioridades','clientes'));
    }

    /**
     * Funcion para guardar edicion de proyecto
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'objetivo' => 'required',
            'id_cliente'=>['required'],
            'id_dueno'=>['required'],
            'descripcion'=>['required'],
            'fecha_inicio'=>'required|fecha_menor_igual:fecha_fin',
            'fecha_fin'=> 'required',
            'presupuesto'=>['required', 'regex:/^\d+(\.\d+)?$/'],
            'prioridad' => ['required'],
            'entregable'=>'required',
            'id_estado_proyecto'=>'required'
        ]);

        $input = $request->all();
        $proyecto = Proyecto::find($id);
        $proyecto->update($input);

        if ($request->input('origin') === 'detalle') {
            return redirect()->route('proyectos.show', ['proyecto' => $proyecto->id])->with('success', 'Proyecto actualizado con éxito');
        } else {
            return redirect()->route('proyectos.index')->with('success', 'Proyecto actualizado con éxito');
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
        $proyecto = Proyecto::find($id);
        $proyecto->delete();
        return redirect()->route('proyectos.index');
    }
}
