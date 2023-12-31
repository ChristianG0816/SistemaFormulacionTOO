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
            $table->integer('prioridad'); // int not null
            $table->date('fecha_inicio'); // date not null
            $table->date('fecha_fin'); // date not null
            $table->date('fecha_fin_real')->nullable();
            $table->text('responsabilidades'); // text not null
            $table->foreignId('id_proyecto')->constrained('proyecto')->onDelete('restrict')->onUpdate('cascade');
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
