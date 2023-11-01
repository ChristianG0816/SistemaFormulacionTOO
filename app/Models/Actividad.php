<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;
    protected $table = 'actividad';
    protected $fillable = [
        'nombre',
        'prioridad',
        'fecha_inicio',
        'fecha_fin',
        'fecha_fin_real',
        'responsabilidades',
        'id_proyecto',
        'id_estado_actividad',
        'id_responsable'
    ];
    public function proyecto(){
        return $this->belongsTo(Proyecto::class, 'id_proyecto');
    }
    public function estado_actividad(){
        return $this->belongsTo(EstadoActividad::class, 'id_estado_actividad');
    }
    public function responsable(){
        return $this->belongsTo(EquipoTrabajo::class, 'id_responsable');
    }
}
