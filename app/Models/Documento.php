<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;
    protected $table = 'documento';
    protected $fillable = [
        'nombre',
        'autor',
        'archivo',
        'fecha_creacion',
        'id_proyecto',
        'id_tipo_documento',
    ];
    public function documento(){
        return $this->belongsTo(Proyecto::class, 'id_proyecto');
    }
    public function tipo_documento(){
        return $this->belongsTo(TipoDocumento::class, 'id_tipo_documento');
    }
}
