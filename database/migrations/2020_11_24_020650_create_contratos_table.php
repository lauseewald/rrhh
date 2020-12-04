<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('descripcion');
            $table->date('inicioLaboral');
            $table->date('finLaboral');
            //maxima
            $table->integer('cantidadHorasDiarias');
            $table->string('contrato');
            $table->float('salario');

            $table->unsignedinteger('puesto_id')->nullable();
            $table->foreign('puesto_id')->references('id')->on('puestos');
            //el modelo contrato tiene que tener un metodo que devuelva el puesto del empleado
            $table->unsignedinteger('empleado_id')->nullable();
            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->boolean('condicion')->default(1);
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
        Schema::dropIfExists('contratos');
    }
}
