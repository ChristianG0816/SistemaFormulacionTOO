<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\TipoDocumento;
use App\Models\Documento;
use App\Models\Proyecto;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class DocumentoController extends Controller
{
    public function index($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $documentos = Documento::where('id_proyecto', $proyecto->id)->get();
        return view('proyectos.mostrar', compact('documentos', 'proyecto'));
    }

    public function data($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $data = Documento::where('id_proyecto', $proyecto->id)->with(['tipo_documento'])->get();
        return datatables()->of($data)->toJson();
    }

    public function create($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $tipoDocumentos = TipoDocumento::orderBy('nombre')->pluck('nombre', 'id')->all();
        return view('documentos.crear', compact('proyecto', 'tipoDocumentos'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id_tipo_documento' => 'required',
            'nombre' => 'required',
            'autor' => 'required',
            'link' => 'required|url',
            'fecha_creacion' => 'required'
        ]);

        $input = $request->all();
        $documento = Documento::create($input);
        $proyecto = Proyecto::find($request->id_proyecto);
        return redirect()->route('proyectos.show', ['proyecto' => $proyecto])->with('success', 'Documento creado con éxito');
    }

    public function edit( $id)
    {
        $documento = Documento::find($id);
        $proyecto = Proyecto::find($documento->id_proyecto);
        $tipoDocumentos = TipoDocumento::orderBy('nombre')->pluck('nombre', 'id')->all();
        return view('documentos.editar', compact('proyecto', 'tipoDocumentos','documento'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'id_tipo_documento' => 'required',
            'nombre' => 'required',
            'autor' => 'required',
            'link' => 'required|url',
            'fecha_creacion' => 'required'
        ]);

        $documento = Documento::find($id);
        $input = $request->all();
        $documento->update($input);
        $proyecto = Proyecto::find($request->id_proyecto);
        return redirect()->route('proyectos.show', ['proyecto' => $proyecto])->with('success', 'Documento actualizado con éxito');
    }

    public function destroy($id)
    {
        $documento = Documento::find($id);
        if($documento){$documento->delete();}
    }

}