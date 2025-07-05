<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{

    public function run(): void
    {
        //primera forma de crear un usuario
        /*Usuario::create([
            'nombre'=>'roberto',
            'apellido'=>'morales',
            'email' => 'roberto2.morales@example.com',
            'password'=>Hash::make('Luis1234@'),
            'status'=>0,
            'created_at'=>now(),
            'updated_at'=>now(),
        ],
        [
            'nombre'=>'eee',
            'apellido'=>'eees',
            'email'=>'eeeee@gmail.com',
            'password'=>Hash::make('Leees@'),
            'status'=>0,
 
        ]
     );*/

//segunda forma de crear un usuario
  DB::table('usuarios')->insert([
    [
        'nombre' => 'roberto',
        'apellido' => 'morales',
        'email' => 'robertdfdfofef3.morales@example.com',
        'password' => Hash::make('Luis1234@'),
        'status' => 0,
    ],
    [
        'nombre' => 'eee',
        'apellido' => 'eees',
        'email' => 'eeedfdfdfee333erer3@gmail.com',
        'password' => Hash::make('Leees@'),
        'status' => 0,
    ]
]);


    }
}
