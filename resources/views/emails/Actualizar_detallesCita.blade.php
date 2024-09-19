<!DOCTYPE html>
<html>

<head>
    <style>
        .my-0 {
            margin-top: 0;
            margin-bottom: 0;
        }
        .mb-0{
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <div style="display:flex; justify-content:center;">
        <img style="height:100px;" src="https://cdmilab.com/logo_CDMI.png">
    </div>
    <div style="background:#00a95e; height:5px;"></div>
    <h1>Detalles de la Cita Actualizada</h1>
    <p>Folio: <strong>{{$folio}}</strong></p>
    <p>Hola {{$infoCita['paciente']['nombre']}}, estos son los detalles de tu cita actualizada:</p>
    <p>Nombre: <strong>{{ $infoCita['paciente']['nombre'] }} {{$infoCita['paciente']['apellidos']}}</strong>.</p>
    <p>Telefono: <strong> {{$infoCita['paciente']['telefono']}}</strong>.</p>
    <p>Correo: <strong>{{ $infoCita['paciente']['correo'] }}</strong>.</p>

    <p>Domicilio: <strong>{{ $infoCita['paciente']['calle'] }} {{$infoCita['paciente']['num_ext']}}, int. {{$infoCita['paciente']['num_int']}}, col. {{ $infoCita['paciente']['colonia']}}, cp. {{$infoCita['paciente']['cp']}}, {{$infoCita['paciente']['municipio']}}, {{$infoCita['paciente']['estado']}}, {{$infoCita['paciente']['pais']}}</strong>.</p>

    <p>Fecha: <strong>{{ $infoCita['fecha'] }}</strong>.</p>
    <p>Horario: <strong>{{ $infoCita['hora'] }}:{{$infoCita['minutos']}}</strong>.</p>

    <h2>Estudios Selecionados</h2>
    <ul>
        @foreach($estudios as $estudio)
        <li>
            <p><strong>Nombre: </strong>{{$estudio['nombre']}}</p>
            <p><strong>Código: </strong>{{$estudio['codigo']}}</p>
            <p><strong>Indicaciones: </strong>{{$estudio['indicaciones_paciente']}}</p>
            <p><strong>Dias de proceso: </strong>{{$estudio['dias_proceso']}}</p>
            @if($estudio['precio'] != '0.00')
            <p><strong>Precio: </strong>${{number_format($estudio['precio'], 2, '.', ',')}}</p>
            @endif
        </li>
        <hr>
        @endforeach
    </ul>
    <p>Total: <strong>${{number_format($total, 2, '.', ',')}}</strong>.</p>

    <div style="background:#00a95e; height:5px;">

    <p class="mb-0">Tel: 33 4445 3900, Whatapp: 33 1500 1469</p>
    <p class="my-0">Domicilio: Volcán Vesubio 6271, Col. El Colli Urbano, C.P. 45070, Zapopan, Jalisco, México.</p>
    <p class="my-0">Horario: Lunes a Viernes de 7:00 a 18:00 hrs. Sábado 7:00 a 14:00 hrs.</p>

    </div>
</body>

</html>