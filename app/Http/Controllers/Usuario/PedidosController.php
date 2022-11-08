<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Pedidos;
use App\User;
use App\Producto_pedidos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use DataTables;
use App\Productos;
use Illuminate\Support\Facades\DB;

class PedidosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $busqueda = unserialize(Cookie::Get('consulta'));
        $noid = DB::table('pedidos')
            ->where([
                ['Almacen', '=', $busqueda[0]],
                ['Fecha', '=', $busqueda[1]],
                ['Inicial', '>', $busqueda[2]],
                ['Final', '<', $busqueda[3]],
                ['Estado', '!=', 'Entregado'],
            ])
            ->orwhere([
                ['Almacen', '=', $busqueda[0]],
                ['Fecha', '=', $busqueda[1]],
                ['Inicial', '<', $busqueda[2]],
                ['Final', '>', $busqueda[3]],
                ['Estado', '!=', 'Entregado']
            ])
            ->orwhere([
                ['Almacen', '=', $busqueda[0]],
                ['Fecha', '=', $busqueda[1]],
                ['Inicial', '=', $busqueda[2]],
                ['Final', '=', $busqueda[3]],
                ['Estado', '!=', 'Entregado']
            ])
            ->orwhere([
                ['Almacen', '=', $busqueda[0]],
                ['Fecha', '=', $busqueda[1]],
                ['Inicial', '<', $busqueda[2]],
                ['Final', '>', $busqueda[2]],
                ['Estado', '!=', 'Entregado']
            ])
            ->orwhere([
                ['Almacen', '=', $busqueda[0]],
                ['Fecha', '=', $busqueda[1]],
                ['Inicial', '<', $busqueda[3]],
                ['Final', '>', $busqueda[3]],
                ['Estado', '!=', 'Entregado']
            ])
            ->select('id')
            ->distinct()
            ->get();
        $noid = (json_decode(json_encode($noid), true));
        $nopid = DB::table('producto_pedidos')->whereIn('id_pedido', array_values($noid))
            ->select('Productos_id')
            ->distinct()
            ->get();
        $nopid = (json_decode(json_encode($nopid), true));
        if (auth()->user()->role == 'Usuario') {
            $rol = true;
        } else {
            $rol = false;
        }


        if ($request->ajax()) {
            $data = DB::table('productos')
                ->where('almacen', '=', $busqueda[0])
                ->when($rol, function ($query, $rol) {
                    return $query->where('permiso', '=', 'MA');
                })
                ->whereNotIn('id', array_values($nopid));
            return DataTables::of($data)
                ->addColumn('checkbox', '<input type="checkbox" name="Producto[]" class="Producto" value="{{$id}}" />')
                ->rawColumns(['checkbox', 'action'])
                ->make(true);
        }
        return view('Us.Usuario.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->cant;
        $busqueda = unserialize(Cookie::Get('consulta'));
        $usuario = auth()->user()->id;
        $form_data = array(
            'Solicitante' => $usuario,
            'Almacen' => $busqueda[0],
            'Fecha' => $busqueda[1],
            'Inicial' => $busqueda[2],
            'Final' => $busqueda[3]
        );

        $pedido = Pedidos::create($form_data);
        $data = json_decode($request->getContent());

        // $request->id = Es un array con los IDs de los productos seleccionados en 'Solicitar productos para prestamo'
        for ($x = 0; $x < count($request->id); $x++) { 
            $producto_id = $request->id[$x];
            $cantidadPedida = $request->cant[$x];

            Producto_pedidos::create([
                'id_pedido' => $pedido->id,
                'Productos_id' => $producto_id,
                'cantidad' => $cantidadPedida
            ]);

            $producto = Productos::find($producto_id);


            $producto->disponible = $producto->cantidad - $cantidadPedida;
            $producto->save();

            if($producto->tipo == 'Consumible' && $producto->regresa_a_almacen == 0){
                $producto->cantidad = $producto->cantidad - $cantidadPedida;
                $producto->save();
            }
        }

        return response()->json(['success' => 'Se agrego el registro exitosamente.']);
    }

    // Original
    // public function store(Request $request)
    // {
    //     $busqueda = unserialize(Cookie::Get('consulta'));
    //     $usuario = auth()->user()->id;
    //     $form_data = array(
    //         'Solicitante' => $usuario,
    //         'Almacen' => $busqueda[0],
    //         'Fecha' => $busqueda[1],
    //         'Inicial' => $busqueda[2],
    //         'Final' => $busqueda[3]
    //     );

    //     $newdata = Pedidos::create($form_data);
    //     $data = json_decode($request->getContent());
    //     $x = 0;
    //     foreach ($request->id as $id) {
    //         Producto_pedidos::create([
    //             'id_pedido' => $newdata->id,
    //             'Productos_id' => $id,
    //             'cantidad' => $request->cant[$x++]
    //         ]);
    //         $uso = 0;
    //         $uso = DB::table('producto_pedidos')
    //             ->where('Productos_id', $id)
    //             ->sum('cantidad');
    //         $cantidad = DB::table('productos')
    //             ->where('id', $id)
    //             ->value('cantidad');

    //         DB::table('productos')
    //             ->where('id', $id)
    //             ->update(['disponible' => (int)$cantidad - $uso]);

    //         DB::table('productos')
    //             ->where([
    //                 ['tipo', '=', 'Consumible'],
    //                 ['id', '=', $id],
    //             ])
    //             ->update(['cantidad' => (int)$cantidad - $uso]);
    //     }



    //     return response()->json(['success' => 'Se agrego el registro exitosamente.']);
    // }












    /**
     * Display the specified resource.
     *
     * @param \App\Pedidos $pedidos
     * @return \Illuminate\Http\Response
     */
    public function show(Pedidos $pedidos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Pedidos $pedidos
     * @return \Illuminate\Http\Response
     */
    public function edit(Pedidos $pedidos)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Pedidos $pedidos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pedidos $pedidos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Pedidos $pedidos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pedidos $pedidos)
    {
        //
    }
}
