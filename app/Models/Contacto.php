<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;

    protected $table = 'contactos';

    //Con el $fillable especifico que campos pueden ser llenados en masa
    protected $fillable = [ 
        'nombre',
        'apellidos',
        'correo',
        'telefono',
        'asunto',
        'mensaje',
    ];
}
