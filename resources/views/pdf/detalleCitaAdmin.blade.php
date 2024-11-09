<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        p {
            margin: 5px 0;
        }

        .header {
            text-align: center;
            /*para centrar la imagen*/
        }

        .header img {
            height: 100px;
        }

        .divider {
            background: #00a95e;
            height: 5px;
        }

        .section {
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="https://cdmilab.com/logo_CDMI.png" />
    </div>
    <div class="divider"></div>
    <h2>Datos del Paciente</h2>
    <h3>Folio: <strong>{{$folio}}</strong></h3>
    <p>Nombre: {{$infoCita['nombre']}} {{$infoCita['apellidos']}}.<strong></strong></p>
    <p>Telefono:
        <strong>
            {{$infoCita['telefono']}}            
        </strong>.
    </p>
    <p>Correo: <strong>{{$infoCita['correo']}}</strong>.</p>
    <p>Domicilio: <strong>{{$infoCita['calle']}} {{$infoCita['num_ext']}}, int. {{$infoCita['num_int']}}. col. {{$infoCita['colonia']}}, cp. {{$infoCita['cp']}}, {{$infoCita['municipio']}}, {{$infoCita['estado']}}, {{$infoCita['pais']}}.</strong></p>
    <p>Fecha: <strong>{{$fecha}}.</strong></p>
    <p>Hora: <strong>{{$hora}} hrs.</strong></p>

    <div class="section">
        <h2>Estudios Seleccionados</h2>
        <ul>
            @foreach($estudios as $estudio)
            <li>
                <p>Nombre: <strong>{{$estudio['nombre']}}</strong></p>
                <p>Código: <strong>{{$estudio['codigo']}}</strong></p>
                <p>Indicaciones: <strong>{{$estudio['indicaciones_paciente']}}</strong></p>
                <p>Dias Proceso: <strong>{{$estudio['dias_proceso']}}</strong></p>
                @if($estudio['precio'] != '0.00')
                <p>Precio: <strong>${{number_format($estudio['precio'], 2, '.', ',')}} </strong>IVA incluido.</p>
                @endif
            </li>
            <hr>
            @endforeach
        </ul>
    </div>
    <h3>Total: <strong>${{number_format($total, 2, '.', ',')}}</strong> IVA incluido.</h3>
    <p><strong>El costo total de sus estudios debera ser cubierto en nuestras intalaciones.</strong></p>
    <div class="divider"></div>
</body>

</html>