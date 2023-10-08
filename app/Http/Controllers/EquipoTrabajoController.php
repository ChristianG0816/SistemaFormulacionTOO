<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquipoTrabajoController extends Controller
{
    function __construct(){
        //Defincion de permisos
        $this->middleware('permission:ver-equipo-trabajo')->only(['index']);
        $this->middleware('permission:crear-equipo-trabajo')->only(['create', 'store']);
        $this->middleware('permission:editar-equipo-trabajo')->only(['edit', 'update']);
        $this->middleware('permission:eliminar-equipo-trabajo')->only(['destroy']);
    }
}
