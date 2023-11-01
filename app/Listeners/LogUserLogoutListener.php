<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Logout;

class LogUserLogoutListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */

     public function handle(Logout $event)
    {
        // Registrar el cierre de sesión en la tabla de bitácora
        $bitacora = new Bitacora();
        $bitacora->usuario = $event->user->name . ' ' . $event->user->last_name;
        $bitacora->contexto_Evento = 'Cierre de sesión';
        $bitacora->nombre_Evento = 'Cerrar Sesión';
        $bitacora->hora_accion = now();
        $bitacora->ip_Equipo = request()->ip();
        $bitacora->save();
    }
}
