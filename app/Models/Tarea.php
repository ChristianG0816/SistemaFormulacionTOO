<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;
    protected $table = 'tarea';
    protected $fillable = [
        'nombre',
        'id_actividad',
        'finalizada'
    ];
    public function actividad(){
        return $this->belongsTo(Actividad::class, 'id_actividad');
    }
}
