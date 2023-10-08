<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoProyecto extends Model
{
    use HasFactory;
    protected $table = 'estado_proyecto';
    protected $fillable = [
        'nombre'
    ];

}
