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
            'name'=> 'William Enrique',
            'last_name'=> 'Vásquez Mancia',
            'email' => 'vm19003@ues.edu.sv',
            'password' => bcrypt('123'),
            'two_factor_enabled' => false,
        ]);

        $administrador->assignRole('Administrador');

        $usuario1 = User::create([
            'name'=> 'Ana María',
            'last_name'=> 'García Rodríguez',
            'email' => 'user@gmail.com',
            'password' => bcrypt('123'),
            'two_factor_enabled' => false,
        ]);

        $usuario1->assignRole('Colaborador');

        $usuario2 = User::create([
            'name'=> 'Jorge Eduardo',
            'last_name'=> 'Romero García',
            'email' => 'rg19041@ues.edu.sv',
            'password' => bcrypt('123'),
            'two_factor_enabled' => false,
        ]);

        $usuario2->assignRole('Colaborador');

        $usuario3 = User::create([
            'name'=> 'Christopher Javier',
            'last_name'=> 'Ayala Guerra',
            'email' => 'chrisgue081611@gmail.com',
            'password' => bcrypt('123'),
            'two_factor_enabled' => false,
        ]);

        $usuario3->assignRole('Colaborador');

        $usuario4 = User::create([
            'name'=> 'Juan Alejandro',
            'last_name'=> 'González Pérez',
            'email' => 'ayudante1@gmail.com',
            'password' => bcrypt('123'),
            'two_factor_enabled' => false,
        ]);

        $usuario4->assignRole('Colaborador');

        $usuario5 = User::create([
            'name'=> 'Laura Sofia',
            'last_name'=> 'Martínez Fernández',
            'email' => 'cliente@gmail.com',
            'password' => bcrypt('123'),
            'two_factor_enabled' => false,
        ]);

        $usuario5->assignRole('Cliente');

        $usuario6 = User::create([
            'name'=> 'Carolina Isabel',
            'last_name'=> 'Pineda Delgado',
            'email' => 'pd19007@ues.edu.sv',
            'password' => bcrypt('123'),
            'two_factor_enabled' => false,
        ]);

        $usuario6->assignRole('Supervisor');

        $usuario7 = User::create([
            'name'=> 'José Gustavo',
            'last_name'=> 'Pineda Delgado',
            'email' => 'pd18020@ues.edu.sv',
            'password' => bcrypt('123'),
            'two_factor_enabled' => false,
        ]);

        $usuario7->assignRole('Cliente');

        $usuario8 = User::create([
            'name'=> 'Christian Javier',
            'last_name'=> 'Ayala Guerra',
            'email' => 'ag19013@ues.edu.sv',
            'password' => bcrypt('123'),
            'two_factor_enabled' => false,
        ]);

        $usuario8->assignRole('Gerente');

    }
}
