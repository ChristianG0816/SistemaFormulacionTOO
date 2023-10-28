<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ManoObra;
use App\Models\Pais;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Persona;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Mail\NuevoUsuarioCreado;

class ManoObraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manoObras = ManoObra::all();
        return view('miembros.index', compact('manoObras'));
    }

    public function data()
    {
        $data = ManoObra::with('usuario')->with('persona')->get();
        return datatables()->of($data)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paises = Pais::pluck('name', 'id')->all();
        $departamentos = Departamento::pluck('nombre', 'id')->all();
        $municipios = Municipio::all();
        $sexos = [
            'Masculino' => 'Masculino',
            'Femenino' => 'Femenino',
        ];
        $estado_civil = [
            'Soltero(a)' => 'Soltero(a)',
            'Casado(a)' => 'Casado(a)',
            'Divorciado(a)' => 'Divorciado(a)',
            'Viudo(a)' => 'Viudo(a)',
            'Conviviente' => 'Conviviente',
        ];
        $tipos_documentos = [
            'Documento de Identidad' => 'Documento de Identidad',
            'Pasaporte' => 'Pasaporte',
        ];
        return view('miembros.crear', compact('sexos', 'estado_civil','paises','departamentos','municipios','tipos_documentos'));
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
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'tipo_documento'=>'required',
            'numero_documento'=>['required', 'regex:/^\d{3}(?:\d{1,20})?$/'],
            'id_pais'=>'required',
            'departamento' => 'required_if:id_pais,65',
            'municipio' => 'required_if:id_pais,65',
            'telefono' => ['required', 'regex:/^\d{8}(?:\d{1,2})?$/'],
            'profesion'=>'required',
            'estado_civil'=>'required',
            'sexo'=>'required',
            'fecha_nacimiento'=> 'required|validateFechaMayorDe18',
            'costo_servicio'=> ['required', 'regex:/^\d+(\.\d+)?$/']
        ]);

        $password=Str::random(12);

        $input = $request->all();
        $user = User::create([
            'name'=>$request->input('name'),
            'last_name'=>$request->input('last_name'),
            'email'=>$request->input('email'),
            'password'=>Hash::make($password),
        ]);
        $user->assignRole(4);
        $persona = Persona::create([
            'tipo_documento'=>$request->input('tipo_documento'),
            'numero_documento'=>$request->input('numero_documento'),
            'id_pais'=>$request->input('id_pais'),
            'id_departamento'=>$request->input('departamento'),
            'id_municipio'=>$request->input('municipio'),
            'telefono'=>$request->input('telefono'),
            'profesion'=>$request->input('profesion'),
            'estado_civil'=>$request->input('estado_civil'),
            'sexo'=>$request->input('sexo'),
            'fecha_nacimiento'=>$request->input('fecha_nacimiento'),
        ]);
        $manoObra = ManoObra::create([
            'id_usuario' => $user->id,
            'id_persona' => $persona->id,
            'costo_servicio'=>$request->input('costo_servicio')
        ]);
        \Mail::to($user->email)->send(new NuevoUsuarioCreado($user->name." ".$user->last_name, $user->email, $password));
        return redirect()->route('miembros.index')->with('success', 'Mano de obra creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $manoObra = ManoObra::with('usuario')->with('persona')->find($id);
        if ($manoObra->persona->pais->name !== "El Salvador") {
            $departamento = null;
            $municipio = null;
        } else {
            $departamento = $manoObra->persona->departamento->nombre;
            $municipio = $manoObra->persona->municipio->nombre;
        }
        $manoObraUser = (object) ([
            'id_usuario' => $manoObra->usuario->id,
            'name' => $manoObra->usuario->name,
            'last_name' => $manoObra->usuario->last_name,
            'email' => $manoObra->usuario->email,
            'id' => $manoObra->id,
            'tipo_documento'=> $manoObra->persona->tipo_documento,
            'numero_documento'=> $manoObra->persona->numero_documento,
            'pais'=> $manoObra->persona->pais->name,
            'departamento'=> $departamento,
            'municipio'=> $municipio,
            'telefono' => $manoObra->persona->telefono,
            'profesion'=> $manoObra->persona->profesion,
            'estado_civil'=> $manoObra->persona->estado_civil,
            'sexo'=> $manoObra->persona->sexo,
            'fecha_nacimiento'=> $manoObra->persona->fecha_nacimiento,
            'costo_servicio'=> $manoObra->costo_servicio
        ]);
        return view('miembros.mostrar', compact('manoObraUser'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $manoObra = ManoObra::find($id);
        $paises = Pais::pluck('name', 'id')->all();
        $departamentos = Departamento::pluck('nombre', 'id')->all();
        $municipios = Municipio::all();
        $sexos = [
            'Masculino' => 'Masculino',
            'Femenino' => 'Femenino',
        ];
        $estado_civil = [
            'Soltero(a)' => 'Soltero(a)',
            'Casado(a)' => 'Casado(a)',
            'Divorciado(a)' => 'Divorciado(a)',
            'Viudo(a)' => 'Viudo(a)',
            'Conviviente' => 'Conviviente',
        ];
        $tipos_documentos = [
            'Documento de Identidad' => 'Documento de Identidad',
            'Pasaporte' => 'Pasaporte',
        ];
        if ($manoObra->persona->pais->name !== "El Salvador") {
            $departamento = null;
            $municipio = null;
        } else {
            $departamento = $manoObra->persona->id_departamento;
            $municipio = $manoObra->persona->id_municipio;
        }
        $manoObraUser = (object) ([
            'id_usuario' => $manoObra->usuario->id,
            'name' => $manoObra->usuario->name,
            'last_name' => $manoObra->usuario->last_name,
            'email' => $manoObra->usuario->email,
            'id' => $manoObra->id,
            'tipo_documento'=> $manoObra->persona->tipo_documento,
            'numero_documento'=> $manoObra->persona->numero_documento,
            'id_pais'=> $manoObra->persona->id_pais,
            'id_departamento'=> $departamento,
            'id_municipio'=> $municipio,
            'telefono' => $manoObra->persona->telefono,
            'profesion'=> $manoObra->persona->profesion,
            'estado_civil'=> $manoObra->persona->estado_civil,
            'sexo'=> $manoObra->persona->sexo,
            'fecha_nacimiento'=> $manoObra->persona->fecha_nacimiento,
            'costo_servicio'=> $manoObra->costo_servicio
        ]);
        return view('miembros.editar', compact('manoObraUser', 'sexos', 'estado_civil','paises','departamentos','municipios','tipos_documentos'));
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
        $manoObra = ManoObra::find($id);
        $user = User::find($manoObra->id_usuario);
        $persona = Persona::find($manoObra->id_persona);
        $this->validate($request, [
            'name' => 'required',
            'last_name' => 'required',
            'tipo_documento'=>'required',
            'numero_documento'=>['required', 'regex:/^\d{3}(?:\d{1,20})?$/'],
            'id_pais'=>'required',
            'departamento' => 'required_if:id_pais,65',
            'municipio' => 'required_if:id_pais,65',
            'telefono' => ['required', 'regex:/^\d{8}(?:\d{1,2})?$/'],
            'profesion'=>'required',
            'estado_civil'=>'required',
            'sexo'=>'required',
            'fecha_nacimiento'=> 'required|validateFechaMayorDe18',
            'costo_servicio'=> ['required', 'regex:/^\d+(\.\d+)?$/']
        ]);
        $user->update([
            'name'=>$request->input('name'),
            'last_name'=>$request->input('last_name'),
        ]);
        $persona->update([
            'tipo_documento'=>$request->input('tipo_documento'),
            'numero_documento'=>$request->input('numero_documento'),
            'id_pais'=>$request->input('id_pais'),
            'id_departamento'=>$request->input('departamento'),
            'id_municipio'=>$request->input('municipio'),
            'telefono'=>$request->input('telefono'),
            'profesion'=>$request->input('profesion'),
            'estado_civil'=>$request->input('estado_civil'),
            'sexo'=>$request->input('sexo'),
            'fecha_nacimiento'=>$request->input('fecha_nacimiento'),
        ]);
        $manoObra->update([
            'id_usuario' => $user->id,
            'id_persona' => $persona->id,
            'costo_servicio'=>$request->input('costo_servicio')
        ]);
        $user->assignRole($request->input('roles'));
        return redirect()->route('miembros.index')->with('success', 'Mano obra actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $manoObra = ManoObra::find($id);
        ManoObra::find($id)->delete();
        User::find($manoObra->id_usuario)->delete();
        Persona::find($manoObra->id_persona)->delete();
    }
}
