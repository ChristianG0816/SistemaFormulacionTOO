<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre',250);
            $table->string('apellido',250);
            $table->string('rol', 100);
            $table->string('correo', 100);
            $table->string('telefono', 9)->nullable();
            $table->timestamps();
            $table->foreignId('id_cliente')->constrained('cliente')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacto');
    }
}
