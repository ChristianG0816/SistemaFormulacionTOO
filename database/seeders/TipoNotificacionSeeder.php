<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoNotificacion;
use Illuminate\Support\Facades\DB;

class TipoNotificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //eliminar datos
        TipoNotificacion::truncate();
        DB::statement('ALTER SEQUENCE tipo_notificacion_id_seq RESTART WITH 1');
        $tiposNotificacion = [
            [
                'nombre' => 'Creación de proyecto.',
                'descripcion' => 'Se ha creado el proyecto "{{nombre}}".',
                'icono' => 'fas fa-fw fa-file',
                'color' => '#FF5733',
                'ruta' => '/proyectos/{{id}}',
            ],
            [
                'nombre' => 'Aprobación de proyecto.',
                'descripcion' => 'Se ha aprobado el proyecto "{{nombre}}".',
                'icono' => 'fas fa-fw fa-check-circle',
                'color' => '#55AA33',
                'ruta' => '/proyectos/{{id}}',
            ],
            [
                'nombre' => 'Rechazo de proyecto.',
                'descripcion' => 'Se ha rechazado el proyecto "{{nombre}}".',
                'icono' => 'fas fa-fw fa-times-circle',
                'color' => '#FF3333',
                'ruta' => '/proyectos/{{id}}',
            ],
            [
                'nombre' => 'Asignación en proyecto.',
                'descripcion' => 'Se ha asignado en el proyecto "{{nombre}}".',
                'icono' => 'fas fa-fw fa-user',
                'color' => '#3366FF',
                'ruta' => '/proyectos/{{id}}',
            ],
            [
                'nombre' => 'Recordatorio de actividad',
                'descripcion' => 'Recordatorio de actividad "{{nombre}}" en proyecto "{{nombre_proyecto}}".',
                'icono' => 'fas fa-fw fa-bell',
                'color' => '#FF9933',
                'ruta' => '/actividades/show/{id}',
            ],
            [
                'nombre' => 'Finalización de actividad.',
                'descripcion' => 'Finalización de actividad "{{nombre}}" en proyecto "{{nombre_proyecto}}".',
                'icono' => 'fas fa-fw fa-check',
                'color' => '#33CC33',
                'ruta' => '/actividades/show/{id}',
            ],
            [
                'nombre' => 'Finalización de proyecto.',
                'descripcion' => 'Finalización de proyecto "{{nombre}}".',
                'icono' => 'fas fa-fw fa-tasks',
                'color' => '#3366CC',
                'ruta' => '/proyectos/{{id}}',
            ],
            [
                'nombre' => 'Invitación a evento.',
                'descripcion' => 'Te han invitado al evento "{{nombre}}".',
                'icono' => 'fas fa-fw fa-calendar',
                'color' => '#FF33CC',
                'ruta' => '/eventos/{{id}}',
            ],
        ];

        foreach ($tiposNotificacion as $tipo) {
            TipoNotificacion::create($tipo);
        }
    }
}
