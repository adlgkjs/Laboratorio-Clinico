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
        .mb-0{
            margin-bottom: 0;
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
            @isset($infoCita['lada'])
            {{ $infoCita['lada'] }} {{$infoCita['telefono']}}
            @else
            {{$infoCita['telefono']}}
            @endisset
        </strong>.
    </p>
    <p>Correo: <strong>{{$infoCita['correo']}}</strong>.</p>
    <p>Domicilio: <strong>{{$infoCita['calle']}} {{$infoCita['no_ext']}}, int. {{$infoCita['no_int']}}. col. {{$infoCita['colonia']}}, cp. {{$infoCita['cp']}}, {{$infoCita['municipio']}}, {{$infoCita['estado']}}, {{$infoCita['pais']}}.</strong></p>
    <p>Fecha: <strong>{{$infoCita['fecha']}}.</strong></p>
    <p>Hora: <strong>{{$infoCita['hora']}}:{{$infoCita['minutos']}} hrs.</strong></p>

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
    <p class="mb-0">Tel: 33 4445 3900, Whatapp: 33 1500 1469</p>
    <p class="mb-0">Domicilio: Volcán Vesubio 6271, Col. El Colli Urbano, C.P. 45070, Zapopan, Jalisco, México.</p>
    <p class="mb-0">Horario: Lunes a Viernes de 7:00 a 18:00 hrs. Sábado 7:00 a 14:00 hrs.</p>

</body>

</html>