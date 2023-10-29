<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'cliente';
    protected $fillable = [
        'tipo_cliente',
        'telefono',
        'id_usuario',
    ];
    public function usuario_cliente(){
        return $this->belongsTo(User::class, 'id_usuario');
    }
    public function contactos() {
        return $this->hasMany(Contacto::class);
    }
}
