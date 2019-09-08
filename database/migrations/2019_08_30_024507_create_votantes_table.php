<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votantes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('documento',30)->unique()->index(); //cedula del votante
            $table->string('nombre',300); 
            $table->string('telefono',300); 
            $table->string('direccion',300); 
            $table->boolean('lider')->default(false);
            $table->boolean('publicidad')->default(false);
            $table->integer('idlider')->unsigned()->nullable();
            $table->integer('barrio_id')->unsigned()->index();
            $table->foreign('barrio_id')->references('id')->on('barrios')->onDelete('cascade');
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
        Schema::dropIfExists('votantes');
    }
}
