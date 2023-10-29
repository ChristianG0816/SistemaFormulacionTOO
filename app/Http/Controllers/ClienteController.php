<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Proyecto;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\NuevoUsuarioCreado;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    public function data() {
        $data = Cliente::with('usuario_cliente')->get();
        return datatables()->of($data)->toJson();
    }

    public function create()
    {
        return view('clientes.crear');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'tipo_cliente' => 'required',
            'email' => 'required|email|unique:users,email',
            'telefono' => 'required'
        ];
    
        if ($request->tipo_cliente === 'Persona Natural') {
            $rules['last_name'] = 'required';
        }
        $this->validate($request, $rules);

        $password=Str::random(12);

        $input = $request->all();
        $user = User::create([
            'name'=>$request->input('name'),
            'last_name'=>$request->input('last_name'),
            'email'=>$request->input('email'),
            'password'=>Hash::make($password),
        ]);
        $user->assignRole(2);

        $cliente = Cliente::create([
            'tipo_cliente'=>$request->input('tipo_cliente'),
            'telefono'=>$request->input('telefono'),
            'id_usuario' => $user->id
        ]);
        \Mail::to($user->email)->send(new NuevoUsuarioCreado($user->name." ".$user->last_name, $user->email, $password));
        return redirect()->route('clientes.index')->with('success', 'Cliente registrado con éxito');
    }

    public function show($id)
    {
        $cliente = Cliente::find($id);
        return view('clientes.mostrar', compact('cliente'));
    }

    public function destroy($id)
    {
        $cliente = Cliente::find($id);
        $proyectosAsociados = Proyecto::where('id_cliente', $id)->get();
        if (!$proyectosAsociados->isEmpty()) {
            return response()->json(['error' => 'No se puede eliminar el cliente, existen proyectos asociados a él'], 422);
        } else {
            $usuarioId = $cliente->id_usuario;
            if($cliente){$cliente->delete();}   
            $user = User::where('id', $usuarioId)->first();
            if ($user) {$user->delete();}
            return response()->json(['success' => 'Se ha eliminado correctamente el cliente']);
        }
    }
    
}
