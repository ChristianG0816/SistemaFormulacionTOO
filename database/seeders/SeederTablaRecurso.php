<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recurso;

class SeederTablaRecurso extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $recursos = [
            [
                'nombre' => 'Laptop Dell XPS 15',
                'disponibilidad' => 10,
                'costo' => 1500.00,
            ],
            [
                'nombre' => 'Proyector Epson PowerLite',
                'disponibilidad' => 5,
                'costo' => 800.00,
            ],
            [
                'nombre' => 'Impresora HP LaserJet Pro',
                'disponibilidad' => 8,
                'costo' => 400.00,
            ],
            [
                'nombre' => 'Monitor LG UltraWide 34"',
                'disponibilidad' => 6,
                'costo' => 600.00,
            ],
            [
                'nombre' => 'Servidor HP ProLiant DL380',
                'disponibilidad' => 2,
                'costo' => 2500.00,
            ],
        ];

        foreach ($recursos as $recurso) {
            Recurso::create($recurso);
        }
    }
}
