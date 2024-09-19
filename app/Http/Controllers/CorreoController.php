<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AgendarCitaMail;
use App\Mail\DetallesCitaMail;
use App\Mail\SolicitudDeContactoMail;
use App\Models\Paciente;
use App\Models\Cita;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Contacto;
use Illuminate\Mail\Mailables\Address;


use Illuminate\Http\Request;

class CorreoController extends Controller
{
    //ENVIAR CORREO CONTACTO Y ALMACENAR INFO
    public function enviarCorreoContacto(Request $request)
    {
        $request->validate([
            'recaptcha_token' => 'required',
            // Otras validaciones de formulario
        ]);

        $infoContacto = $request->input('infoContacto');
        $telefono = $infoContacto['lada'] . $infoContacto['telefono']; //Concatenar lada y telefono

        try {
            DB::beginTransaction();
            //Almacenar en BD
            $contacto = new Contacto();
            $contacto->nombre = $infoContacto['nombre'];
            $contacto->apellidos = $infoContacto['apellidos'];
            $contacto->correo = $infoContacto['correo'];
            $contacto->telefono = $telefono;
            $contacto->asunto = $infoContacto['asunto'];
            $contacto->mensaje = $infoContacto['mensaje'];
            $contacto->save();

            //Enviar Correo
            Mail::to(new Address('analista.software1@tdi-sa.com', 'Atención a clientes'))
                ->cc([
                    new Address('analista.software1@tdi-sa.com', 'Referencias CDMI'),
                ])
                ->send(new SolicitudDeContactoMail($infoContacto));

            // Mail::to(new Address('atencionaclientes@cdmilab.com', 'Atención a clientes'))
            //     ->cc([
            //         new Address('referencias@cdmilab.com', 'Referencias CDMI'),
            //         new Address('recepcion@cdmilab.com', 'Recepción CDMI')
            //     ])                
            //     ->send(new SolicitudDeContactoMail($infoContacto));
            DB::commit();

            return response()->json(['message' => 'successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al agendar cita: ' . $e->getMessage()); //Mostrar error en Logs

            return response()->json(['message' => 'error'], 500);
        }
    }

    //ALMACENAR INFO EN BD Y ENVIAR CORREOS DE CITA, FUNCION QUE USA comoponente agendarCita.vue
    public function agendarCita(Request $request)
    {

        $infoCita = $request->input('infoCita');
        $estudios = $request->input('estudios');
        $total = array_sum(array_column($estudios, 'precio')); //Calcular costo total

        $fecha = $infoCita['fecha']; //Se obtiene la fecha
        $hora = $infoCita['hora']; //Se obtiene la hora
        $minutos = $infoCita['minutos']; //Se obtiene los minutos
        $fechaHora = Carbon::createFromFormat('Y-m-d H:i:s', $fecha . ' ' . $hora . ':' . $minutos . ':00'); //Se concatena fecha y hora para formar un string
        $infoCita['fecha'] = Carbon::parse($fecha)->format('d-m-Y');
        // Log para depuración
        
        DB::beginTransaction();
        try {
            //ALMACENAR EN BD
            //1. Registra al Paciente, tabla "pacientes".
            $paciente = new Paciente();
            $paciente->nombre = $infoCita['nombre'];
            $paciente->apellidos = $infoCita['apellidos'];
            $paciente->correo = $infoCita['correo'];
            $paciente->telefono = $infoCita['telefono'];
            $paciente->calle = $infoCita['calle'];
            $paciente->num_ext = $infoCita['no_ext'];
            $paciente->num_int = isset($infoCita['no_int']) ? $infoCita['no_int'] : null; //campo opcional
            $paciente->colonia = $infoCita['colonia'];
            $paciente->cp = isset($infoCita['cp']) ? $infoCita['cp'] : null; //campo opcional
            $paciente->municipio = $infoCita['municipio'];
            $paciente->estado = $infoCita['estado'];
            $paciente->pais = $infoCita['pais'];
            $paciente->recibir_info = isset($infoCita['ofertas']) ? $infoCita['ofertas'] : null;
            $paciente->save();

            //2. Registrar la cita, tabla "citas".
            $cita = new Cita();
            $cita->paciente_id = $paciente->id;
            $cita->fecha_hora = $fechaHora;
            $cita->save();

            //3. Generar Folio
            $ultimoFolio = Compra::whereDate('created_at', now()->format('Y-m-d')) //Devuelve solo los registros que coinciden con la fecha actual.
                ->orderBy('id', 'desc') //Ordena los registros del mas reciente al mas antiguo.
                ->first(); //Obtiene el primer registro.
            $numFolio = 1;
            if ($ultimoFolio) {
                $ultimoFolio = (int) substr($ultimoFolio->folio, -3); //Se extraen los ultimo tres digitos del folio.
                $numFolio = $ultimoFolio + 1; //Se incrementa el ultimo folio para obetener el folio nuevo.
            }
            $folio = now()->format('ymd') . '-' . str_pad($numFolio, 3, '0', STR_PAD_LEFT); //Se genera el folio completo.

            //4. Registrar la compra, tabla "compras".
            $compra = new Compra();
            $compra->paciente_id = $paciente->id;
            $compra->cita_id = $cita->id;
            $compra->folio = $folio;
            $compra->total_compra = $total;
            $compra->fecha_compra = now();
            $compra->save();

            //5. Registrar detalle de compra, tabla "detalle_compra".
            foreach ($estudios as $estudio) {
                $detalleCompra = new DetalleCompra();
                $detalleCompra->compra_id = $compra->id;
                $detalleCompra->estudio_id = $estudio['id'];
                $detalleCompra->folio = $folio;
                $detalleCompra->subtotal = $estudio['precio'];
                $detalleCompra->save();
            }

            //GENERAR PDF
            $pdf = new Dompdf();
            $pdf->setOptions(new Options([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true, //Permitir imagenes remotas
            ]));
            $pdf->loadHtml(view('pdf.detalleCita', compact('folio', 'infoCita', 'estudios', 'total'))->render()); //Se carga la vista y se pasan los datos   
            $pdf->render(); //Se convierte el HTML5 a PDF
            //Descargar el PDF
            $pdfOutput = $pdf->output();

            //ENVIAR CORREOS               
            Mail::to($infoCita['correo'])->send(new DetallesCitaMail($folio, $infoCita, $estudios, $total)); //Correo para Paciente
            Mail::to(new Address('analista.software1@tdi-sa.com', 'Atención a clientes'))
                ->cc([
                    new Address('analista.software1@tdi-sa.com', 'Referencias CDMI'),
                ])
                ->send(new AgendarCitaMail($folio, $infoCita, $estudios, $total)); //Correo para Administradores

            // Mail::to($infoCita['correo'])->send(new DetallesCitaMail($folio, $infoCita, $estudios, $total)); //Correo para Paciente
            // Mail::to(new Address('atencionaclientes@cdmilab.com', 'Atención a clientes'))
            // ->cc([
            //     new Address('referencias@cdmilab.com', 'Referencias CDMI'),
            //     new Address('recepcion@cdmilab.com', 'Recepción CDMI')
            // ])    
            // ->send(new AgendarCitaMail($folio, $infoCita, $estudios, $total)); //Correo para Administradores

            DB::commit();

            return response()->json([
                'folio' => $folio, //Se devuelve la respuesta con el folio
                'pdf' => base64_encode($pdfOutput) // Codificar el PDF en base64 para enviarlo en JSON            
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al agendar cita: ' . $e->getMessage());
            return response()->json(['message' => 'error'], 500);
        }
    }
}
