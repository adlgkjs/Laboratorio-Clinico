<!DOCTYPE html>
<html>

<body>
    <div style="display:flex; justify-content:center;">
        <img style="height:100px;" src="https://cdmilab.com/logo_CDMI.png">
    </div>
    <div style="background:#00a95e; height:5px;"></div>
    <h1>Nueva Solicitud de Contacto</h1>
    <p>Hola, me comunico desde su sitio web, mis datos de contacto son:</p>
    <p>Nombre: <strong>{{ $data['nombre'] }} {{$data['apellidos']}}</strong>.</p>
    <p>Telefono: <strong>{{ $data['lada'] }} {{$data['telefono']}}</strong>.</p>
    <p>Correo: <strong>{{ $data['correo'] }}</strong>.</p>
    <p>Mensaje: <strong>{{ $data['mensaje'] }}</strong>.</p>
    <div style="background:#00a95e; height:5px">
    </div>
</body>

</html>