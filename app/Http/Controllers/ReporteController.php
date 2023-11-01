<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\AsignacionRecurso;
use App\Models\EquipoTrabajo;
use App\Models\ManoObra;
use App\Models\Proyecto;
use App\Models\Actividad;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use PDF;

class ReporteController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-reporte', ['only' => ['index']]);
    }

    public function index()
    {
        return view('reportes.index');
    }

    public function data()
    {
        $proyectos = Proyecto::with('estado_proyecto', 'gerente_proyecto', 'cliente')->get();
    
        return datatables()->of($proyectos)
            ->addColumn('cliente_nombre', function ($row) {
                return $row->cliente->usuario_cliente->name . ' ' . $row->cliente->usuario_cliente->last_name;
            })
            ->addColumn('gerente_proyecto_nombre', function ($row) {
                return $row->gerente_proyecto->name . ' ' . $row->gerente_proyecto->last_name;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function generarInformeGastos($id)
    {
        $proyecto = Proyecto::find($id);
        $manoDeObra = EquipoTrabajo::where('id_proyecto', $id)->with(['mano_obra'])->get();
        $actividades = Actividad::where('id_proyecto', $id)->pluck('id')->toArray();
        $recursos = AsignacionRecurso::whereIn('id_actividad', $actividades)->with(['actividad', 'recurso'])->get()->groupBy('id_recurso');
        $activities = Actividad::where('id_proyecto', $id)->get();
        $recursosPorActividad = [];

        foreach ($activities as $actividad) {
            $asignacionesRecursos = AsignacionRecurso::where('id_actividad', $actividad->id)->with(['actividad', 'recurso'])->get();
    
            $subtotales = $asignacionesRecursos->map(function ($asignacion) {
                return $asignacion->cantidad * $asignacion->recurso->costo;
            });
    
            $recursosPorActividad[] = [
                'actividad' => $actividad,
                'asignacionesRecursos' => $asignacionesRecursos,
                'subtotal' => $subtotales->sum()
            ];
        }

        $subtotalesRecursos = [];
        $subtotalesRecursos = $recursos->map(function ($asignaciones) {
            return $asignaciones->sum(function ($asignacion) {
                return $asignacion->cantidad * $asignacion->recurso->costo;
            });
        });
        $gastoTotalRecursos = $subtotalesRecursos->sum();
    
        $subtotalesManoObra = [];
        $subtotalesManoObra = $manoDeObra->map(function ($manoObra) {
            return $manoObra->mano_obra->costo_servicio;
        });
        $gastoTotalManoObra = $subtotalesManoObra->sum();
        
        $gastoTotal = $gastoTotalManoObra + $gastoTotalRecursos;

        // Genera el PDF con la información obtenida
        $pdf = PDF::loadView('reportes.informeGastos', [
            'recursos' => $recursos,
            'proyecto' => $proyecto,
            'manoDeObra' => $manoDeObra,
            'recursosActividad' => $recursosPorActividad,
            'gastoTotalRecursos' => $gastoTotalRecursos,
            'gastoTotalManoObra' => $gastoTotalManoObra,
            'gastoTotal' => $gastoTotal,
        ]);
        return $pdf->stream('Informe de Gastos ' . $proyecto->nombre . '.pdf');
    }

}