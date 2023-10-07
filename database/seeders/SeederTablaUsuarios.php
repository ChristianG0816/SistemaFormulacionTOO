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
        $usuario = User::create([
            'name'=> 'user',
            'email' => 'user@gmail.com',
            'password' => bcrypt('123')
        ]);
    }
}
