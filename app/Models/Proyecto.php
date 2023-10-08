<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;
    protected $table = 'proyecto';
    protected $fillable = [
        'cliente',
        'nombre',
        'objetivo',
        'descripcion',
        'entregable',
        'fecha_inicio',
        'fecha_fin',
        'presupuesto',
        'prioridad',
        'id_estado_proyecto',
        'id_dueño'
    ];
    public function estado_proyecto(){
        return $this->belongsTo(EstadoProyecto::class, 'id_estado_proyecto');
    }
    public function dueño(){
        return $this->belongsTo(User::class, 'id_dueño');
    }
}
