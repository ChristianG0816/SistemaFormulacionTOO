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

        $roleAdministrador = Role::create(['name' => 'Administrador'])->givePermissionTo([
            //Roles referentes al administrador
            $roles
        ]);
        $roleCliente = Role::create(['name' => 'Cliente'])->givePermissionTo([
            //Roles referentes al cliente del proyecto
            $roles
        ]);
        $roleSupervisor = Role::create(['name' => 'Supervisor'])->givePermissionTo([
            //Roles referentes al supervisor de proyecto
            $roles
        ]);
        $roleGerente = Role::create(['name' => 'Gerente'])->givePermissionTo([
            //Roles referentes al gerente de proyecto
            $roles
        ]);
        $roleColaborador = Role::create(['name' => 'Colaborador'])->givePermissionTo([
            //Roles referentes al colaborador de proyecto
            $roles
        ]);

    }
}
