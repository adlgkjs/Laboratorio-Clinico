<?php

use App\Http\Controllers\EstudioController;
use App\Http\Controllers\CorreoController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*f
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('welcome');
})->name('login');

//PARA LOGUEARSE
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);

//PARA OBTENER ESTUDIOS
Route::get('/obtenerEstudiosTodos', [EstudioController::class, 'estudiosTodos']);
Route::get('/obtenerEstudiosPacientes', [EstudioController::class, 'estudiosPacientes']);
Route::get('/obtenerEstudiosEmpresas', [EstudioController::class, 'estudiosEmpresas']);
Route::get('/obtenerEstudiosIndustrial', [EstudioController::class, 'estudiosIndustrial']); //Estan en tabla paquetes

//PARA OBTENER PAQUETES
Route::get('/obtenerPaquetesPacientes', [EstudioController::class, 'paquetesPacienteEmpresa']);

//PARA OBTENER HORARIOS DISPONIBLES
Route::get('/disponibilidad-horario', [CitaController::class, 'obtenerHorariosDisponibles']);


//PARA ENVIAR CORREOS
Route::post('/agendarcita2', [CorreoController::class, 'agendarCita']);
Route::post('/enviarCorreoContacto', [CorreoController::class, 'enviarCorreoContacto']);

//Al parecer mi autenticacion funciona sin este middleware pero lo dejo para agregar una capa de seguiradad adicional
Route::middleware('auth')->group(function () {
    Route::get('/panelAdministracion', function () {
        return view('welcome');
    });
    //OBTENER CITAS
    Route::get('/obtenerCitas', [CitaController::class, 'obtenerCitas']);
    Route::post('/actualizarCita', [CitaController::class, 'actualizarCita']);
    Route::delete('/eliminarCita', [CitaController::class, 'eliminarCita']);
    Route::post('/agendarNuevaCita', [CitaController::class, 'agendarNuevaCita']);
    Route::post('/generarPDF', [CitaController::class, 'generarPDF']);
});

Route::get('/check-auth', function () {
    return response()->json(['authenticated' => Auth::check()]);
});



//Esta ruta es para que cualquier otra ruta distinta a '/' se envie a welcome, que es donde renderizo mis componentes Vue.
Route::get('{any}', function () {
    return view('welcome'); // Asegúrate de que 'welcome' es el archivo Blade que carga tu aplicación Vue
})->where('any', '.*');
