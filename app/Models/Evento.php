<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;
    protected $table = 'evento';
    protected $fillable = [
        'nombre',
        'descripcion',
        'direccion',
        'fecha_inicio',
        'fecha_fin',
        'hora_inicio',
        'hora_fin',
        'fecha_recordatorio',
        'link_reunion',
        'id_proyecto'
    ];
    public function proyecto(){
        return $this->belongsTo(Proyecto::class, 'id_proyecto');
    }
}
