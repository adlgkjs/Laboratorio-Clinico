<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudio extends Model
{
    use HasFactory;

    protected $table = 'estudios';

    public function unidadNegocio()
    {
        return $this->belongsTo(UnidadNegocio::class, 'unidad_negocio_id');
    }
    public function detalleCompra()
    {
        return $this->hasMany(DetalleCompra::class, 'estudio_id');
    }
}
