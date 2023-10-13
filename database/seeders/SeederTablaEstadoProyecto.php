<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EstadoProyecto;

class SeederTablaEstadoProyecto extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estados = [
            EstadoProyecto::create(['nombre' => 'Formulacion',]),
            EstadoProyecto::create(['nombre' => 'Revision',]),
            EstadoProyecto::create(['nombre' => 'Aprobado',]),
            EstadoProyecto::create(['nombre' => 'Rechazado',]),      
            EstadoProyecto::create(['nombre' => 'Finalizado',]),
        ];
    }
}