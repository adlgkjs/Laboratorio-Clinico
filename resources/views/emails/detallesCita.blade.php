<!DOCTYPE html>

<html>

<head>
    <style>
        .my-0 {
            margin-top: 0;
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <div style="display:flex; justify-content:center;">
        <img style="height:100px;" src="https://cdmilab.com/logo_CDMI.png">
    </div>
    <div style="background:#00a95e; height:5px;"></div>
    <h1>Detalles de la Cita</h1>
    <p>Folio: <strong>{{$folio}}</strong></p>
    <p>Hola {{$infoCita['nombre']}}, estos son los detalles de tu cita:</p>
    <p>Nombre: <strong>{{ $infoCita['nombre'] }} {{$infoCita['apellidos']}}</strong>.</p>

    @if(isset($infoCita['fecha_nacimiento']))
    <p>Fecha Nacimiento: <strong>{{ $infoCita['fecha_nacimiento'] }}</strong>.</p>
    @endif


    <p>Telefono: <strong>
            @isset($infoCita['lada'])
            {{ $infoCita['lada'] }} {{$infoCita['telefono']}}
            @else
            {{$infoCita['telefono']}}
            @endisset
        </strong>.
    </p>
    <p>Correo: <strong>{{ $infoCita['correo'] ?? 'No proporcionado' }}</strong>.</p>

    @if(isset($infoCita['calle']))
    <p>Domicilio:
        <strong>
            {{ $infoCita['calle'] ?? '' }} 
            {{ $infoCita['no_ext'] ?? '' }} 
            {{ isset($infoCita['no_int']) ? ', int. ' . $infoCita['no_int'] : '' }}
            {{ isset($infoCita['colonia']) ? ', col. ' . $infoCita['colonia'] : '' }}
            {{ isset($infoCita['cp']) ? ', cp. ' . $infoCita['cp'] : '' }}
            {{$infoCita['municipio'] ?? ''}}, 
            {{$infoCita['estado'] ?? ''}}, 
            {{$infoCita['pais'] ?? ''}}
        </strong>.
    </p>
    @endif

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

    <div style="background:#00a95e; height:5px"></div>

    <p class="my-0">Tel: 33 4445 3900, Whatapp: 33 1500 1469</p>
    <p class="my-0">Domicilio: Volcán Vesubio 6271, Col. El Colli Urbano, C.P. 45070, Zapopan, Jalisco, México.</p>
    <p class="my-0">Horario: Lunes a Viernes de 7:00 a 18:00 hrs. Sábado 7:00 a 14:00 hrs.</p>
</body>

</html>