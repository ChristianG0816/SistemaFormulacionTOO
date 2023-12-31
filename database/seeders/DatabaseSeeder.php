<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this -> call([SeederTablaPermisos::class]);
        $this -> call([SeederTablaUsuarios::class]);
        $this -> call([SeederTablaEstadoProyecto::class]);
        $this -> call([SeederTablaTipoDocumento::class]);
        $this -> call([SeederTablaEstadoActividad::class]);
        $this -> call([SeederPaises::class]);
        $this -> call([SeederDepartamento::class]);
        $this -> call([SeederMunicipio::class]);
        $this -> call([SeederDatosPrueba::class]);
        $this -> call([TipoNotificacionSeeder::class]);
        $this -> call([SeederTablaRecurso::class]);
    }
}
