<?php

namespace App\Http\Controllers;

use App\Pedidos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class act extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        date_default_timezone_set('America/Tijuana');
        $fecha = date("Y-m-j");
        $hora = date("G");
echo($hora);
        $datos = DB::table('pedidos')->where([
            ['Fecha','<',$fecha],
            ['Estado','!=','Entregado'],
            ['Estado','!=','Rechazado'],
            
            ])
            ->orWhere([
                ['Fecha','=',$fecha],
                ['Final','<=',$hora],
                ['Estado','!=','Entregado'],
                ['Estado','!=','Rechazado'],
            ])
            ->select('id')
            ->get();

        foreach($datos as $id){
            DB::table('pedidos')
                ->where('id',$id->id)
                ->update(['Estado' => 'Atrasado']);
        }

        return redirect('Ped/Pedido');
    }
}
