<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Productos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->String('Matricula')->unique();
            $table->string('name');
            $table->String('almacen');
            $table->String('tipo');
            $table->integer('cantidad');
            $table->string('Detalles');
            $table->String('permiso');
            $table->integer('disponible');
            
            $table->boolean('regresa_a_almacen');
            $table->string('modelo');
            $table->string('codigo');
            $table->string('noserie');

            $table->foreign('almacen')->references('Matricula')
                ->on('Almacenes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->rememberToken();
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
        Schema::dropIfExists('Productos');
    }
}
