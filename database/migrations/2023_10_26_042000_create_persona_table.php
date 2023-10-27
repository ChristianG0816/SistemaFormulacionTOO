<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo_documento', 50);
            $table->string('numero_documento', 20);
            $table->foreignId('id_pais')->constrained('pais')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('id_departamento')->nullable()->constrained('departamento')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('id_municipio')->nullable()->constrained('municipio')->onDelete('restrict')->onUpdate('cascade');
            $table->string('telefono', 9);
            $table->string('profesion', 100);
            $table->string('estado_civil', 100);
            $table->string('sexo', 100);
            $table->date('fecha_nacimiento');
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
        Schema::dropIfExists('persona');
    }
}
