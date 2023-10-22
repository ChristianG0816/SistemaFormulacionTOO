<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTareaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarea', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 255); // varchar(100) not null
            $table->foreignId('id_actividad')->constrained('actividad')->onDelete('restrict')->onUpdate('cascade');
            $table->boolean('finalizada')->nullable(); // boolean not null
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
        Schema::dropIfExists('tarea'); // Elimina la tabla si existe
    }
}
