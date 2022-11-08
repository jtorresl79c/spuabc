<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Notifications\Notifiable;

class Productos extends Model
{

    protected $table = 'productos';
    use Notifiable;

    protected $fillable = [
        'Matricula','name','almacen','tipo','permiso','cantidad','disponible','detalles', 'regresa_a_almacen', 'modelo', 'codigo', 'noserie'
    ];
    protected $casts = [
        'cantidad' => 'integer',
    ];
}
