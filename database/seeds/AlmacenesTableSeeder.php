<?php

use Illuminate\Database\Seeder;
use App\Almacenes;

class AlmacenesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $a1 = Almacenes::create([
            'Matricula' => 'EDH',
            'name' => 'Almacen Maquinas y Herramientas',
            'productos' => '0',
    ]);

        $a2= Almacenes::create([
            'Matricula' => 'EDG',
            'name' => 'Alamacen Maderas',
            'productos' => '0',
        ]);

        $a3 = Almacenes::create([
            'Matricula' => 'ABB',
            'name' => 'Almacen Basicas',
            'productos' => '0',
        ]);

    }
}
