<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoNotificacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_notificacion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 100); // varchar(100) not null
            $table->string('descripcion', 250); // varchar(250) not null
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
        Schema::dropIfExists('tipo_notificacion'); // Elimina la tabla si existe
    }
}
