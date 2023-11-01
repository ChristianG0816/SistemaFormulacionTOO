<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacto;
use App\Models\Cliente;
use App\Models\User;

class ContactoController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-contacto|crear-contacto|editar-contacto|borrar-contacto', ['only' => ['index']]);
        $this->middleware('permission:crear-contacto', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-contacto', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-contacto', ['only' => ['destroy']]);
    }

    public function index($id)
    {
        $cliente = Cliente::findOrFail($id);
        $contactos = Contacto::where('id_cliente', $cliente->id)->get();
        return view('clientes.index', compact('contactos','cliente'));
    }

    public function data($id) {
        $data = Contacto::where('id_cliente', $id)->get();
        return datatables()->of($data)->toJson();
    }

    public function create($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('contactos.crear', compact('cliente'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'apellido' => 'required',
            'rol' => 'required',
            'correo' => 'required|email',
            'telefono'=>'nullable|regex:/^\d{4}-\d{4}$/',
        ]);

        $existingContact = Contacto::where('id_cliente', $request->id_cliente)
        ->where(function ($query) use ($request) {
            $query->where('correo', $request->correo)
                ->orWhere('telefono', $request->telefono);
        })
        ->first();

        if ($existingContact) {
            $errors = [];
            if ($existingContact->correo === $request->correo) {
                $errors['correo'] = 'El correo ya está asociado a este cliente';
            }
            if ($existingContact->telefono !== null && $existingContact->telefono === $request->telefono) {
                $errors['telefono'] = 'El teléfono ya está asociado a este cliente';
            }
            return redirect()->back()->withInput()->withErrors($errors);
        }

        $input = $request->all();
        $contacto = Contacto::create($input);
        $cliente = Cliente::find($contacto->id_cliente);
        return redirect()->route('clientes.show', ['cliente' => $cliente])->with('success', 'Contacto creado con éxito');
    }

    public function edit( $id)
    {
        $contacto = Contacto::find($id);
        $cliente = Cliente::findOrFail($contacto->id_cliente);
        return view('contactos.editar', compact('cliente','contacto'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'apellido' => 'required',
            'rol' => 'required',
            'correo' => 'required|email',
            'telefono'=>'nullable|regex:/^\d{4}-\d{4}$/',
        ]);

        $existingContact = Contacto::where('id_cliente', $request->id_cliente)
        ->where('id', '!=', $id)
        ->where(function ($query) use ($request) {$query->where('correo', $request->correo)->orWhere('telefono', $request->telefono);})
        ->first();

        if ($existingContact) {
            $errors = [];
            if ($existingContact->correo === $request->correo) {
                $errors['correo'] = 'El correo ya está asociado a este cliente';
            }
            if ($existingContact->telefono !== null && $existingContact->telefono === $request->telefono) {
                $errors['telefono'] = 'El teléfono ya está asociado a este cliente';
            }
            return redirect()->back()->withInput()->withErrors($errors);
        }

        $contacto = Contacto::find($id);
        $input = $request->all();
        $contacto->update($input);
        $cliente = Cliente::find($contacto->id_cliente);
        return redirect()->route('clientes.show', ['cliente' => $cliente])->with('success', 'Contacto actualizado con éxito');
    }

    public function destroy($id)
    {
        $contacto = Contacto::find($id);
        if($contacto){$contacto->delete();}
    }
}
