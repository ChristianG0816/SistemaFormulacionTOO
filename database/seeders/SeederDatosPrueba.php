<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proyecto;
use App\Models\Actividad;
use App\Models\ManoObra;
use App\Models\EquipoTrabajo;
use App\Models\MiembroActividad;

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

        Proyecto::create([
            'nombre' => 'Proyecto 2',
            'objetivo' => 'Objetivo proyecto 2',
            'descripcion' => 'Descripcion proyecto 2',
            'entregable' => 'Entregable',
            'fecha_inicio' => '2023/11/01',
            'fecha_fin' => '2023/11/30',
            'presupuesto' => 2500.00,
            'prioridad' => 1,
            'id_estado_proyecto' => 1,
            'id_dueno' => 1,
            'id_cliente' => 2,
        ]);

        Proyecto::create([
            'nombre' => 'Proyecto 3',
            'objetivo' => 'Objetivo proyecto 3',
            'descripcion' => 'Descripcion proyecto 3',
            'entregable' => 'Entregable',
            'fecha_inicio' => '2023/09/01',
            'fecha_fin' => '2023/09/30',
            'presupuesto' => 2500.00,
            'prioridad' => 1,
            'id_estado_proyecto' => 1,
            'id_dueno' => 6,
            'id_cliente' => 7,
        ]);

        Actividad::create([
            'nombre' => 'Actividad 1 Proyecto 1',
            'prioridad' => 1,
            'fecha_inicio' => '2023/10/10',
            'fecha_fin' => '2023/10/15',
            'responsabilidades' => 'responsabilidad 1, 2, 3',
            'id_proyecto' => 1,
            'id_estado_actividad' => 1,
        ]);

        Actividad::create([
            'nombre' => 'Actividad 2 Proyecto 1',
            'prioridad' => 1,
            'fecha_inicio' => '2023/10/12',
            'fecha_fin' => '2023/10/16',
            'responsabilidades' => 'responsabilidad 1, 2, 3',
            'id_proyecto' => 1,
            'id_estado_actividad' => 1,
        ]);

        Actividad::create([
            'nombre' => 'Actividad 1 Proyecto 2',
            'prioridad' => 1,
            'fecha_inicio' => '2023/11/10',
            'fecha_fin' => '2023/11/26',
            'responsabilidades' => 'responsabilidad 1, 2, 3',
            'id_proyecto' => 2,
            'id_estado_actividad' => 1,
        ]);

        Actividad::create([
            'nombre' => 'Actividad 2 Proyecto 2',
            'prioridad' => 1,
            'fecha_inicio' => '2023/11/12',
            'fecha_fin' => '2023/11/20',
            'responsabilidades' => 'responsabilidad 1, 2, 3',
            'id_proyecto' => 2,
            'id_estado_actividad' => 1,
        ]);


        Actividad::create([
            'nombre' => 'Actividad 1 Proyecto 3',
            'prioridad' => 1,
            'fecha_inicio' => '2023/09/10',
            'fecha_fin' => '2023/09/26',
            'responsabilidades' => 'responsabilidad 1, 2, 3',
            'id_proyecto' => 3,
            'id_estado_actividad' => 1,
        ]);

        Actividad::create([
            'nombre' => 'Actividad 2 Proyecto 3',
            'prioridad' => 1,
            'fecha_inicio' => '2023/09/12',
            'fecha_fin' => '2023/09/20',
            'responsabilidades' => 'responsabilidad 1, 2, 3',
            'id_proyecto' => 3,
            'id_estado_actividad' => 1,
        ]);

        Actividad::create([
            'nombre' => 'Actividad 3 Proyecto 3',
            'prioridad' => 1,
            'fecha_inicio' => '2023/11/10',
            'fecha_fin' => '2023/11/12',
            'responsabilidades' => 'responsabilidad 1, 2, 3',
            'id_proyecto' => 3,
            'id_estado_actividad' => 1,
        ]);

        Actividad::create([
            'nombre' => 'Actividad 4 Proyecto 3',
            'prioridad' => 1,
            'fecha_inicio' => '2023/11/2',
            'fecha_fin' => '2023/11/8',
            'responsabilidades' => 'responsabilidad 1, 2, 3',
            'id_proyecto' => 3,
            'id_estado_actividad' => 1,
        ]);

        Actividad::create([
            'nombre' => 'Actividad 5 Proyecto 3',
            'prioridad' => 1,
            'fecha_inicio' => '2023/11/05',
            'fecha_fin' => '2023/11/15',
            'responsabilidades' => 'responsabilidad 1, 2, 3',
            'id_proyecto' => 3,
            'id_estado_actividad' => 1,
        ]);

        ManoObra::create([
            'dui' => '060803147',
            'afp' => '1235466',
            'isss' => '9751325',
            'nacionalidad' => 'Salvadoreño',
            'pasaporte' => '4318741',
            'telefono' => '64281475',
            'profesion' => 'Ingeniero',
            'estado_civil' => 'Casado',
            'sexo' => 'M',
            'fecha_nacimiento' => '2000/12/08',
            'costo_servicio' => 500.00,
            'id_usuario' => 3,
        ]);

        ManoObra::create([
            'dui' => '080803147',
            'afp' => '1635466',
            'isss' => '9757325',
            'nacionalidad' => 'Salvadoreño',
            'pasaporte' => '4318741',
            'telefono' => '64281475',
            'profesion' => 'Tester',
            'estado_civil' => 'Casado',
            'sexo' => 'F',
            'fecha_nacimiento' => '2000/10/24',
            'costo_servicio' => 400.00,
            'id_usuario' => 4,
        ]);

        ManoObra::create([
            'dui' => '080803147',
            'afp' => '1635466',
            'isss' => '9757325',
            'nacionalidad' => 'Canandiense',
            'pasaporte' => '4318741',
            'telefono' => '64281475',
            'profesion' => 'Tester',
            'estado_civil' => 'Casado',
            'sexo' => 'F',
            'fecha_nacimiento' => '2000/08/24',
            'costo_servicio' => 400.00,
            'id_usuario' => 5,
        ]);


        EquipoTrabajo::Create([
            'id_proyecto' => 1,
            'id_mano_obra' => 1,
        ]);

        EquipoTrabajo::Create([
            'id_proyecto' => 2,
            'id_mano_obra' => 2,
        ]);

        EquipoTrabajo::Create([
            'id_proyecto' => 3,
            'id_mano_obra' => 2,
        ]);

        EquipoTrabajo::Create([
            'id_proyecto' => 3,
            'id_mano_obra' => 3,
        ]);

        MiembroActividad::create([
            'id_actividad' => 1 ,
            'id_equipo_trabajo' => 1,
        ]);

        MiembroActividad::create([
            'id_actividad' => 2 ,
            'id_equipo_trabajo' => 1,
        ]);

        MiembroActividad::create([
            'id_actividad' => 3 ,
            'id_equipo_trabajo' => 2,
        ]);

        MiembroActividad::create([
            'id_actividad' => 4 ,
            'id_equipo_trabajo' => 2,
        ]);

        MiembroActividad::create([
            'id_actividad' => 5 ,
            'id_equipo_trabajo' => 3,
        ]);

        MiembroActividad::create([
            'id_actividad' => 6 ,
            'id_equipo_trabajo' => 3,
        ]);

        MiembroActividad::create([
            'id_actividad' => 7 ,
            'id_equipo_trabajo' => 3,
        ]);

        MiembroActividad::create([
            'id_actividad' => 8 ,
            'id_equipo_trabajo' => 3,
        ]);

        MiembroActividad::create([
            'id_actividad' => 9 ,
            'id_equipo_trabajo' => 4,
        ]);

    }
}
