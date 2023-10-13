<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EstadoActividad;

class SeederTablaEstadoActividad extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
EstadoActividad::create([
            'nombre' => 'Pendiente',
        ]);
        EstadoActividad::create([
            'nombre' => 'En Proceso',
        ]);
        EstadoActividad::create([
            'nombre' => 'Finalizada',
        ]);
    }
}
