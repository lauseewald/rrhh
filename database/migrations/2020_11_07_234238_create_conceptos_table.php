<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conceptos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            //se suma o resta
            $table->boolean('remunerativo');
            //si es un valor que se mantiene en el tiempo o si es calculable
            $table->boolean('fijo');
            //un valor base que se calcula por ejemplo 0.30 haciendo referencia a porcentaje
            $table->float('base');
            //unidad por ejemplo si es 1 se refiere a porcentaje
            //si es 2 significa que se divide
            //¿QUe significa la unidad? (no me acuerdo bien) 
            $table->integer('unidad');

            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas');

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
        Schema::dropIfExists('conceptos');
    }
}
