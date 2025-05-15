<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $usuario = Usuario::all();
        return response()->json([
            'message'=>'listas de usuarios',
            'data'=>$usuario
        ]);
    }

    public function store(Request $request)
    {
        //
        $user = Usuario::create([
            'nombre'=>$request->nombre,
            'apellido'=>$request->apellido,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'status'=>$request->status
        ]);

        //mostrar usuario creado y mostrar el usuario nuevo
        return response()->json([
            'message'=>'usuario creado conexito',
            'data'=>$user
        ],201);

    }

    /**
     * moatrar un usuario con el id
     */
    public function show($id)
    {
        /**otra forma de hacer la busqueda cuando sea privilegios ejemplo
         * admin, usuario, lector, etc...
         * $user = Usuario::where('id',$id)->where('status','=','1')->first();
         */
        $user = Usuario::where('id',$id)->first();
        if (!$user) {
            return response()->json([
                'message'=>'usuario no existe con ese id'
            ],404);

        }
        return response()->json([
            'message'=>$user
        ],200);
    }


     //editar un usuario con id

    public function update(Request $request, $id)
    {
        //
        $usuario = Usuario::where('id',$id)->first();

        if (!$usuario) {
            return response()->json([
                'message'=>'usuario no encontrado con ese id'
            ],404);
        }

        $usuario->update([
            'nombre'=>$request->nombre,
            'apellido'=>$request->apellido,
            'email'=>$request->email,
            'password'=>$request->password ? Hash::make($request->password): $usuario->password,
            'status'=>$request->status ?? $usuario->status
        ]);

        return response()->json([
            'message'=>'usuario editado con exito',
            'data'=>$usuario
        ],404);
    }





    /**
     * eliminar un usuario con el id
     */
    public function destroy($id)
    {
        //
        $usuario = Usuario::where('id',$id)->first();
        if (!$usuario) {
            return response()->json([
                'message'=>'usuario no encontrado'
            ],404);
        }

        $usuario->delete();
        return response()->json([
            'message'=>'usuario eliminado',
            'data'=>$usuario
        ]);

    }


    //otro metodo
public function filter(){
    //todos los usuarios que esten activos
    $usuario= Usuario::where('status', '=','1')->paginate(10);
    return response()->json([
        'message'=>'todos los usuarios activos',
        'data'=>$usuario

    ],200);

}












}
