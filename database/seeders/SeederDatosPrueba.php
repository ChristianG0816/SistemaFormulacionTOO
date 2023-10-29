<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proyecto;
use App\Models\Actividad;
use App\Models\ManoObra;
use App\Models\Persona;
use App\Models\EquipoTrabajo;

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
            'id_gerente_proyecto' => 7,
            'id_cliente' => 8,
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
            'id_gerente_proyecto' => 9,
            'id_cliente' => 8,
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
            'id_gerente_proyecto' => 7,
            'id_cliente' => 6,
        ]);

        Persona::create([
            'tipo_documento' => 'Documento de Identidad',
            'numero_documento' => '123546678',
            'id_pais' => 65,
            'id_departamento' => 1,
            'id_municipio' => 1,
            'telefono' => '64281475',
            'profesion' => 'Ingeniero',
            'estado_civil' => 'Casado',
            'sexo' => 'Masculino',
            'fecha_nacimiento' => '2000/12/08',
        ]);

        ManoObra::create([
            'costo_servicio' => 500.00,
            'id_usuario' => 3,
            'id_persona' => 1,
        ]);

        Persona::create([
            'tipo_documento' => 'Documento de Identidad',
            'numero_documento' => '163546689',
            'id_pais' => 65,
            'id_departamento' => 1,
            'id_municipio' => 1,
            'telefono' => '64281475',
            'profesion' => 'Tester',
            'estado_civil' => 'Casado',
            'sexo' => 'Femenino',
            'fecha_nacimiento' => '2000/10/24',
        ]);

        ManoObra::create([
            'costo_servicio' => 400.00,
            'id_usuario' => 4,
            'id_persona' => 2,
        ]);

        Persona::create([
            'tipo_documento' => 'Documento de Identidad',
            'numero_documento' => '163546658',
            'id_pais' => 4,
            'id_departamento' => null,
            'id_municipio' => null,
            'telefono' => '64281475',
            'profesion' => 'Ayudante',
            'estado_civil' => 'Casado',
            'sexo' => 'Femenino',
            'fecha_nacimiento' => '2000/08/24',
        ]);

        ManoObra::create([
            'costo_servicio' => 400.00,
            'id_usuario' => 5,
            'id_persona' => 3,
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

        
        Actividad::create([
            'nombre' => 'Actividad 1 Proyecto 1',
            'prioridad' => 1,
            'fecha_inicio' => '2023/10/10',
            'fecha_fin' => '2023/10/15',
            'responsabilidades' => 'responsabilidad 1, 2, 3',
            'id_proyecto' => 1,
            'id_estado_actividad' => 1,
            'id_responsable' => 1,
        ]);

        Actividad::create([
            'nombre' => 'Actividad 2 Proyecto 1',
            'prioridad' => 1,
            'fecha_inicio' => '2023/10/12',
            'fecha_fin' => '2023/10/16',
            'responsabilidades' => 'responsabilidad 1, 2, 3',
            'id_proyecto' => 1,
            'id_estado_actividad' => 1,
            'id_responsable' => 1,
        ]);

        Actividad::create([
            'nombre' => 'Actividad 1 Proyecto 2',
            'prioridad' => 1,
            'fecha_inicio' => '2023/11/10',
            'fecha_fin' => '2023/11/26',
            'responsabilidades' => 'responsabilidad 1, 2, 3',
            'id_proyecto' => 2,
            'id_estado_actividad' => 1,
            'id_responsable' => 2,
        ]);

        Actividad::create([
            'nombre' => 'Actividad 2 Proyecto 2',
            'prioridad' => 1,
            'fecha_inicio' => '2023/11/12',
            'fecha_fin' => '2023/11/20',
            'responsabilidades' => 'responsabilidad 1, 2, 3',
            'id_proyecto' => 2,
            'id_estado_actividad' => 1,
            'id_responsable' => 2,
        ]);


        Actividad::create([
            'nombre' => 'Actividad 1 Proyecto 3',
            'prioridad' => 1,
            'fecha_inicio' => '2023/09/10',
            'fecha_fin' => '2023/09/26',
            'responsabilidades' => 'responsabilidad 1, 2, 3',
            'id_proyecto' => 3,
            'id_estado_actividad' => 1,
            'id_responsable' => 3,
        ]);

        Actividad::create([
            'nombre' => 'Actividad 2 Proyecto 3',
            'prioridad' => 1,
            'fecha_inicio' => '2023/09/12',
            'fecha_fin' => '2023/09/20',
            'responsabilidades' => 'responsabilidad 1, 2, 3',
            'id_proyecto' => 3,
            'id_estado_actividad' => 1,
            'id_responsable' => 3,
        ]);

        Actividad::create([
            'nombre' => 'Actividad 3 Proyecto 3',
            'prioridad' => 1,
            'fecha_inicio' => '2023/11/10',
            'fecha_fin' => '2023/11/12',
            'responsabilidades' => 'responsabilidad 1, 2, 3',
            'id_proyecto' => 3,
            'id_estado_actividad' => 1,
            'id_responsable' => 3,
        ]);

        Actividad::create([
            'nombre' => 'Actividad 4 Proyecto 3',
            'prioridad' => 1,
            'fecha_inicio' => '2023/11/2',
            'fecha_fin' => '2023/11/8',
            'responsabilidades' => 'responsabilidad 1, 2, 3',
            'id_proyecto' => 3,
            'id_estado_actividad' => 1,
            'id_responsable' => 3,
        ]);

        Actividad::create([
            'nombre' => 'Actividad 5 Proyecto 3',
            'prioridad' => 1,
            'fecha_inicio' => '2023/11/05',
            'fecha_fin' => '2023/11/15',
            'responsabilidades' => 'responsabilidad 1, 2, 3',
            'id_proyecto' => 3,
            'id_estado_actividad' => 1,
            'id_responsable' => 3,
        ]);
    }
}
