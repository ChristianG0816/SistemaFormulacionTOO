<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoActividad extends Model
{
    use HasFactory;
    protected $table = 'estado_actividad';
    protected $fillable = [
        'nombre'
    ];
}
