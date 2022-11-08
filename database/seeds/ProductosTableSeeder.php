<?php

use Illuminate\Database\Seeder;
use App\Productos;

use Faker\Factory as Factory;

class ProductosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        $arr = [
            ['ME-8590Pt_1','fotocompuerta','Kit','Contiene: 2 abrazaderas, 1 polea con abrazadera, dos cables, 2 fotocompuertas','MA'],
            ['ME-8590Pt_2','fotocompuerta','Kit','Contiene: 2 abrazaderas, 1 polea con abrazadera, dos cables, 2 fotocompuertas','MA'],
            ['ME-8590Pt_3','fotocompuerta','Kit','Contiene: 2 abrazaderas, 1 polea con abrazadera, dos cables, 2 fotocompuertas','MA'],
            ['ME-8590Pt_4','fotocompuerta','Kit','Contiene: 2 abrazaderas, 1 polea con abrazadera, dos cables, 2 fotocompuertas','MA'],
            ['ME-8590Pt_5','fotocompuerta','Kit','Contiene: 2 abrazaderas, 1 polea con abrazadera, dos cables, 2 fotocompuertas','MA'],
            ['ME-8590Pt_6','fotocompuerta','Kit','Contiene: 2 abrazaderas, 1 polea con abrazadera, dos cables, 2 fotocompuertas','MA'],
            ['IJ-2089','banco de pruebas','Unico','Equipo','M'],
            ['1212121212','Laptop HP-20Pt_1','Unico','Unico','MA'],
            ['HP-20Pt_2','Laptop','Unico','Sin descripcion','M'],
            ['HP-20Pt_3','Laptop','Unico','Sin descripcion','M'],
            ['AKJPt_1','Flexometro 5m','Consumible','Cinta de poliester','MA'],
            ['AKJPt_2','Flexometro 5m','Consumible','Cinta de poliester','MA'],
            ['AKJPt_3','Flexometro 5m','Consumible','Cinta de poliester','MA'],
            ['AKJPt_4','Flexometro 5m','Consumible','Cinta de poliester','MA'],
            ['AKJPt_5','Flexometro 5m','Consumible','Cinta de poliester','MA'],
            ['AKJPt_6','Flexometro 5m','Consumible','Cinta de poliester','MA'],
            ['AKJPt_7','Flexometro 5m','Consumible','Cinta de poliester','MA'],
            ['AKJPt_8','Flexometro 5m','Consumible','Cinta de poliester','MA'],
            ['AKJPt_9','Flexometro 5m','Consumible','Cinta de poliester','MA'],
            ['AKJPt_10','Flexometro 5m','Consumible','Cinta de poliester','MA'],
            ['98976Pt_1','Cinta','Unico','Sin descripcion','MA'],
            ['98976Pt_2','Cinta','Unico','Sin descripcion','MA'],
            ['98976Pt_3','Cinta','Unico','Sin descripcion','MA'],
            ['98976Pt_4','Cinta','Unico','Sin descripcion','MA'],
            ['98976Pt_5','Cinta','Unico','Sin descripcion','MA'],
            ['98976Pt_6','Cinta','Unico','Sin descripcion','MA'],
            ['98976Pt_7','Cinta','Unico','Sin descripcion','MA'],
            ['98976Pt_8','Cinta','Unico','Sin descripcion','MA'],
            ['98976Pt_9','Cinta','Unico','Sin descripcion','MA'],
            ['98976Pt_10','Cinta','Unico','Sin descripcion','MA']
        ];


        foreach($arr as &$value){

            $faker = Factory::create();

            $regresa_a_almacen = $faker->randomElement([true, false]);
            $disponible = $faker->numberBetween($min = 0, $max = 7);

            $cantidad = $regresa_a_almacen ? 10 : $disponible;

            Productos::create([
                'Matricula' => $value[0],
                'name' => $value[1],
                'almacen' => $faker->randomElement(['EDH','EDG','ABB']),
                'tipo' => $value[2],
                'cantidad' => $cantidad,
                'Detalles' => $value[3],
                'permiso' => $value[4],
                'disponible' => $disponible,
                'regresa_a_almacen' => $regresa_a_almacen,
                'modelo' => $faker->swiftBicNumber,
                'codigo' => $faker->ean8,
                'noserie' => $faker->isbn13
            ]);
        }
        
    }
}
