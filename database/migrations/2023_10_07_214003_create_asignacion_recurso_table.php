<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignacionRecursoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignacion_recurso', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('id_actividad')->constrained('actividad')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('id_recurso')->constrained('recurso')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('cantidad'); // int not null
            $table->timestamps(); // created_at, updated_at
            $table->unique(['id_actividad', 'id_recurso']); // Para que no se repitan los registros
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asignacion_recurso'); // Elimina la tabla si existe
    }
}
