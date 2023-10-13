<?php

namespace App\Http\Controllers;

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
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*$manoObra = ManoObra::find($id);
        $user = User::find($manoObra->id_usuario);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        $manoObraUser = (object) ([
            'id_usuario' => $manoObra->usuario->id,
            'name' => $manoObra->usuario->name,
            'last_name' => $manoObra->usuario->last_name,
            'email' => $manoObra->usuario->email,
            'id' => $manoObra->id,
            'dui'=> $manoObra->dui,
            'afp'=> $manoObra->afp,
            'isss'=> $manoObra->isss,
            'nacionalidad'=> $manoObra->nacionalidad,
            'pasaporte'=> $manoObra->pasaporte,
            'telefono' => $manoObra->telefono,
            'profesion'=> $manoObra->profesion,
            'estado_civil'=> $manoObra->estado_civil,
            'sexo'=> $manoObra->sexo,
            'fecha_nacimiento'=> $manoObra->fecha_nacimiento,
            'costo_servicio'=> $manoObra->costo_servicio
        ]);*/
        return view('proyectos.gestionar');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       /* $manoObra = ManoObra::find($id);
        $user = User::find($manoObra->id_usuario);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        $sexos = [
            'Masculino' => 'Masculino',
            'Femenino' => 'Femenino',
        ];

        $manoObraUser = (object) ([
            'id_usuario' => $manoObra->usuario->id,
            'name' => $manoObra->usuario->name,
            'last_name' => $manoObra->usuario->last_name,
            'email' => $manoObra->usuario->email,
            'id' => $manoObra->id,
            'dui'=> $manoObra->dui,
            'afp'=> $manoObra->afp,
            'isss'=> $manoObra->isss,
            'nacionalidad'=> $manoObra->nacionalidad,
            'pasaporte'=> $manoObra->pasaporte,
            'telefono' => $manoObra->telefono,
            'profesion'=> $manoObra->profesion,
            'estado_civil'=> $manoObra->estado_civil,
            'sexo'=> $manoObra->sexo,
            'fecha_nacimiento'=> $manoObra->fecha_nacimiento,
            'costo_servicio'=> $manoObra->costo_servicio
        ]);
        return view('miembros.editar', compact('manoObraUser', 'sexos'));*/
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
       /* $manoObra = ManoObra::find($id);
        $user = User::find($manoObra->id_usuario);
        $this->validate($request, [
            'name' => 'required',
            'last_name' => 'required',
            'dui'=>['required', 'regex:/^\d{9}$/'],
            'afp'=>['required', 'regex:/^\d{3}(?:\d{1,17})?$/'],
            'isss'=>['required', 'regex:/^\d{3}(?:\d{1,17})?$/'],
            'nacionalidad'=>'required',
            'pasaporte'=>['required', 'regex:/^\d{3}(?:\d{1,17})?$/'],
            'telefono' => ['required', 'regex:/^\d{8}(?:\d{1,2})?$/'],
            'profesion'=>'required',
            'estado_civil'=>'required',
            'sexo'=>'required',
            'fecha_nacimiento'=> 'required|validateFechaMayorDe18',
            'costo_servicio'=> ['required', 'regex:/^\d+(\.\d+)?$/']
        ]);
        
        $manoObra->update([
            'id_usuario' => $user->id,
            'dui'=>$request->input('dui'),
            'afp'=>$request->input('afp'),
            'isss'=>$request->input('isss'),
            'nacionalidad'=>$request->input('nacionalidad'),
            'pasaporte'=>$request->input('pasaporte'),
            'telefono'=>$request->input('telefono'),
            'profesion'=>$request->input('profesion'),
            'estado_civil'=>$request->input('estado_civil'),
            'sexo'=>$request->input('sexo'),
            'fecha_nacimiento'=>$request->input('fecha_nacimiento'),
            'costo_servicio'=>$request->input('costo_servicio')
        ]);
        $user->update([
            'name' => $request->input('name'),
            'last_name'=>$request->input('last_name')
        ]);

        $user->assignRole($request->input('roles'));
        return redirect()->route('miembros.index');*/
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
