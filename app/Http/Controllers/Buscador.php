<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Buscador extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $rules = array(
            'almacen' => 'required|exists:almacenes,matricula',
            'fecha' => 'required',
            'hi' => 'required|numeric',
            'hf' => 'required|gt:hi|numeric',
        );

        $mensajes = array(
            'almacen.required' => 'Es necesario que selecciones un Almacen.',
            'fecha.required' => 'Es necesario seleccionar la fecha de tu prestamos.',
            'hi.required' => 'Es necesario que selecciones una Hora inicial valida para el prestamo.',
            'hf.gt' => 'No puedes seleccionar una Hora final que sea menor que la inicial.',
            'hi.numeric' => 'Es necesario que selecciones una Hora Inicial valida para el prestamo.',
            'hf.numeric' => 'Es necesario que selecciones una Hora Final valida para el prestamo.',
        );

        $error = Validator::make($request->all(), $rules, $mensajes);

        if ($error->fails()) {
            return redirect()->route('home')->with(['warning' => $error->errors()->all()]);
        }

        $response = serialize([
            $request->almacen,  //0
            $request->fecha,    //1
            $request->hi,       //2
            $request->hf        //3
        ]);

        $cookie = Cookie('consulta', $response);
        return redirect()->route('Us.Usuario.index')->Cookie($cookie);
    }
}
