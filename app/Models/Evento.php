<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    static $rules = [
        'nombre' => 'required',
        'descripcion'=> 'required',
        'direccion'=> 'required',
        'fecha_inicio'=> 'required',
        'fecha_fin'=> 'required',
        'hora_inicio'=> 'required',
        'hora_fin'=> 'required',
        'fecha_recordatorio'=> 'required',
        'link_reunion'=> 'required',
        
    ];

    protected $table = 'evento';
    protected $fillable = [
        'nombre',
        'descripcion',
        'direccion',
        'fecha_inicio',
        'fecha_fin',
        'hora_inicio',
        'hora_fin',
        'fecha_recordatorio',
        'link_reunion',
        'id_proyecto'
    ];
    public function proyecto(){
        return $this->belongsTo(Proyecto::class, 'id_proyecto');
    }
}
