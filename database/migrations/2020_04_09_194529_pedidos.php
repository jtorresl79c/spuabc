<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pedidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Pedidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('Solicitante');
                $table->foreign('Solicitante')->references('id')
                    ->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->string('Almacen');
                $table->foreign('almacen')->references('Matricula')
                    ->on('Almacenes')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->date('Fecha');
            $table->Integer('Inicial');
            $table->Integer('Final');
            $table->String('Estado')->default('Pendiente');
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
        Schema::dropIfExists('Pedidos');
    }
}
