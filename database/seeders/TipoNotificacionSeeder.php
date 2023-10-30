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
                'descripcion' => 'Recordatorio de actividad pendiente "{{nombre}}" en proyecto "{{nombre_proyecto}}".',
                'icono' => 'fas fa-fw fa-bell',
                'color' => '#FF9933',
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
                'ruta' => '/calendario',
            ],
            [
                'nombre' => 'Actividad pendiente',
                'descripcion' => 'Se ha agregado la actividad "{{nombre}}" en el proyecto "{{nombre_proyecto}}", se encuentra pendiente de realizar.',
                'icono' => 'fas fa-fw fa-clipboard-list',
                'color' => '#1F618D',
                'ruta' => '/actividades/show/{{id}}',
            ],
            [
                'nombre' => 'Actividad en proceso',
                'descripcion' => 'La actividad "{{nombre}}" del proyecto "{{nombre_proyecto}}", se encuentra en proceso de realización.',
                'icono' => 'fas fa-fw fa-clipboard-list',
                'color' => '#1F618D',
                'ruta' => '/actividades/show/{{id}}',
            ],
            [
                'nombre' => 'Actividad finalizada',
                'descripcion' => 'La actividad "{{nombre}}" del proyecto "{{nombre_proyecto}}", se encuentra finalizada.',
                'icono' => 'fas fa-fw fa-clipboard-list',
                'color' => '#1F618D',
                'ruta' => '/actividades/show/{{id}}',
            ],
            [
                'nombre' => 'Comentario agregado',
                'descripcion' => 'El usuario {{usuario}} ha agregado un comentario a la actividad "{{nombre}}" del proyecto "{{nombre_proyecto}}".',
                'icono' => 'fas fa-fw fa-comments',
                'color' => '#D6EAF8',
                'ruta' => '/actividades/show/{{id}}',
            ],
            [
                'nombre' => 'Tarea iniciada',
                'descripcion' => 'Se ha iniciado la tarea {{nombre_tarea}} de la actividad "{{nombre}}" del proyecto "{{nombre_proyecto}}".',
                'icono' => 'fas fa-fw fa-file-signature',
                'color' => '#0B5345',
                'ruta' => '/actividades/show/{{id}}',
            ],
            [
                'nombre' => 'Tarea finalizada',
                'descripcion' => 'La tarea {{nombre_tarea}} de la actividad "{{nombre}}" del proyecto "{{nombre_proyecto}}", se encuentra finalizada.',
                'icono' => 'fas fa-fw fa-file-signature',
                'color' => '#0B5345',
                'ruta' => '/actividades/show/{{id}}',
            ],
        ];

        foreach ($tiposNotificacion as $tipo) {
            TipoNotificacion::create($tipo);
        }
    }
}
