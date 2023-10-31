<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;
    protected $table = 'documento';
    protected $fillable = [
        'id_tipo_documento',
        'nombre',
        'autor',
        'link',
        'fecha_creacion',
        'id_proyecto'
    ];
    public function documento(){
        return $this->belongsTo(Proyecto::class, 'id_proyecto');
    }
    public function tipo_documento(){
        return $this->belongsTo(TipoDocumento::class, 'id_tipo_documento');
    }
}
