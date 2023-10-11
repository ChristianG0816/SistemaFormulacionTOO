<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Proyecto;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*$roles = Role::pluck('name', 'name')->all();
        $sexos = [
            'Masculino' => 'Masculino',
            'Femenino' => 'Femenino',
        ];
        return view('miembros.crear', compact('roles','sexos'));*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$this->validate($request, [
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password'=>'required|same:confirm-password',
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

        $password=$request->input('password');

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        $manoObra = ManoObra::create([
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
        \Mail::to($user->email)->send(new NuevoUsuarioCreado($user->name." ".$user->last_name, $user->email, $password));
        return redirect()->route('miembros.index');*/
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
        ]);
        return view('miembros.mostrar', compact('manoObraUser'));*/
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
        /*$manoObra = ManoObra::find($id);
        ManoObra::find($id)->delete();
        User::find($manoObra->id_usuario)->delete();
        return redirect()->route('miembros.index');*/
    }
}
