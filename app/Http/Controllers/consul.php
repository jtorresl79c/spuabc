<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class consul extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $productos = DB::table('producto_pedidos')
        ->join('productos','producto_pedidos.Productos_id','=','productos.id')
        ->where('id_pedido','=',$request->id)
        ->select(
            'productos.Matricula',
            'productos.name',
            'productos.almacen',
            'producto_pedidos.cantidad'
        )
        ->get();
        return response()->json(['result' => $productos]);
    }
}


