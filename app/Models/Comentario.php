<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    protected $table = 'comentario';
    protected $fillable = [
        'linea_comentario',
        'id_paquete_actividades',
        'id_usuario'
    ];
    public function paquete_actividades(){
        return $this->belongsTo(PaqueteActividades::class, 'id_paquete_actividades');
    }
    public function usuario(){
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
