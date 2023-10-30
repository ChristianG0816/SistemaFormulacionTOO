<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Evento;
use App\Models\Notificacion;
use Carbon\Carbon;

class VerificarFechasRecordatorio extends Command
{
    protected $signature = 'verificar:fechas-recordatorio';
    protected $description = 'Verifica las fechas de recordatorio y envía notificaciones.';

    public function handle()
    {
        $hoy = Carbon::now();
        $eventos = Evento::where('fecha_recordatorio', $hoy)
         ->where('hora_recordatorio', '=', Carbon::now()->format('H:i'))->get();

        foreach ($eventos as $evento) {
            $notificacion = new Notificacion();
            $notificacion->id_usuario = $evento->proyecto->id_gerente_proyecto; 
            $notificacion->id_tipo_notificacion = 14; 
            $notificacion->descripcion = "Recordatorio para el evento: " . $evento->nombre . " perteneciente al proyecto " . $evento->proyecto->nombre;
            $notificacion->ruta = '/calendario'; 
            $notificacion->id_proyecto = $evento->id_proyecto;
            $notificacion->leida = false;
            $notificacion->save();
        }
    }
}
