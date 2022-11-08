<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class confirm extends Controller
{
    public function __invoke(Request $request) // Cuando presionas el boton de "Crear Solicitud" manda un request a esta funcion
    {
        if($request->id == null)
        {
            return response()->json(['errors' => ["Debes de seleccionar al menos un elemento"]]);
        }
        $productos = DB::table('productos')
            ->whereIn('id', array_values($request->id))
            ->select(
                'id',
                'Matricula',
                'name',
                'almacen'
            )->get();
        return response()->json(['result' => $productos]);
    }
}
