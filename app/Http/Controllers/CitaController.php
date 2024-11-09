<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Cita;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Paciente;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Mail\ActualizarDetallesCitaMail;
use App\Mail\ActualizarAgendarCitaMail;
use App\Mail\AgendarCitaMail;
use App\Mail\DetallesCitaMail;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\Log;



class CitaController extends Controller
{
    public function obtenerHorariosDisponibles(Request $request)
    {
        $fecha = $request->input('fecha');

        try {
            // $fechaSeleccionada = Carbon::createFromFormat('Y-m-d', $fecha)->format('Y-m-d'); // Formatear la fecha seleccionada
            $citasDelDia = Cita::whereDate('fecha_hora', $fecha)->get(['fecha_hora']); //Busco por fecha obteniendo un array de la columna fecha_hora de los elementos que coincidan con la busqueda

            $horariosOcupados = $citasDelDia->groupBy(function ($cita) { //Agrupa las citas por hora
                return Carbon::parse($cita->fecha_hora)->format('H'); //Se formatea la fecha y solo se obtiene la hora
            })->map(function ($citasPorHora) { //Recorre cada grupo de citas que ocurren en la misma hora
                return $citasPorHora->map(function ($cita) {
                    return Carbon::parse($cita->fecha_hora)->format('i'); //Para cada cita en el grupo(hora) se extraen los minutos.
                });
            });

            return response()->json($horariosOcupados);
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error en obtenerHorariosDisponibles: ' . $e->getMessage());

            // Return a 500 error response with the error message
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }
    public function obtenerCitas()
    {
        $citas = Cita::with([
            'paciente',
            'compra',
            'compra.detalleCompra'
        ])->get();

        return response()->json($citas);
    }

    public function agendarNuevaCita(Request $request)
    {
        $infoCita = $request->input('infoCita');
        $estudios = $request->input('estudios');
        $total = array_sum(array_column($estudios, 'precio')); //Calcular costo total

        $fecha = $infoCita['fecha']; //Se obtiene la fecha
        $hora = $infoCita['hora']; //Se obtienen la fecha
        $minutos = $infoCita['minutos']; //Se obtienen los minutos
        $fechaHora = Carbon::createFromFormat('Y-m-d H:i', $fecha . ' ' . $hora . ':' . $minutos);

        DB::beginTransaction();
        try {
            //ALMACENAR EN BD
            //1. Tabla Pacientes
            $paciente = new Paciente();
            $paciente->nombre = $infoCita['nombre'];
            $paciente->apellidos = $infoCita['apellidos'];
            $paciente->fecha_nacimiento = $infoCita['fecha_nacimiento'] ?? null;
            $paciente->correo = $infoCita['correo'] ?? null;
            $paciente->telefono = $infoCita['telefono'];
            $paciente->calle = $infoCita['calle'] ?? null;
            $paciente->num_ext = $infoCita['no_ext'] ?? null;
            $paciente->num_int = $infoCita['no_int'] ?? null;
            $paciente->colonia = $infoCita['colonia'] ?? null;
            $paciente->cp = $infoCita['cp'] ?? null;
            $paciente->municipio = $infoCita['municipio'] ?? null;
            $paciente->estado = $infoCita['estado'] ?? null;
            $paciente->pais = $infoCita['pais'] ?? null;
            $paciente->pais = $infoCita['pais'] ?? null;
            $paciente->save();

            //2. Tabla Citas
            $cita = new Cita();
            $cita->paciente_id = $paciente->id;
            $cita->fecha_hora = $fechaHora;
            $cita->comentarios = $infoCita['comentarios'] ?? null;
            $cita->save();

            //3. Generar folio
            $ultimoFolio = Compra::whereDate('created_at', now()->format('Y-m-d')) //Devuelve los registros que coinciden con la fecha actual
                ->orderBy('id', 'desc') //Ordenar registros del mas reciente al mas antiguo
                ->first(); //Obtener el primer registro
            $numFolio = 1;
            if ($ultimoFolio) {
                $ultimoFolio = (int) substr($ultimoFolio->folio, -3); //Se extraen los los ultimos tred digitos del folio
                $numFolio = $ultimoFolio + 1; //Se incrementa el ultimo folio
            }
            $folio = now()->format('ymd') . '_' . str_pad($numFolio, 3, '0', STR_PAD_LEFT); //Se genera el folio completo

            //4. Tabla Compras
            $compra = new Compra();
            $compra->paciente_id = $paciente->id;
            $compra->cita_id = $cita->id;
            $compra->folio = $folio;
            $compra->total_compra = $total;
            $compra->fecha_compra = now();
            $compra->save();

            //5. Tabla Detalles Compras
            foreach ($estudios as $estudio) {
                $detalleCompra = new DetalleCompra();
                $detalleCompra->compra_id = $compra->id;
                $detalleCompra->estudio_id = $estudio['id'];
                $detalleCompra->folio = $folio;
                $detalleCompra->subtotal = $estudio['precio'];
                $detalleCompra->save();
            }

            //ENVIAR CORREOS   
            //Correo para paciente
            if($infoCita['correo']){
                Mail::to($infoCita['correo'])->send(new DetallesCitaMail($folio, $infoCita, $estudios, $total)); //Correo para Paciente
            }

            //Correo para CDMI
            Mail::to(new Address('analista.software1@tdi-sa.com', 'Atención a clientes'))
                ->cc([
                    new Address('analista.software1@tdi-sa.com', 'Referencias CDMI'),
                ])
                ->send(new AgendarCitaMail($folio, $infoCita, $estudios, $total)); //Correo para Administradores

            // Correo para paciente
            // if($infoCita['correo']){
            //     Mail::to($infoCita['correo'])->send(new DetallesCitaMail($folio, $infoCita, $estudios, $total)); //Correo para Paciente
            // }

            // Correo para CDMI
            // Mail::to(new Address('atencionaclientes@cdmilab.com', 'Atención a clientes'))
            //     ->cc([
            //         new Address('referencias@cdmilab.com', 'Referencias CDMI'),
            //         new Address('recepcion@cdmilab.com', 'Recepción CDMI')
            //     ])
            //     ->send(new AgendarCitaMail($folio, $infoCita, $estudios, $total)); //Correo para Administradores

            DB::commit();

            return response()->json(['folio' => $folio], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al agendar la cita: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['message' => 'error'], 500);
        }
    }

    public function actualizarCita(Request $request)
    {
        $infoCita = $request->input('infoCita');
        $estudios = $request->input('estudios');
        $total = array_sum(array_column($estudios, 'precio')); //Calcular costo total

        $fecha = $infoCita['fecha']; //Se obtiene la fecha
        $hora = $infoCita['hora']; //Se obtienen la fecha
        $minutos = $infoCita['minutos']; //Se obtienen los minutos
        $fechaHora = Carbon::createFromFormat('Y-m-d H:i', $fecha . ' ' . $hora . ':' . $minutos);

        DB::beginTransaction();
        try {
            //ALMACENAR EN BD
            //Tabla Pacientes
            $paciente = Paciente::find($infoCita['paciente_id']);
            if ($paciente) {
                $paciente->nombre = $infoCita['paciente']['nombre'];
                $paciente->apellidos = $infoCita['paciente']['apellidos'];
                $paciente->fecha_nacimiento = $infoCita['paciente']['fecha_nacimiento'] ?? null;
                $paciente->correo = $infoCita['paciente']['correo'] ?? null;
                $paciente->telefono = $infoCita['paciente']['telefono'];
                $paciente->calle = $infoCita['paciente']['calle'] ?? null;
                $paciente->num_ext = $infoCita['paciente']['num_ext'] ?? null;
                $paciente->num_int = $infoCita['paciente']['num_int'] ?? null;
                $paciente->colonia = $infoCita['paciente']['colonia'] ?? null;
                $paciente->cp = $infoCita['paciente']['cp'] ?? null;
                $paciente->municipio = $infoCita['paciente']['municipio'] ?? null;
                $paciente->estado = $infoCita['paciente']['estado'] ?? null;
                $paciente->pais = $infoCita['paciente']['pais'] ?? null;
                $paciente->save();
            } else {
                return response()->json(['message' => 'Paciente no encontrado.'], 404);
            }

            //Tabla Citas
            $cita = Cita::find($infoCita['id']);
            if ($cita) {
                $cita->fecha_hora = $fechaHora;
                $cita->comentarios = $infoCita['comentarios'] ?? null;
                $cita->save();
            } else {
                return response()->json(['message' => 'Cita no encontrada.'], 404);
            }

            //Tabla Compras
            $compra = Compra::find($infoCita['compra']['id']);
            if ($compra) {
                $compra->total_compra = $total;
                $compra->save();
            } else {
                return response()->json(['message' => 'Compra no encontrada.'], 404);
            }

            //Tabla Detalles Compras
            DetalleCompra::where('compra_id', $compra->id)->delete(); //Eliminar detalles existentes
            foreach ($estudios as $estudio) {
                $detalleCompra = new DetalleCompra();
                $detalleCompra->compra_id = $compra->id;
                $detalleCompra->estudio_id = $estudio['id'];
                $detalleCompra->folio = $compra->folio;
                $detalleCompra->subtotal = $estudio['precio'];
                $detalleCompra->save();
            }
            DB::commit();

            try {
                //ENVIAR CORREOS
                //Correo paciente
                if($infoCita['paciente']['correo']){
                    Mail::to($infoCita['paciente']['correo'])->send(new ActualizarDetallesCitaMail($compra->folio, $infoCita, $estudios, $total));
                }
                //Correo CDMI
                Mail::to(new Address('analista.software1@tdi-sa.com', 'Atención a clientes'))
                    ->cc([
                        new Address('analista.software1@tdi-sa.com', 'Referencias CDMI'),
                    ])
                    ->send(new ActualizarAgendarCitaMail($compra->folio, $infoCita, $estudios, $total));

                // Correo paciente
                // if($infoCita['paciente']['correo']){
                //     Mail::to($infoCita['paciente']['correo'])->send(new ActualizarDetallesCitaMail($compra->folio, $infoCita, $estudios, $total));
                // }

                // Correo CDMI
                // Mail::to(new Address('atencionaclientes@cdmilab.com', 'Atención a clientes'))
                //     ->cc([
                //         new Address('referencias@cdmilab.com', 'Referencias CDMI'),
                //         new Address('recepcion@cdmilab.com', 'Recepción CDMI')
                //     ])
                //     ->send(new ActualizarAgendarCitaMail($compra->folio, $infoCita, $estudios, $total));
            } catch (\Exception $e) {
                Log::error('Error al enviar correos: ' . $e->getMessage(), ['exception' => $e]);
                return response()->json(['message' => 'Cita actualizada, pero ocurrió un error al enviar el correo.'], 500);
            }

            return response()->json(['message' => 'Cita actualizada correctamente.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar cita: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['message' => 'error'], 500);
        }
    }

    public function eliminarCita(Request $request)
    {
        $request->validate([
            'cita' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $cita = $request->input('cita');

            $cita = Cita::findOrFail($cita['id']);
            $cita->compra->detalleCompra()->delete(); //Eliminar detalles de la compra
            $cita->compra()->delete(); //Eliminar la compra
            $cita->delete(); //Eliminar la cita

            DB::commit();

            return response()->json(['message' => 'Cita eliminada correctamente.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al aliminar cita: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['message' => 'error'], 500);
        }
    }

    public function generarPDF(Request $request)
    {
        $infoCita = $request->input('data.paciente');
        $estudios = $request->input('estudios');
        $folio = $request->input('data.compra.folio');
        $total = array_sum(array_column($estudios, 'precio'));

        //Extraer la fecha y la hora
        $fecha_hora = $request->input('data.fecha_hora');
        $fecha = substr($fecha_hora, 0, 10);
        $hora =  substr($fecha_hora, 11, 5);

        try {
            $pdf = new Dompdf();
            $pdf->setOptions(new Options([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true, //Permitir imagenes remotas
            ]));

            $html = view('pdf.detalleCita', compact('folio', 'fecha', 'hora', 'infoCita', 'estudios', 'total'))->render(); //Se carga la vista y se pasan los datos   
            $pdf->loadHtml($html); //Se convierte el HTML5 a PDF
            $pdf->render();
            $pdfOutput = $pdf->output();

            return response()->json(['pdf' => base64_encode($pdfOutput)], 200);
        } catch (\Exception $e) {
            Log::error('Error al generar el PDF: ' . $e->getMessage());
            return response()->json(['message' => 'error'], 500);
        }
    }
}
