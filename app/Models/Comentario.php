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
        'id_actividad',
        'id_usuario'
    ];
    public function actividad(){
        return $this->belongsTo(Actividad::class, 'id_actividad');
    }
    public function usuario(){
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
