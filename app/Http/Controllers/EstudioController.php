<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Estudio;
use App\Models\Paquete;

class EstudioController extends Controller
{
    //PARA OBTENER ESTUDIOS
    public function estudiosTodos()
    {
        $estudios = Estudio::get();
        return response()->json($estudios);
    }
    public function estudiosPacientes()
    {
        $estudios = Estudio::where('unidad_negocio_id', [1, 2])->get();
        return response()->json($estudios);
    }

    public function estudiosEmpresas()
    {
        $estudios = Estudio::where('unidad_negocio_id', [1, 2])->get();
        return response()->json($estudios);
    }  

    public function estudiosIndustrial()
    {
        $estudios = Paquete::where('unidad_negocio_id', 3)->get();
        return response()->json($estudios);
    }
  

    // Los estudios de industrial se manejan en la tabla paquetes
    // public function estudiosIndustrial()
    // {
    //     $estudios = Estudio::where('unidad_negocio_id', 3)->get();
    //     return response()->json($estudios);
    // }

    //PARA OBTENER PAQUETES
    public function paquetesPacienteEmpresa()
    {
        $paquetes = Paquete::where('unidad_negocio_id', [1, 2])->get();
        return response()->json($paquetes);
    }
}
