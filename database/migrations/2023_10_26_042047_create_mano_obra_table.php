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
            $table->float('costo_servicio', 8, 2);
            $table->foreignId('id_persona')->constrained('persona')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('id_usuario')->constrained('users')->onDelete('restrict')->onUpdate('cascade');
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