<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
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
        Cliente::create([
            'tipo_cliente' => 'Persona Natural',
            'telefono' => '1235-1235',
            'id_usuario' => 8,
        ]);
        Cliente::create([
            'tipo_cliente' => 'Persona Natural',
            'telefono' => '1234-1234',
            'id_usuario' => 6,
        ]);

        Proyecto::create([
            'nombre' => 'Reconvirtiendo el Territorio',
            'objetivo' => 'Mitigar el impacto del COVID-19 en las empresas, impulsando la transformación digital y la innovación en 32 municipios costeros, a través de un instrumento de cofinanciamiento no reembolsable para la reconversión de negocios',
            'descripcion' => 'Este proyecto propone un instrumento de cofinanciamiento no reembolsable que facilitará la reconversión de negocios, estimulando la creación de nuevos productos y servicios diferenciados',
            'entregable' => 'Documento de Planificación Estratégica, Informe de Impacto y Resultados.',
            'fecha_inicio' => '2023/10/01',
            'fecha_fin' => '2023/11/01',
            'presupuesto' => 4500.00,
            'prioridad' => 1,
            'id_estado_proyecto' => 1,
            'id_gerente_proyecto' => 7,
            'id_cliente' => 1,
        ]);

        Proyecto::create([
            'nombre' => 'Plataforma de Capacitación Empresarial',
            'objetivo' => 'Desarrollar una plataforma en línea que brinde capacitación empresarial a emprendedores y empresarios, promoviendo el crecimiento económico mediante cursos y recursos de formación en gestión de negocios, marketing, finanzas y habilidades empresariales',
            'descripcion' => 'El proyecto se enfoca en la creación de una plataforma educativa en línea que ofrecerá una amplia gama de cursos y materiales de capacitación. Los usuarios podrán acceder a contenido educativo de alta calidad y participar en actividades de aprendizaje interactivo, lo que les permitirá adquirir conocimientos y habilidades empresariales clave',
            'entregable' => 'Plataforma de Capacitación Empresarial',
            'fecha_inicio' => '2023/11/01',
            'fecha_fin' => '2023/11/30' ,
            'presupuesto' => 2500.00,
            'prioridad' => 1,
            'id_estado_proyecto' => 1,
            'id_gerente_proyecto' => 7,
            'id_cliente' => 1,
        ]);

        Proyecto::create([
            'nombre' => 'Portal de Información Económica',
            'objetivo' => 'Crear plataforma online para ofrecer información económica actualizada y relevante, para facilitar acceso a datos, informes y análisis para tomadores de decisiones, fomentando el desarrollo económico mediante decisiones informadas',
            'descripcion' => 'El proyecto se enfoca en la creación y desarrollo de un portal web que albergará información económica clave, como indicadores económicos, tasas de cambio, cifras de empleo, y más. Los usuarios podrán acceder a datos actualizados, informes, gráficos y análisis, lo que facilitará la toma de decisiones informadas en el ámbito económico',
            'entregable' => 'Portal de Información Económica',
            'fecha_inicio' => '2023/09/01',
            'fecha_fin' => '2023/09/30',
            'presupuesto' => 2500.00,
            'prioridad' => 1,
            'id_estado_proyecto' => 1,
            'id_gerente_proyecto' => 7,
            'id_cliente' => 2,
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
            'nombre' => 'Reconversión de modelo de negocio basado en soluciones TICs',
            'prioridad' => 1,
            'fecha_inicio' => '2023/10/10',
            'fecha_fin' => '2023/10/15',
            'responsabilidades' => 'Investigación de mercado para identificar oportunidades en el sector de tecnologías de la información y comunicación',
            'id_proyecto' => 1,
            'id_estado_actividad' => 1,
            'id_responsable' => 1,
        ]);

        Actividad::create([
            'nombre' => 'Reconversión de modelo de negocio basado en innovación organizacional',
            'prioridad' => 1,
            'fecha_inicio' => '2023/10/12',
            'fecha_fin' => '2023/10/16',
            'responsabilidades' => 'Desarrollo de estrategias y planes de acción para promover la innovación en la estructura y cultura organizacional',
            'id_proyecto' => 1,
            'id_estado_actividad' => 1,
            'id_responsable' => 1,
        ]);

        Actividad::create([
            'nombre' => 'Desarrollo de Contenido Educativo',
            'prioridad' => 1,
            'fecha_inicio' => '2023/11/10',
            'fecha_fin' => '2023/11/26',
            'responsabilidades' => 'Diseño y creación de materiales educativos, como cursos, lecciones, videos, y recursos de aprendizaje',
            'id_proyecto' => 2,
            'id_estado_actividad' => 1,
            'id_responsable' => 2,
        ]);

        Actividad::create([
            'nombre' => 'Implementación de Módulos Interactivos',
            'prioridad' => 1,
            'fecha_inicio' => '2023/11/12',
            'fecha_fin' => '2023/11/20',
            'responsabilidades' => 'Diseño y desarrollo de módulos interactivos para la plataforma',
            'id_proyecto' => 2,
            'id_estado_actividad' => 1,
            'id_responsable' => 2,
        ]);


        Actividad::create([
            'nombre' => 'Recopilación de Datos Económicos',
            'prioridad' => 1,
            'fecha_inicio' => '2023/09/10',
            'fecha_fin' => '2023/09/26',
            'responsabilidades' => 'Coordinar con departamentos y fuentes externas para recopilar datos económicos relevantes',
            'id_proyecto' => 3,
            'id_estado_actividad' => 1,
            'id_responsable' => 3,
        ]);

        Actividad::create([
            'nombre' => 'Desarrollo de la Base de Datos',
            'prioridad' => 1,
            'fecha_inicio' => '2023/09/12',
            'fecha_fin' => '2023/09/20',
            'responsabilidades' => 'Diseñar y crear la estructura de la base de datos que albergará los datos económicos recopilados',
            'id_proyecto' => 3,
            'id_estado_actividad' => 1,
            'id_responsable' => 3,
        ]);

        Actividad::create([
            'nombre' => 'Generación de Informes Económicos',
            'prioridad' => 1,
            'fecha_inicio' => '2023/11/10',
            'fecha_fin' => '2023/11/12',
            'responsabilidades' => 'Desarrollar scripts y procesos para generar informes económicos a partir de los datos almacenados en la base de datos',
            'id_proyecto' => 3,
            'id_estado_actividad' => 1,
            'id_responsable' => 3,
        ]);

        Actividad::create([
            'nombre' => 'Implementación de Herramientas de Visualización',
            'prioridad' => 1,
            'fecha_inicio' => '2023/11/2',
            'fecha_fin' => '2023/11/8',
            'responsabilidades' => 'Seleccionar y configurar herramientas de visualización de datos para presentar los informes económicos de manera efectiva',
            'id_proyecto' => 3,
            'id_estado_actividad' => 1,
            'id_responsable' => 3,
        ]);

        Actividad::create([
            'nombre' => 'Pruebas de Usabilidad del Portal',
            'prioridad' => 1,
            'fecha_inicio' => '2023/11/05',
            'fecha_fin' => '2023/11/15',
            'responsabilidades' => 'Realizar pruebas de usabilidad del portal de información económica para identificar y documentar cualquier problema de accesibilidad o experiencia del usuario',
            'id_proyecto' => 3,
            'id_estado_actividad' => 1,
            'id_responsable' => 3,
        ]);
    }
}
