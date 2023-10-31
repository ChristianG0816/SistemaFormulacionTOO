<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('id_tipo_documento')->constrained('tipo_documento')->onDelete('restrict')->onUpdate('cascade');
            $table->string('nombre',255);
            $table->string('autor',255);
            $table->string('link',255);
            $table->date('fecha_creacion');
            $table->foreignId('id_proyecto')->constrained('proyecto')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('documento');
    }
}


