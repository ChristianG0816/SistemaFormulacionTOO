<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class SeederTablaUsuarios extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $administrador = User::create([
            'name'=> 'admin',
            'last_name'=> 'apellido',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $administrador->assignRole('Administrador');

        $usuario = User::create([
            'name'=> 'nombre',
            'last_name'=> 'apellido',
            'email' => 'user@gmail.com',
            'password' => bcrypt('123')
        ]);
    }
}
