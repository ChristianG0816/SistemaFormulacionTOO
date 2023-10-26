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
        'id_paquete_actividades',
        'finalizada'
    ];
    public function paquete_actividades(){
        return $this->belongsTo(PaqueteActividades::class, 'id_paquete_actividades');
    }
}
