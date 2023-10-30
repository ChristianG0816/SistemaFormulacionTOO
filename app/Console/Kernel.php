<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\VerificarFechasRecordatorio; // Asegúrate de importar la clase de tu tarea programada aquí.

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('verificar:fechas-recordatorio') // Nombre del comando definido en tu tarea programada.
                 //->daily(); // Ejecutar la tarea diariamente, puedes ajustar la frecuencia según tus necesidades.
                 ->everyFiveMinutes(); //Ejecutar la tarea cada 5 minutos.
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

