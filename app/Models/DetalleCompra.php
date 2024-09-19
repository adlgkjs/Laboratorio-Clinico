<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;

    protected $table = 'detalle_compra';

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'compra_id');
    }
    
    public function estudio()
    {
        return $this->belongsTo(Estudio::class, 'estudio_id');
    }
}


