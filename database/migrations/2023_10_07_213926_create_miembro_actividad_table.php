<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiembroActividadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('miembro_actividad', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('id_actividad')->constrained('actividad')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('id_equipo_trabajo')->constrained('equipo_trabajo')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps(); // created_at, updated_at
            $table->unique(['id_actividad', 'id_equipo_trabajo']); // Para que no se repitan los registros
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('miembro_actividad'); // Elimina la tabla si existe
    }
}
