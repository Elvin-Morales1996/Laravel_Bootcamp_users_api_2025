<?php
//esta es una manera de manejar las excepciones de la aplicacion
namespace App\Exceptions;

//usar diferentes librerias
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
   
    protected $dontReport = [];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];
//funcion para manejar las excepciones de autenticacion
    public function register():void{
        $this->reportable(function (Throwable $e) {
            
        });
    }


    //funcion render
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            //error del modelo no encontrado o el famoso error 404
            return response()->json([
                'status' => false,
                'message' => 'recurso no encontrado',
                'code' => 404

            ], 404);
        }

        return parent::render($request, $exception);
    }

}

?>