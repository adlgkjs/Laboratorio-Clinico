<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'pacientes';
    
    public function citas()
    {
        return $this->hasMany(Cita::class, 'paciente_id');
    }

    public function compras()
    {
        return $this->hasMany(Compra::class, 'paciente_id');
    }
}
