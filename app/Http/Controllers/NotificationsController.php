<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacion;
use Carbon\Carbon;

class NotificationsController extends Controller
{

    public function index()
    {
        return view('notificaciones.index');
    }

    /**
     * Get the new notification data for the navbar notification.
     *
     * @param Request $request
     * @return Array
     */
    public function getNotificationsData(Request $request)
    {
        //otener id de usuario logeado
        $id = auth()->user()->id;
        //obtener notificaciones no leidas
        $notifications = Notificacion::where('leida', false)->where('id_usuario', $id)->get();

        Carbon::setLocale('es');
        //con la relacion tipo_notificacion obtener el icono y el texto
        foreach ($notifications as $key => $not) {
            $not['id'] = $not->id;
            $not['icon'] = $not->tipo_notificacion->icono;
            $not['text'] = $not->descripcion;
            $not['time'] = $not->created_at->diffForHumans();
            $not['color'] = $not->tipo_notificacion->color;
            $not['ruta'] = $not->ruta;
        }

        $dropdownHtml = '';

        foreach ($notifications as $key => $not) {
            $icon = "<i class='mr-2 {$not['icon']}' style='color:{$not['color']}'></i>";
            $time = "<span class='float-right text-muted text-sm'>
                        {$not['time']}
                    </span>";
            $text = "<p class='text-sm dropdown-notification-text'>{$not['text']}</p>";
            $dropdownHtml .= "<a class='dropdown-item d-flex align-items-center justify-content-between' href='/abrir_notificacion/{$not['id']}' data-method='post'>
                               {$icon}{$text}{$time}
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

    public function getNotificationsTable(){
        $id = auth()->user()->id;
        $notificaciones = Notificacion::where('id_usuario', $id)->get()->sortByDesc('created_at');
        return datatables()->of($notificaciones)
        ->addColumn('tipo', function ($notificacion) {
            return $notificacion->tipo_notificacion->nombre;
        })
        ->addColumn('descripcion', function ($notificacion) {
            return $notificacion->descripcion;
        })
        ->addColumn('fecha', function ($notificacion) {
            return $notificacion->created_at->format('d/m/Y');
        })
        ->addColumn('hora', function ($notificacion) {
            return $notificacion->created_at->format('H:i');
        })
        ->addColumn('leida', function ($notificacion) {
            if($notificacion->leida){
                return '<span class="badge badge-success">Leída</span>';
            }else{
                return '<span class="badge badge-danger">No leída</span>';
            }
        })
        ->addColumn('acciones', function ($notificacion) {
            //si la notificacion no ha sido leida, mostrar el boton de marcar como leida
            if(!$notificacion->leida){
                $marcar_leida = '<button data-id="'.$notificacion->id.'" class="btn btn-outline-success btn-sm ml-1 marcar-leida-notificacion">Marcar como leída</button>';
            }else{
                $marcar_leida = '';
            }
            //boton de arbir notificacion
            $boton_abrir = '<a href="/abrir_notificacion/'.$notificacion->id.'" class="btn btn-outline-secondary btn-sm ml-1">Mostrar</a>';
            //boton de eliminar
            $boton_eliminar = '<button data-id="'.$notificacion->id.'" class="btn btn-outline-danger btn-sm ml-1 eliminar-notificacion">Eliminar</button>';
            return $marcar_leida.$boton_abrir.$boton_eliminar;
        })
        ->rawColumns(['leida', 'acciones'])
        ->make(true);
    }

    public function abrirNotificacion($id)
    {
        $notificacionId = $id;
        // Marcar la notificación como leída en la base de datos
        $notificacion = Notificacion::find($notificacionId);
        $notificacion->leida = true;
        $notificacion->save();

        // Utiliza la función redirect() para redirigir a la URL de la notificación
        return redirect($notificacion->ruta);
    }

    public function eliminarNotificacion(Request $request, $id){
        $id_notificacion = $id;
        try{
            $notificacion = Notificacion::find($id_notificacion);
            if(!$notificacion){
                return response()->json(['error'=>'No se encontró la notificación.']);
            }
            $notificacion->delete();
            return response()->json(['success'=>'Notificación eliminada correctamente.']);
        }
        catch(\Exception $e){
            return response()->json(['error'=>'Error al eliminar la notificación.']);
        }
    }

    public function eliminarTodasNotificacion(Request $request){
        try{
            $id = auth()->user()->id;
            $notificaciones = Notificacion::where('id_usuario', intval($id))->get();
            if(!$notificaciones->isEmpty()){
                foreach($notificaciones as $notificacion){
                    $notificacion->delete();
                }
                return response()->json(['success'=>'Notificaciones eliminadas correctamente.']);
            }
            return response()->json(['success'=>'No se encontraron notificaciones.']);
        }
        catch(\Exception $e){
            return response()->json(['error'=>'Error al eliminar las notificaciones.']);
        }
    }

    public function marcarLeida(Request $request, $id){
        $id_notificacion = $id;
        try{
            $notificacion = Notificacion::find($id_notificacion);
            if(!$notificacion){
                return response()->json(['error'=>'No se encontró la notificación.']);
            }
            $notificacion->leida = true;
            $notificacion->save();
            return response()->json(['success'=>'Notificación marcada como leída correctamente.']);
        }
        catch(\Exception $e){
            return response()->json(['error'=>'Error al marcar como leída la notificación.']);
        }
    }

    public function marcarTodasLeida(Request $request){
        try{
            $id = auth()->user()->id;
            $notificaciones = Notificacion::where('id_usuario', $id)->where('leida', false)->get();
            if(!$notificaciones->isEmpty()){ // Verifica si hay notificaciones no leídas
                foreach($notificaciones as $notificacion){
                    $notificacion->leida = true;
                    $notificacion->save();
                }
                return response()->json(['success' => 'Notificaciones marcadas correctamente.']);
            } else {
                return response()->json(['success' => 'No se encontraron notificaciones por marcar como leídas.']);
            }
        }
        catch(\Exception $e){
            return response()->json(['error' => 'Error al marcar las notificaciones como leídas.']);
        }
    }
    
}
