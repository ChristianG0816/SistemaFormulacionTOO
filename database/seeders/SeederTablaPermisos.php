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

    }
}
