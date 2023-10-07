<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManoObraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mano_obra', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->string('correo', 100);
            $table->string('dui', 9);
            $table->string('afp', 20);
            $table->string('isss', 20);
            $table->string('nacionalidad', 100);
            $table->string('pasaporte', 20);
            $table->string('telefono', 9);
            $table->string('profesion', 100);
            $table->string('estado_civil', 100);
            $table->string('sexo', 100);
            $table->date('fecha_nacimiento');
            $table->float('costo_servicio', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mano_obra'); // Elimina la tabla si existe
    }
}
