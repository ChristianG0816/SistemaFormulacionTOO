<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;
    protected $table = 'proyecto';
    protected $fillable = [
        'nombre',
        'objetivo',
        'descripcion',
        'entregable',
        'fecha_inicio',
        'fecha_fin',
        'presupuesto',
        'prioridad',
        'id_estado_proyecto',
        'id_gerente_proyecto',
        'id_cliente'
    ];
    public function estado_proyecto(){
        return $this->belongsTo(EstadoProyecto::class, 'id_estado_proyecto');
    }
    public function gerente_proyecto(){
        return $this->belongsTo(User::class, 'id_gerente_proyecto');
    }
    public function cliente(){
        return $this->belongsTo(User::class, 'id_cliente');
    }
}
