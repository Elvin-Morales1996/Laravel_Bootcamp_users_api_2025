<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PaisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $paises = Pais::paginate(10);
            return response()->json([
                'message'=> 'Países obtenidos correctamente',
                'data' => $paises
            ], 200);
        } catch (\Throwable $th) {
            return $this->handleError($th);
        }
    }

//crear un metodo para manejar los errores
    private function handleError(\Throwable $th)
{
    return response()->json([
        'status' => false,
        'message' => 'Ocurrió un error inesperado.',
        'error' => env('APP_DEBUG') ? $th->getMessage() : null
    ], 500);
}

//metodo personalizado filtro
 public function filter(){
    try{
        //Esta es una consulta Eloquent, que genera un SQL
    $paises = Pais::where('status', '=','1')->paginate(10);
    return response()->json([
        'message' => 'Países activados',
        'data' => $paises
    ], 200);
}catch (\Throwable $th) {
        return $this->handleError($th);
    }
 }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $pais = Pais::where('id', $id)->where('status', '=','1')->first();
            return response()->json([          
                'data' => $pais
            ], 200);
        } catch (\Throwable $th) {
            return $this->handleError($th);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pais $pais)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pais $pais)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            DB::beginTransaction();
            if ($id ===null) return response()->json([
                'message' => 'pais no enviado'
            ], 400);

            $pais = Pais::where('id', $id)->where('status', '=','1')->first();
            if(!$pais) return response()->json([ 'message' => 'pais no encontrado' ], 400);

            $pais->delete();
            DB::commit();
            return response()->json([
                'message' => 'País eliminado correctamente',
                'data' => $pais
            ], 200);

        }catch(\Throwable $th) {
            DB::rollBack();
            return $this->handleError($th);

        }
    }
}
