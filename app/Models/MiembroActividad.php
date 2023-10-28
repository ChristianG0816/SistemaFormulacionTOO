<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiembroActividad extends Model
{
    use HasFactory;
    protected $table = 'miembro_actividad';
    protected $fillable = [
        'id_paquete_actividades',
        'id_equipo_trabajo'
    ];
    public function paquete_actividades(){
        return $this->belongsTo(Actividad::class, 'id_paquete_actividades');
    }
    public function equipo_trabajo(){
        return $this->belongsTo(EquipoTrabajo::class, 'id_equipo_trabajo');
    }
}
