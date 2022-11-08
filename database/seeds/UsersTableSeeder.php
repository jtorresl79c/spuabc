<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            ['1244140','Alex','Jimenez','Bustillos','ajimenez18@uabc.edu.mx','Almacenista',],
            ['29340','Camilo','Caraveo','Mena','camilo.caraveo@uabc.edu.mx','Administrador'],
            ['25185','victor manuel','bautista','Mendoza','bautista.victor@uabc.edu.mx','Usuario'],
            ['26752','Gabriela','Cisneros','Solis','gabriela.cisneros@uabc.edu.mx','Administrador'],
            ['23463','SALVADOR','FIERRO','SILVA','salvador.fierro@uabc.edu.mx','Maestro'],
            ['27107','Daniela Mercedes','Martínez','Plata','daniela.martinez@uabc.edu.mx','Maestro'],
            ['26729','Guillermo','Sepulveda','Gil','guillermo.sepulveda@uabc.edu.mx','Usuario'],
            ['22488','Antonio','Gomez','Roa','gomez_roa@uabc.edu.mx','Maestro'],
            ['23330','Claudia Elizabeth','Vargas','Muñiz','claudiavargas@uabc.edu.mx','Almacenista'],
            ['26722','Jesus Eladio','Moreno','Pastrano','eladio.moreno@uabc.edu.mx','Almacenista'],
            ['24069','Miguel Angel','Avila','Puc','avilam75@uabc.edu.mx','Usuario'],
            ['25463','Vladimir','Becerril','Mendoza','vladimir.becerril@uabc.edu.mx','Usuario'],
            ['1111111','Anthony','Dalton', 'Prime' , 'spuabc@uabc.edu.mx','Administrador'],
        ];

        
        foreach($arr as &$value){
            User::create([
                'Matricula' => $value[0],
                'name' => $value[1],
                'apellidoP' => $value[2],
                'apellidoM' => $value[3],
                'email' => $value[4],
                'password' => Hash::make('admin123'),
                'role' => $value[5]
            ]);
        }




        // $admin = User::create([
        //     'Matricula' => '100001',
        //     'name' => 'Administrador',
        //     'apellidoP' => 'Administrador',
        //     'apellidoM' => 'Administrador',
        //     'email' => 'admin@general.com',
        //     'password' => Hash::make('123123123'),
        //     'role' => 'Admin'
        // ]);
        // $Alm = User::create([
        //     'Matricula' => '100002',
        //     'name' => 'Almacenista',
        //     'apellidoP' => 'Administrador',
        //     'apellidoM' => 'Administrador',
        //     'email' => 'Almacenista@general.com',
        //     'password' => Hash::make('123123123'),
        //     'role' => 'Almacenista'
        // ]);
        // $Mae = User::create([
        //     'Matricula' => '100003',
        //     'name' => 'Maestro',
        //     'apellidoP' => 'Administrador',
        //     'apellidoM' => 'Administrador',
        //     'email' => 'Maestro@general.com',
        //     'password' => Hash::make('123123123'),
        //     'role' => 'Maestro'
        // ]);
        // $Alu = User::create([
        //     'Matricula' => '100004',
        //     'name' => 'Alumno',
        //     'apellidoP' => 'Administrador',
        //     'apellidoM' => 'Administrador',
        //     'email' => 'Alumno@general.com',
        //     'password' => Hash::make('123123123'),
        //     'role' => 'Usuario'
        // ]);
    }
}
