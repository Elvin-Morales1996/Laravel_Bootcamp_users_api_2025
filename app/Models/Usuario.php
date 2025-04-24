<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    //los campos que van a interactuar con la base de datos
    use HasFactory;
    protected $fillable=[
        'nombre',
        'apellido',
        'email',
        'password'

    ];

    /*campos que estaran ocultos cuando los
    llame en formato json
    */

    protected $hidden=[
        'password',
        'created_at',
        'cupdated_at'
    ];
}
