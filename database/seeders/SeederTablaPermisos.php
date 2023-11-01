<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

//spatie
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SeederTablaPermisos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = [
            Permission::create(['name' => 'ver-rol']),
            Permission::create(['name' => 'crear-rol']),
            Permission::create(['name' => 'editar-rol']),
            Permission::create(['name' => 'borrar-rol']),
        ];

        $miembros = [
            Permission::create(['name' => 'gestionar-miembro']),
            Permission::create(['name' => 'exportar-miembro']),
            Permission::create(['name' => 'ver-miembro']),
            Permission::create(['name' => 'crear-miembro']),
            Permission::create(['name' => 'editar-miembro']),
            Permission::create(['name' => 'borrar-miembro']),
        ];

        $actividades = [
            Permission::create(['name' => 'gestionar-actividad']),
            Permission::create(['name' => 'ver-actividad']),
            Permission::create(['name' => 'crear-actividad']),
            Permission::create(['name' => 'editar-actividad']),
            Permission::create(['name' => 'borrar-actividad']),
        ];

        $comentarios = [
            Permission::create(['name' => 'gestionar-comentario']),
            Permission::create(['name' => 'crear-comentario']),
            Permission::create(['name' => 'editar-comentario']),
            Permission::create(['name' => 'borrar-comentario']),
        ];

        $eventos = [
            Permission::create(['name' => 'crear-evento']),
            Permission::create(['name' => 'guardar-evento']),
            Permission::create(['name' => 'editar-evento']),
            Permission::create(['name' => 'borrar-evento']),
        ];

        $calendario = [
            Permission::create(['name' => 'ver-calendario']),
        ];
    

        $equipoTrabajo = [
            Permission::create(['name' => 'gestionar-equipo-trabajo']),
            Permission::create(['name' => 'crear-equipo-trabajo']),
            Permission::create(['name' => 'borrar-equipo-trabajo']),
        ];
      
        $roleAdministrador = Role::create(['name' => 'Administrador'])->givePermissionTo([
            //Roles referentes al administrador
            $roles
        ]);

        $roleCliente = Role::create(['name' => 'Cliente'])->givePermissionTo([
            //Roles referentes al cliente del proyecto
            $calendario
        ]);
        $roleSupervisor = Role::create(['name' => 'Supervisor'])->givePermissionTo([
            //Roles referentes al supervisor de proyecto
            $comentarios,
            $actividades,
            $eventos,
            $calendario
            $equipoTrabajo
        ]);

        $roleGerente = Role::create(['name' => 'Gerente'])->givePermissionTo([
            //Roles referentes al gerente de proyecto
            $miembros,
            $calendario
        ]);

        $roleColaborador = Role::create(['name' => 'Colaborador'])->givePermissionTo([
            //Roles referentes al colaborador de proyecto
            $comentarios,
            $actividades,
            $calendario

        ]);

    }
}
