<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoNotificacion;

class TipoNotificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tiposNotificacion = [
            [
                'nombre' => 'Creación de un proyecto',
                'descripcion' => 'Notificación de creación de un nuevo proyecto.',
                'icono' => 'fas fa-fw fa-file',
                'color' => '#FF5733',
                'ruta' => '/proyectos/crear',
            ],
            [
                'nombre' => 'Aprobación de un proyecto',
                'descripcion' => 'Notificación de aprobación de un proyecto.',
                'icono' => 'fas fa-fw fa-check-circle',
                'color' => '#55AA33',
                'ruta' => '/proyectos/aprobar',
            ],
            [
                'nombre' => 'Rechazo de un proyecto',
                'descripcion' => 'Notificación de rechazo de un proyecto.',
                'icono' => 'fas fa-fw fa-times-circle',
                'color' => '#FF3333',
                'ruta' => '/proyectos/rechazar',
            ],
            [
                'nombre' => 'Asignación en un proyecto',
                'descripcion' => 'Notificación de asignación en un proyecto.',
                'icono' => 'fas fa-fw fa-user',
                'color' => '#3366FF',
                'ruta' => '/proyectos/asignar',
            ],
            [
                'nombre' => 'Recordatorio de actividad',
                'descripcion' => 'Notificación de recordatorio de actividad.',
                'icono' => 'fas fa-fw fa-bell',
                'color' => '#FF9933',
                'ruta' => '/actividades/recordar',
            ],
            [
                'nombre' => 'Finalización de actividad',
                'descripcion' => 'Notificación de finalización de una actividad.',
                'icono' => 'fas fa-fw fa-check',
                'color' => '#33CC33',
                'ruta' => '/actividades/finalizar',
            ],
            [
                'nombre' => 'Finalización de todas las actividades de un proyecto',
                'descripcion' => 'Notificación de finalización de todas las actividades de un proyecto.',
                'icono' => 'fas fa-fw fa-tasks',
                'color' => '#3366CC',
                'ruta' => '/proyectos/finalizar',
            ],
            [
                'nombre' => 'Invitación a evento',
                'descripcion' => 'Notificación de invitación a un evento.',
                'icono' => 'fas fa-fw fa-calendar',
                'color' => '#FF33CC',
                'ruta' => '/eventos/invitar',
            ],
        ];

        foreach ($tiposNotificacion as $tipo) {
            TipoNotificacion::create($tipo);
        }
    }
}
