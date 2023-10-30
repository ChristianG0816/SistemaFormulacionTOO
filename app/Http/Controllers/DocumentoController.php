<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
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
        return view('documentos.crear', compact('proyecto'));
    }

    public function store(Request $request)
    {
        
    }


}