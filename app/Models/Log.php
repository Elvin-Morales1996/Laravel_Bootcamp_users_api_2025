<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    //HasFactory: permite crear datos falsos para pruebas
    //SoftDeletes: permite eliminar registros sin borrarlos físicamente de la base de datos
    use HasFactory, SoftDeletes;
    protected $table = 'logs';
    //datos que se van a guardar en la base de datos
    //fillable: permite asignar masivamente los campos especificados
    protected $fillable = [
        'user_id',
        'table_id',
        'table',
        'action',
        'method',
        'endpoint'

    ];
//ocultlar datos que no se quieren mostrar al usuario o api
    protected $hidden=[
        'created_at',
        'updated_at',
        'deleted_at'
    ];


}
