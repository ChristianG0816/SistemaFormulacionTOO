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
            'password' => bcrypt('12345678'),
            'two_factor_enabled' => false,
        ]);

        $administrador->assignRole('Administrador');

        $usuario1 = User::create([
            'name'=> 'nombre',
            'last_name'=> 'apellido',
            'email' => 'user@gmail.com',
            'password' => bcrypt('123'),
            'two_factor_enabled' => false,
        ]);

        $usuario1->assignRole('Colaborador');

        $usuario2 = User::create([
            'name'=> 'Ingeniero',
            'last_name'=> 'apellido',
            'email' => 'ingeniero@gmail.com',
            'password' => bcrypt('123'),
            'two_factor_enabled' => false,
        ]);

        $usuario2->assignRole('Colaborador');

        $usuario3 = User::create([
            'name'=> 'Tester',
            'last_name'=> 'apellido',
            'email' => 'tester@gmail.com',
            'password' => bcrypt('123'),
            'two_factor_enabled' => false,
        ]);

        $usuario3->assignRole('Colaborador');

        $usuario4 = User::create([
            'name'=> 'Ayudante1',
            'last_name'=> 'apellido',
            'email' => 'ayudante1@gmail.com',
            'password' => bcrypt('123'),
            'two_factor_enabled' => false,
        ]);

        $usuario4->assignRole('Colaborador');


    }
}
