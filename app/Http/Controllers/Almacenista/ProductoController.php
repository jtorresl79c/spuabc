<?php

namespace App\Http\Controllers\Almacenista;

use App\Almacenes;
use App\Http\Controllers\Controller;
use App\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { {

            if ($request->ajax()) {
                if (auth()->user()->role == 'Almacenista') {
                    // $data = DB::table('productos')->where('almacen', '=', auth()->user()->almacen)->orderByDesc('id');
                    $data = DB::table('productos')->where('almacen', '=', auth()->user()->almacen);
                    return DataTables::of($data)
                        ->addColumn('action', function ($data) {
                            $button = '<button type="button" align="center" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Editar</button>';
                            $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="' . $data->id . '" class="delete btn btn-danger btn-sm">Eliminar</button>';
                            return $button;
                        })
                        ->rawColumns(['action'])
                        ->make(true);
                } else {
                    $data = Productos::orderByDesc('id')->get(); // Esto queda invalidado, porque el datatablejs reescribe el orden
                    return DataTables::of($data)
                        ->addColumn('action', function ($data) {
                            $button = '<button type="button" align="center" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Editar</button>';
                            $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="' . $data->id . '" class="delete btn btn-danger btn-sm">Eliminar</button>';
                            return $button;
                        })
                        ->rawColumns(['action'])
                        ->make(true);
                }
            }
            $Alm = Almacenes::all();
            return view('Al.productos.index')->with('Alm', $Alm);
        }
    }


    public function store(Request $request)
    {
        // return 'hola mundo';
        // return response()->json(['name' => $request->modelo, 'state' => 'CA']);
        if (auth()->user()->role == 'Almacenista') {
            $almacen = auth()->user()->almacen;
        } else {
            $almacen = $request->almacen;
        }

        $rules = array(
            'Nombre'    =>  'required|max:50|min:3',
            'Matricula'     =>  'required|unique:productos|max:10|min:3',
            'almacen' => 'exclude_unless:Nivel,Administrador|required|Exists:almacenes,Matricula',
            'tipo' => 'required',
            'permiso' => 'required',
            'cantidad'     =>  'required|numeric|min:1',
        );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        // if ($request->CU == 'mult') {
        //     for ($x = 0; $x < $request->cantidad; $x++) {
        //         DB::table('productos')->insert([
        //             [
        //                 'name'        =>  $request->Nombre,
        //                 'Matricula'         =>  $request->Matricula . "Pt_" . ($x + 1),
        //                 'almacen' => $almacen,
        //                 'tipo'     =>  $request->tipo,
        //                 'permiso'     =>  $request->permiso,
        //                 'cantidad'     =>  1,
        //                 'disponible'     =>  1,
        //                 'Detalles'     =>  $request->detalles
        //             ]

        //         ]);
        //         DB::table('almacenes')->where('Matricula', '=', $request->almacen)->increment('productos');
        //     }
        // } 
        else {
            DB::table('productos')->insert([
                [
                    'name'        =>  $request->Nombre,
                    'Matricula'         =>  $request->Matricula,
                    'almacen' => $almacen,
                    'tipo'     =>  $request->tipo,
                    'permiso'     =>  $request->permiso,
                    'cantidad'     =>  $request->cantidad,
                    'disponible'     =>  $request->cantidad,
                    'Detalles'     =>  $request->detalles,
                    'regresa_a_almacen' => $request->optionsConsumibles,
                    'modelo' => $request->modelo,
                    'codigo' => $request->codigouabc,
                    'noserie'=> $request->noserie,
                ]

            ]);
            DB::table('almacenes')->where('Matricula', '=', $request->almacen)->increment('productos');
        }


        return response()->json(['success' => 'Se agrego el registro exitosamente.']);
    }


    public function edit($id)
    {

        if (request()->ajax()) {
            $data = productos::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }


    public function update(Request $request)
    {
        if (auth()->user()->role == 'Almacenista') {
            $almacen = auth()->user()->almacen;
        } else {
            $almacen = $request->almacen;
        }

        // 'name'        =>  $request->Nombre,
        // 'Matricula'         =>  $request->Matricula,
        // 'almacen' => $almacen,
        // 'tipo'     =>  $request->tipo,
        // 'permiso'     =>  $request->permiso,
        // 'cantidad'     =>  $request->cantidad,
        // 'disponible'     =>  $request->cantidad,
        // 'Detalles'     =>  $request->detalles,
        // 'regresa_a_almacen' => $request->optionsConsumibles,
        // 'modelo' => $request->modelo,
        // 'codigo' => $request->codigouabc,
        // 'noserie'=> $request->noserie,

        $form_data = [
            'name'    =>  $request->Nombre,
            'Matricula'     =>  $request->Matricula,
            'almacen'     =>  $almacen,
            'tipo'     =>  $request->tipo,
            'permiso'     =>  $request->permiso,
            'cantidad'     =>  $request->cantidad,
            'Detalles'     =>  $request->detalles,
            'regresa_a_almacen' => $request->optionsConsumibles,
            'modelo' => $request->modelo,
            'codigo' => $request->codigouabc,
            'noserie'=> $request->noserie,

        ];

        $error = Validator::make($request->all(), [
            'Nombre'    =>  'required|max:50|min:3',
            'Matricula'     =>  'required|max:10|min:3|unique:productos' . $request->id . ',id',
            'almacen' => 'exclude_unless:Nivel,Administrador|required|Exists:almacenes,Matricula',
            'tipo' => 'required',
            'permiso' => 'required',
            'cantidad'     =>  'required|numeric|min:1',

        ]);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        Productos::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'El registro se ha modificado exitosamente']);
    }

    public function destroy(Productos $Producto)
    {
        echo ($Producto);
        $Producto->delete();
        $cantidad = Productos::where('almacen', $Producto->almacen)->count();
        DB::table('almacenes')->where('Matricula', '=', $Producto->almacen)->update(['productos' => $cantidad]);
    }
}
