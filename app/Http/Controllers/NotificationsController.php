<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacion;
use Carbon\Carbon;

class NotificationsController extends Controller
{
    /**
     * Get the new notification data for the navbar notification.
     *
     * @param Request $request
     * @return Array
     */
    public function getNotificationsData(Request $request)
    {
        // For the sake of simplicity, assume we have a variable called
        // $notifications with the unread notifications. Each notification
        // have the next properties:
        // icon: An icon for the notification.
        // text: A text for the notification.
        // time: The time since notification was created on the server.
        // At next, we define a hardcoded variable with the explained format,
        // but you can assume this data comes from a database query.

        //otener id de usuario logeado
        $id = auth()->user()->id;
        //obtener notificaciones no leidas
        $notifications = Notificacion::where('leida', false)->where('id_usuario', $id)->get();

        Carbon::setLocale('es');
        //con la relacion tipo_notificacion obtener el icono y el texto
        foreach ($notifications as $key => $not) {
            $not['id'] = $not->id;
            $not['icon'] = $not->tipo_notificacion->icono;
            $not['text'] = $not->tipo_notificacion->nombre;
            $not['time'] = $not->created_at->diffForHumans();
            $not['color'] = $not->tipo_notificacion->color;
            $not['ruta'] = $not->tipo_notificacion->ruta;
        }

        $dropdownHtml = '';

        foreach ($notifications as $key => $not) {
            $icon = "<i class='mr-2 {$not['icon']}' style='color:{$not['color']}'></i>";
            $time = "<span class='float-right text-muted text-sm'>
                        {$not['time']}
                    </span>";
            $dropdownHtml .= "<a class='dropdown-item text-sm' href='/marcar_notificacion/{$not['id']}' data-method='post'>
                               {$icon}{$not['text']}{$time}
                           </a>";
            if ($key < count($notifications) - 1) {
                $dropdownHtml .= "<div class='dropdown-divider'></div>";
            }
        }
        

        // Return the new notification data.

        return [
            'label'       => count($notifications),
            'label_color' => 'danger',
            'icon_color'  => 'dark',
            'dropdown'    => $dropdownHtml,
        ];
    }

    public function marcarComoLeida($id)
    {
        $notificacionId = $id;
        // Marcar la notificación como leída en la base de datos
        $notificacion = Notificacion::find($notificacionId);
        $notificacion->leida = true;
        $notificacion->save();

        // Utiliza la función redirect() para redirigir a la URL de la notificación
        return redirect($notificacion->tipo_notificacion->ruta);
    }

}
