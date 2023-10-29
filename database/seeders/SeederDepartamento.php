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
			['id_pais'=>'65','nombre' => 'Ahuachapán'],
			['id_pais'=>'65','nombre' => 'Cabañas'],
			['id_pais'=>'65','nombre' => 'Chalatenango'],
			['id_pais'=>'65','nombre' => 'Cuscatlán'],
			['id_pais'=>'65','nombre' => 'La Libertad'],
			['id_pais'=>'65','nombre' => 'La Paz'],
			['id_pais'=>'65','nombre' => 'La Unión'],
			['id_pais'=>'65','nombre' => 'Morazán'],
			['id_pais'=>'65','nombre' => 'San Miguel'],
			['id_pais'=>'65','nombre' => 'San Salvador'],
			['id_pais'=>'65','nombre' => 'San Vicente'],
			['id_pais'=>'65','nombre' => 'Santa Ana'],
			['id_pais'=>'65','nombre' => 'Sonsonate'],
			['id_pais'=>'65','nombre' => 'Usulután'],
			['id_pais'=>'90','nombre' => 'Alta Verapaz'],
			['id_pais'=>'90','nombre' => 'Baja Verapaz'],
			['id_pais'=>'90','nombre' => 'Chimaltenango']
		];
		foreach ($departamentos as $departamento) {
            Departamento::create($departamento);
        }
	}
}