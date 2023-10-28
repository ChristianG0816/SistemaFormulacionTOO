<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaqueteActividades extends Model
{
    use HasFactory;
    protected $table = 'paquete_actividades';
    protected $fillable = [
        'nombre',
        'prioridad',
        'fecha_inicio',
        'fecha_fin',
        'responsabilidades',
        'id_proyecto',
        'id_estado_actividad'
    ];
    public function proyecto(){
        return $this->belongsTo(Proyecto::class, 'id_proyecto');
    }
    public function estado_actividad(){
        return $this->belongsTo(EstadoActividad::class, 'id_estado_actividad');
    }
}
