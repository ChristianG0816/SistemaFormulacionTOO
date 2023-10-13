<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proyecto;
use App\Models\Actividad;

class SeederDatosPrueba extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Proyecto::create([
            'nombre' => 'Proyecto 1',
            'objetivo' => 'Objetivo proyecto',
            'descripcion' => 'Descripcion proyecto',
            'entregable' => 'Entregable',
            'fecha_inicio' => '2023/10/01',
            'fecha_fin' => '2023/11/01',
            'presupuesto' => 4500.00,
            'prioridad' => 1,
            'id_estado_proyecto' => 1,
            'id_dueno' => 1,
            'id_cliente' => 2,
        ]);

        Actividad::create([
            'nombre' => 'Actividad 1',
            'prioridad' => 1,
            'fecha_inicio' => '2023/10/10',
            'fecha_fin' => '2023/10/15',
            'responsabilidades' => 'responsabilidad 1, 2, 3',
            'id_proyecto' => 1,
            'id_estado_actividad' => 1,
        ]);

        Actividad::create([
            'nombre' => 'Actividad 2',
            'prioridad' => 1,
            'fecha_inicio' => '2023/10/12',
            'fecha_fin' => '2023/10/16',
            'responsabilidades' => 'responsabilidad 1, 2, 3',
            'id_proyecto' => 1,
            'id_estado_actividad' => 1,
        ]);


    }
}
