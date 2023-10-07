<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComentarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentario', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('linea_comentario'); // text not null
            $table->foreignId('id_actividad')->constrained('actividad')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('id_usuario')->constrained('users')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('comentario'); // Elimina la tabla si existe
    }
}
