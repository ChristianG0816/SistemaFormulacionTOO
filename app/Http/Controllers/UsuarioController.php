<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use PragmaRX\Google2FA\Google2FA;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('usuarios.crear', compact('roles'));
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
            'password' => [
                'required',
                'regex:/(^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*])(?=.{8,}))/',
                'same:confirm-password',
            ],
            'confirm-password' => 'required',
            'roles' => 'required'
        ], [
            'password.regex' => 'La contraseña debe contener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.',
        ]);
        
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado con éxito');
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        return view('usuarios.editar', compact('user','roles','userRole'));
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
        $rules = [
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'roles' => 'required',
        ];
    
        // Verificar si se proporcionó una nueva contraseña
        if (!empty($request->input('password'))) {
            $rules['password'] = [
                'nullable',
                'regex:/(^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*])(?=.{8,}))/',
                'same:confirm-password',
            ];
        }
    
        $this->validate($request, $rules, [
            'password.regex' => 'La contraseña debe contener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.',
        ]);
    
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }
    
        $user = User::find($id);
    
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
    
        $user->assignRole($request->input('roles'));
        return redirect()->route('usuarios.index')->with('success', 'Usuario modificado con éxito');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado con éxito');
    }

    public function data() {
    
    $usuarios = User::all();
    $data = [];

    foreach ($usuarios as $usuario) {
        $data[] = [
            'id' => $usuario->id,
            'name' => $usuario->name,
            'email' => $usuario->email,
            'roles' => $usuario->getRoleNames(),
            /*'roles' => $usuario->roles->pluck('name')->implode(', '),*/
        ];
    }

    return datatables()->of($data)->toJson();
}



}
