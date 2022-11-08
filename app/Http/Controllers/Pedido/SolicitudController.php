<?php

namespace App\Http\Controllers\Pedido;

use App\Http\Controllers\Controller;
use App\Pedidos;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Gate;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return auth()->user();

        // $almacen = auth()->user()->almacen;
        // $pedidos = Pedidos::whereHas('almacen',function ($query) use ($almacen){
        //     $query->where('Matricula','almacen');
        // })->get();

        
        
        $usuario = auth()->user()->id;

        // $data = Pedidos::whereHas('usuario',function ($query) use ($usuario){
        //     $query->where('Solicitante',$usuario);
        // })->get();

        // return $data;


        if(Gate::denies('AccesoAlmacenista')){ // Parece que este funciona como else, si el usuario que esta intentando acceder no es ni Almacenitas ni Administrador, entonces este se ejecutara, es mas creo que este esta mal, este deberia ir simplemente en un else
            
            // Filtrar los Pedidos por Usuario y no por almacen

            // $data = Pedidos::join('users','users.id','=','pedidos.Solicitante')
            //     ->where('Solicitante',$usuario)
            //     ->select(
            //         'pedidos.id',
            //         DB::raw("CONCAT(users.name,', ',users.apellidoP,', ',users.apellidoM) AS Solicitante"),
            //         'Almacen',
            //         'Fecha',
            //         'Inicial',
            //         'Final',
            //         'Estado'
            //     )
            //     ->get();

            $data = Pedidos::whereHas('usuario',function ($query) use ($usuario){
                $query->where('Solicitante',$usuario);
            })->get();
    
            // return $data;




        }
        else if(Gate::allows('AccesoAdmin'))
        {
            $data = Pedidos::join('users','users.id','=','pedidos.Solicitante')
                ->select(
                    'pedidos.id',
                    DB::raw("CONCAT(users.name,', ',users.apellidoP,', ',users.apellidoM) AS Solicitante"),
                    'pedidos.Almacen',
                    'Fecha',
                    'Inicial',
                    'Final',
                    'Estado'

                )
                ->get();
            // $data = Pedidos::all();
        }
        else if(Gate::allows('AccesoAlmacenista'))
        {
            {
                // $data = Pedidos::join('users','users.id','=','pedidos.Solicitante')
                //     ->where('pedidos.Almacen','users.almacen')
                //     ->select(
                //         'pedidos.id',
                //         DB::raw("CONCAT(users.name,', ',users.apellidoP,', ',users.apellidoM) AS Solicitante"),
                //         'pedidos.Almacen',
                //         'Fecha',
                //         'Inicial',
                //         'Final',
                //         'Estado'
    
                //     )
                //     ->get();
                $almacen = auth()->user()->almacen;
                $data = Pedidos::whereHas('almacen',function ($query) use ($almacen){
                    $query->where('Matricula',$almacen);
                })->get();
            }
        }


        if($request->ajax())
        {
                // return $responese->json('Stories', 201);


                return DataTables::of($data)
                    ->addColumn('action', function ($data) {
                        $button = '&nbsp;&nbsp;&nbsp;<button type="button" name="productos" id="'.$data->id.'" class="producto btn btn-success btn-sm">Detalles</button>';
                        if(Gate::allows('AccesoAlmacenista')){
                            $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-warning btn-sm">Estado</button>';
                        }
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);


                
                // Mio

                // $pedidos = Pedidos::all();
                // return Datatables::of($pedidos)->make();

                // return Datatables::of($pedidos)->addColumn('action', function ($data) {
                //     $button = '&nbsp;&nbsp;&nbsp;<button type="button" name="productos" id="'.$data->id.'" class="producto btn btn-success btn-sm">Detalles</button>';
                //     if(Gate::allows('AccesoAlmacenista')){
                //         $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-warning btn-sm">Estado</button>';
                //         }
                //     return $button;
                // })
                // ->rawColumns(['action'])
                // ->make(true);
            

        }
        return view('Ped.Pedido.index');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pedidos $pedidos)
    { if(request()->ajax())
    {
        $data = Pedidos::findOrFail($pedidos);
        return response()->json(['result' => $data]);
    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $form_data = [
            'Estado'    =>  $request->Estado,
        ];

        Pedidos::whereId($request->hidden_id)->update($form_data);


        return response()->json(['success' => 'El registro se ha modificado exitosamente']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
