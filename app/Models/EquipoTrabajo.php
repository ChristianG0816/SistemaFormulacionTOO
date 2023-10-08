<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoTrabajo extends Model
{
    use HasFactory;
    protected $table = 'equipo_trabajo';
    protected $fillable = [
        'id_proyecto',
        'id_mano_obra'
    ];
    public function proyecto(){
        return $this->belongsTo(Proyecto::class, 'id_proyecto');
    }
    public function mano_obra(){
        return $this->belongsTo(ManoObra::class, 'id_mano_obra');
    }
}
