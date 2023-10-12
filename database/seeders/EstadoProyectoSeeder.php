<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EstadoProyecto;

class EstadoProyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EstadoProyecto::create([
            'nombre' => 'Pendiente',
        ]);
        EstadoProyecto::create([
            'nombre' => 'En Proceso',
        ]);
        EstadoProyecto::create([
            'nombre' => 'Finalizado',
        ]);
        EstadoProyecto::create([
            'nombre' => 'Rechazado',
        ]);      
    }
}
