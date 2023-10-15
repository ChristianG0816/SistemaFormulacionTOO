<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;
    protected $table = 'notificacion';
    protected $fillable = [
        'leida',
        'descripcion',
        'ruta',
        'id_tipo_notificacion',
        'id_proyecto',
        'id_evento',
        'id_actividad',
        'id_usuario'
    ];
    public function tipo_notificacion(){
        return $this->belongsTo(TipoNotificacion::class, 'id_tipo_notificacion');
    }
    public function proyecto(){
        return $this->belongsTo(Proyecto::class, 'id_proyecto');
    }
    public function evento(){
        return $this->belongsTo(Evento::class, 'id_evento');
    }
    public function actividad(){
        return $this->belongsTo(Actividad::class, 'id_actividad');
    }
    public function usuario(){
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
