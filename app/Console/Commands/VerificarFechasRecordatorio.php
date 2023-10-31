<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Evento;
use App\Models\Notificacion;
use Carbon\Carbon;
use App\Models\TipoNotificacion;
use App\Models\EquipoTrabajo;

class VerificarFechasRecordatorio extends Command
{
    protected $signature = 'verificar:fechas-recordatorio';
    protected $description = 'Verifica las fechas de recordatorio y envía notificaciones.';

    public function handle()
    {
        $hoy = Carbon::now();
        $eventos = Evento::where('fecha_recordatorio', $hoy)
            ->where('hora_recordatorio', '=', Carbon::now()->format('H:i'))
            ->get();

        foreach ($eventos as $evento) {
            $tipo_notificacion_valor = 14; 

            // Envío de notificación al gerente del proyecto
            $this->enviarNotificacion($evento->proyecto->id_gerente_proyecto, $evento, $tipo_notificacion_valor);
            
            // Envío de notificación a mano de obra
            $equipoTrabajo = EquipoTrabajo::where("id_proyecto", $evento->id_proyecto)->get();
            foreach ($equipoTrabajo as $miembro) {
                $this->enviarNotificacion($miembro->mano_obra->id_usuario, $evento, $tipo_notificacion_valor);
            }

            // Envío de notificación al cliente del proyecto
            $this->enviarNotificacion($evento->proyecto->cliente->id_usuario, $evento, $tipo_notificacion_valor);
        }
    }

    private function enviarNotificacion($usuarioId, $evento, $tipo_notificacion_valor)
    {
        $notificacion = new Notificacion();
        $notificacion->id_usuario = $usuarioId;
        $notificacion->id_tipo_notificacion = $tipo_notificacion_valor;
        $tipoNotificacion = TipoNotificacion::find($tipo_notificacion_valor);
        
        if ($tipoNotificacion) {
            $descripcion = $tipoNotificacion->descripcion;
            $descripcion2 = str_replace('{{nombre}}', $evento->nombre, $descripcion);
            $descripcion3 = str_replace('{{nombre_proyecto}}', $evento->proyecto->nombre, $descripcion2);
            $notificacion->descripcion = $descripcion3;
            $notificacion->ruta = $tipoNotificacion->ruta;
        }

        $notificacion->id_proyecto = $evento->id_proyecto;
        $notificacion->leida = false;
        $notificacion->save();
    }
}
