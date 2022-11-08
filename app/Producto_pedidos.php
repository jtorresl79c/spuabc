<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto_pedidos extends Model
{
    protected $table = 'producto_pedidos';
    protected $fillable = [
        'id_pedido','Productos_id','cantidad'
    ];
}
