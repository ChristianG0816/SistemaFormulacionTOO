<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionRecurso extends Model
{
    use HasFactory;
    protected $table = 'asignacion_recurso';
    protected $fillable = [
        'id_paquete_actividades',
        'id_recurso',
        'cantidad'
    ];
    public function paquete_actividades(){
        return $this->belongsTo(Actividad::class, 'id_paquete_actividades');
    }
    public function recurso(){
        return $this->belongsTo(Recurso::class, 'id_recurso');
    }
}
