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
        $this -> call([EstadoProyectoSeeder::class]);
        $this -> call([EstadoActividadSeeder::class]);
        $this -> call([SeederDatosPrueba::class]);
    }
}
