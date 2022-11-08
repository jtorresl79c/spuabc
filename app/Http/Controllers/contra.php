<?php

namespace App\Http\Controllers;

use App\Rules\viejacontra;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class contra extends Controller
{
    public function __invoke(Request $request)
    {
        $rules = array(
            'C' => 'required', new viejacontra,
            'NC' => 'required|string|min:8|max:22|different:C',
            'CNC' => 'required|same:NC',
        );

        $mensajes = array(
            'C.required' => 'Es necesario que selecciones que ingrese su contraseña actual.',
            'NC.required' => 'Es necesario que ingrese una nueva contraseña.',
            'CNC.required' => 'Es necesario que valide la nueva contraseña que eligira.',
            'NC.different' => 'Su nueva contraseña tiene que ser diferente de la actual.',
            'CNC.same' => 'La nueva contraseña y su confirmación no coinciden.',
        );

        $error = Validator::make($request->all(), $rules, $mensajes);

        if ($error->fails()) {
            return redirect()->route('home')->with(['warning' => $error->errors()->all()]);
        }
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->NC)]);

        return redirect()->route('home')->with(['success' => 'Se ha modificado la contraseña exitosamente']);
    }
}
