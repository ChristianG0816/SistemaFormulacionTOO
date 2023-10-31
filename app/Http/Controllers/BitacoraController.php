<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;


class BitacoraController extends Controller
{

    function __construct(){
        //Definición de permisos
        $this->middleware('permission:ver-bitacora|crear-bitacora|editar-bitacora|borrar-bitacora',['only'=>['index']]);
        $this->middleware('permission:crear-bitacora',['only'=>['create','store']]);
        $this->middleware('permission:editar-bitacora',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-bitacora',['only'=>['destroy']]);
    }

    /**
    * Reporte de bitácora generado a partir de un periodo de fechas, usuario y tipo de evento
    *
    * @param  \Illuminate\Http\Request  $request
    *         ['fecha_inicio_datos', 'fecha_fin_datos', 'usuario', 'evento'] Parámetros de entrada del formulario.
    * @return \Illuminate\Http\Response
    */
    public function index()
    {

    }
}
