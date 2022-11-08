<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{

    protected $table = 'pedidos';

    protected $fillable = [
        'Solicitante','Almacen','Fecha','Inicial','Final'
    ];

    // Funciona
    public function almacen(){
        return $this->belongsTo('App\Almacenes', 'Almacen', 'Matricula');
    }

    // En proceso
    public function usuario(){
        return $this->belongsTo('App\User', 'Solicitante', 'id');
    }

}
