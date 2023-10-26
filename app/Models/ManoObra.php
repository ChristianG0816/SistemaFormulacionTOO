<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManoObra extends Model
{
    use HasFactory;
    protected $table = 'mano_obra';
    protected $fillable = [
        'costo_servicio',
        'id_persona',
        'id_usuario'
    ];

    public function usuario(){
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function equipos()
    {
        return $this->hasMany(EquipoTrabajo::class, 'id_mano_obra');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }
}
