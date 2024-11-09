<!DOCTYPE html>
<html>

<body>
    <div style="display:flex; justify-content:center;">
        <img style="height:100px;" src="https://cdmilab.com/logo_CDMI.png">
    </div>
    <div style="background:#00a95e; height:5px;"></div>
    <h1>Cita agendada</h1>
    <p>Tienes una nueva cita de:</p>
    <p>Folio: <strong>{{$folio}}</strong></p>
    <p>Nombre: <strong>{{ $infoCita['nombre'] }} {{$infoCita['apellidos']}}</strong>.</p>

    @if(isset($infoCita['fecha_nacimiento']))
    <p>Fecha Nacimiento: <strong>{{ $infoCita['fecha_nacimiento'] }}</strong>.</p>
    @endif

    <p>Telefono: <strong>
            @if(isset($infoCita['lada']) && array_key_exists('lada', $infoCita) && !empty($infoCita['lada']))
            {{ $infoCita['lada'] }} {{$infoCita['telefono']}}
            @else
            {{$infoCita['telefono']}}
            @endif
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
            <p><strong>Código: </strong>{{$estudio['codigo']}}</p>
            <p><strong>Nombre: </strong>{{$estudio['nombre']}}</p>
            <p><strong>Precio: </strong>${{number_format($estudio['precio'], 2, '.', ',')}}</p>
        </li>
        <hr>
        @endforeach
    </ul>
    <p>Total: <strong>${{number_format($total, 2, '.', ',')}}</strong></p>

    <div style="background:#00a95e; height:5px">
    </div>
</body>

</html>