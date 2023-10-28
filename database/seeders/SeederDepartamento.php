<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departamento;
use Illuminate\Support\Facades\DB;

class SeederDepartamento extends Seeder {
	
	public function run() 
	{
        /**
         * Run the database seeds.
         *
         * @return void
         */
        //eliminar datos
        Departamento::truncate();
        DB::statement('ALTER SEQUENCE departamento_id_seq RESTART WITH 1');
		$departamentos = [
			['nombre' => 'Ahuachapán'],
			['nombre' => 'Cabañas'],
			['nombre' => 'Chalatenango'],
			['nombre' => 'Cuscatlán'],
			['nombre' => 'La Libertad'],
			['nombre' => 'La Paz'],
			['nombre' => 'La Unión'],
			['nombre' => 'Morazán'],
			['nombre' => 'San Miguel'],
			['nombre' => 'San Salvador'],
			['nombre' => 'San Vicente'],
			['nombre' => 'Santa Ana'],
			['nombre' => 'Sonsonate'],
			['nombre' => 'Usulután']
		];
		foreach ($departamentos as $departamento) {
            Departamento::create($departamento);
        }
	}
}