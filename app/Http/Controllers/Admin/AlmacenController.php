<?php

namespace App\Http\Controllers\Admin;

use App\Almacenes;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DataTables;

class AlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'Matricula' =>['required','string','min:3','max:255','unique:almacenes'],
        ]);
    }

    public function index(Request $request)
    {
        {
            if($request->ajax())
            {
                $data = Almacenes::all();
                return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Editar</button>';
                        $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Eliminar</button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);

            }
            return view('admin.almacenes.index');
        }
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
        $rules = array(
            'Nombre'    =>  'required|max:50|min:5',
            'Matricula'     =>  'required|unique:almacenes|max:10|min:3'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'name'        =>  $request->Nombre,
            'Matricula'         =>  $request->Matricula,
            'productos' => '0',
        );

        Almacenes::create($form_data);

        return response()->json(['success' => 'Se agrego el registro exitosamente.']);
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
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Almacenes::findOrFail($id);
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
    public function update(Request $request, $id)
    {
        $form_data = [
            'name'    =>  $request->Nombre,
            'Matricula'     =>  $request->Matricula,
        ];
        $error = Validator::make($request->all(), [
            'Nombre'    =>  'required|max:50|min:5',
            'Matricula'     =>  'required|max:10|min:3|unique:almacenes'.$request->id.',id'
        ]);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        almacenes::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'El registro se ha modificado exitosamente']);
    }


    public function destroy($id)
    {
        almacenes::destroy($id);
    }
}
