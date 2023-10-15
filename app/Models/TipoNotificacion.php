<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoNotificacion extends Model
{
    use HasFactory;
    protected $table = 'tipo_notificacion';
    protected $fillable = [
        'nombre',
        'descripcion',
        'icono',
        'color',
        'ruta'
    ];
}
