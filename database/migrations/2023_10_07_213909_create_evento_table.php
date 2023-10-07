<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evento', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 100); // varchar(100) not null
            $table->string('descripcion', 255); // varchar(250) not null
            $table->string('direccion', 255); // varchar(250) not null
            $table->date('fecha_inicio'); // date not null
            $table->date('fecha_fin'); // date not null
            $table->time('hora_inicio'); // time not null
            $table->time('hora_fin'); // time not null
            $table->timestamp('fecha_recordatorio'); // timestamp not null
            $table->string('link_reunion', 255); // varchar(250) not null
            $table->foreignId('id_proyecto')->constrained('proyecto')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('evento'); // Elimina la tabla si existe
    }
}
