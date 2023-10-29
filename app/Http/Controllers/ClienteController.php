<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cliente;
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
        if ($cliente) {
            $cliente->delete();
            /*$usuarioId = $cliente->id_usuario;
    
            $proyectosAsociados = DB::table('proyecto')->where('id_cliente', $cliente->id)->get();   
    
            if ($proyectosAsociados->isEmpty()) {
                DB::table('users')->where('id_usuario', $usuarioId)->delete();
                return redirect()->route('clientes.index')->with('success', 'Cliente eliminado con éxito');
            } else {
                return redirect()->route('clientes.index')->with('error', 'No se puede eliminar el cliente, existen proyectos asociados a él');
            }*/
        } else {
            return redirect()->route('clientes.index')->with('error', 'No se encontró el cliente');
        }
    }
    
}
