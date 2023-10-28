<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividad', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 255); // varchar(100) not null
            $table->foreignId('id_paquete_actividades')->constrained('actividad')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('id_estado_actividad')->constrained('estado_actividad')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actividad'); // Elimina la tabla si existe
    }
}
