<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManoObra extends Model
{
    use HasFactory;
    protected $table = 'mano_obra';
    protected $fillable = [
        'dui',
        'afp',
        'isss',
        'nacionalidad',
        'pasaporte',
        'telefono',
        'profesion',
        'estado_civil',
        'sexo',
        'fecha_nacimiento',
        'costo_servicio',
        'id_usuario'
    ];
    public function usuario(){
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
