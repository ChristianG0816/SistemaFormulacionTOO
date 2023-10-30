<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;
    protected $table = 'contacto';
    protected $fillable = [
        'nombre',
        'apellido',
        'rol',
        'correo',
        'telefono',
        'id_cliente',
    ];
    public function contacto_cliente(){
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}
