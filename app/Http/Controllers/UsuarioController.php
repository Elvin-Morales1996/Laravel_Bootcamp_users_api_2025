<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Exception;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try{
        $usuario = Usuario::all();
        return response()->json([
            'message'=>'listas de usuarios',
            'data'=>$usuario
        ],200);
    }catch(\Throwable $th){
        if (env('APP_PRODUCTION',true)) return response()->json([
            'message'=>'ocurrio un error verifique la informacion o vuelva a intentarlo mas tarde '
        ],500);
        return response()->json([
            'message'=>'ocurrio un error',
            'error'=>$th->getMessage(),
            'trace'=>$th->getTrace(),
        ],500);
          
        }
    
    }

    public function store(Request $request)
    {
        try {
            //code...
        
        //
        $request->validate([
        //validacion de los campos  
        'nombre'=>'required|string|max:255',
        'apellido'=>'required|string|max:255',
        'email'=>'required|email|unique:usuarios,email',
        //una manera de hacerlo
        /*'password'=>[
            'required',
            'string',
            Password::min(8)->mixedCase()->numbers()->symbols()
            ]*/

            'password'=>'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*?&]/'
        
        ]);


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

        //validar validaciones de errores
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error de validación',
                'error' => $e->errors()
            ], 422);
        } 
        
        
        catch (Exception $t) {
            Log::error('error al crear el usuario: '.$t->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Internal_Server_Error',
                'error' => $t->getMessage(),
            ], 500);
        }

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

   try {
        $user = Usuario::where('id', $id)
                       ->where('status', '1')
                       ->firstOrFail();

        return response()->json([
            'message' => $user
        ], 200);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'status' => false,
            'message' => 'Usuario no encontrado o está inactivo',
            'code' => 404
        ], 404);
    }
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
