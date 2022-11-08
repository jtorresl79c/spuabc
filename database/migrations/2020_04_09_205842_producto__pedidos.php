<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductoPedidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Producto_Pedidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_pedido');
            $table->foreign('id_pedido')->references('id')
                ->on('pedidos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('Productos_id');
            $table->foreign('Productos_id')->references('id')
                ->on('productos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('cantidad');
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
        Schema::dropIfExists('Producto_Pedido');
    }
}
