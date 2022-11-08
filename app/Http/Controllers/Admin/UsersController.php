<?php

namespace App\Http\Controllers\Admin;
use App\Almacenes;
use App\Http\Controllers\Controller;
use App\User;
use Gate;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    public function construct(){
        $this->middleware('auth');
}

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = User::all();
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Editar</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Eliminar</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);

        }
        $Alm = Almacenes::all();
        return view('admin.users.index')->with('Alm',$Alm);
    }

    public function update(Request $request)
    {


        $error = Validator::make($request->all(), [
            'Nombre' => ['required', 'string', 'max:255','min:2'],
            'apellidoP' => ['required', 'string','max:255','min:2'],
            'apellidoM' => ['required', 'string','max:255','min:2'],
            'Matricula' =>['required','integer','min:3','max:2147483647','unique:users'.$request->id.',id'],
            'Nivel' =>['required'],
            'almacen' =>['exclude_unless:Nivel,Almacenista','required','Exists:almacenes,Matricula']


        ]);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = [
            'name'    =>  $request->Nombre,
            'role'     =>  $request->Nivel,
            'apellidoP'     =>  $request->apellidoP,
            'apellidoM'     =>  $request->apellidoM,
            'almacen' => $request->almacen
        ];

        User::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'El registro se ha modificado exitosamente']);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if(Gate::denies('ManejarUsuario')){
            return redirect(route('admin.user.index'));
        }
        $user->delete();
    }

    public function edit($id)
    {
        if(Gate::denies('ManejarUsuario')){
            return redirect(route('admin.user.index'));
        }
        if(request()->ajax())
        {
            $data = User::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }


}
