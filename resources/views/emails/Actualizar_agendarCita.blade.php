<!DOCTYPE html>
<html>

<body>
    <div style="display:flex; justify-content:center;">
        <img style="height:100px;" src="https://cdmilab.com/logo_CDMI.png">
    </div>
    <div style="background:#00a95e; height:5px;"></div>
    <h1>Cita Actializada</h1>
    <p>La siguiente cita ha sido actualizada:</p>
    <p>Folio: <strong>{{$folio}}</strong></p>
    <p>Nombre: <strong>{{ $infoCita['paciente']['nombre'] }} {{$infoCita['paciente']['apellidos']}}</strong>.</p>

    @if(isset($infoCita['paciente']['fecha_nacimiento']))
    <p>Fecha Nacimiento: <strong>{{ $infoCita['paciente']['fecha_nacimiento']}}</strong>.</p>
    @endif

    <p>Telefono: <strong> {{$infoCita['paciente']['telefono']}}</strong>.</p>
    <p>Correo: <strong>{{ $infoCita['paciente']['correo'] ?? 'No proporcionado' }}</strong>.</p>

    @if($infoCita['paciente']['calle'])
    <p>Domicilio:
        <strong>
            {{ $infoCita['paciente']['calle'] ?? '' }}
            {{ $infoCita['paciente']['no_ext'] ?? '' }}
            {{ isset($infoCita['paciente']['no_int']) ? ', int. ' . $infoCita['paciente']['no_int'] : '' }}
            {{ isset($infoCita['paciente']['colonia']) ? ', col. ' . $infoCita['paciente']['colonia'] : '' }}
            {{ isset($infoCita['paciente']['cp']) ? ', cp. ' . $infoCita['paciente']['cp'] : '' }}
            {{$infoCita['paciente']['municipio'] ?? ''}},
            {{$infoCita['paciente']['estado'] ?? ''}},
            {{$infoCita['paciente']['pais'] ?? ''}}
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