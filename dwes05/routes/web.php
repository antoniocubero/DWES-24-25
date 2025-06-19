<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MascotaControllerACM;
use App\Models\MascotaACM;
use Illuminate\Http\Request;

//Ruta a la zona pública (simplemente accediendo a / vía GET)
Route::get('/', function () {
    $mascotas = MascotaACM::where('publica','Si')->get();
    return view('principal', ['mascotasACM'=>$mascotas]);
})->name('zonapublica');

//Ruta a la zona privada (simplemente accediendo a /zonaprivada vía GET)
Route::get('/zonaprivada', function () {
    $mascotas = MascotaACM::where('user_id',Auth::id())->get();
    return view('privada.principal', ['mascotasACM'=>$mascotas]);
})->middleware('auth')->name('zonaprivada');

//Creamos una ruta nombrada (formlogin) tipo GET a '/login' que mostrará el formulario
Route::get('/login', [LoginController::class, 'mostrarFormularioLoginACM'])->name('formlogin');
//Creamos una ruta nombrada (login) tipo POST a '/login' que procesará el formulario
Route::post('/login', [LoginController::class, 'loginACM'])->name('login');
//Creamos una ruta nombrada (logout) tipo POST a '/logout' que cerrará la sesión
Route::get('/logout', [LoginController::class, 'logoutACM'])->name('logout');

//Ruta get para acceder al formulario de la mascota nueva, usamos middleware para comprobar que el usuario esta logeado, si no nos devolveria a la pagina principal
Route::get('/mascota/nueva', [MascotaControllerACM::class, 'mostrarFormularioNuevaMascotaACM'])->middleware('auth')->name('formmascotaACM');
//Ruta post para validar los datos de la macota nueva
Route::post('/mascota/nueva', [MascotaControllerACM::class, 'validarNuevaMascotaACM'])->middleware('auth')->name('nuevamascotaACM');
//Ruta post para cambiar la privacidad de la mascota
Route::post('/zonaprivada/cambiar-privacidad', [MascotaControllerACM::class, 'cambiarPrivacidadACM'])->middleware('auth')->name('cambiarprivacidadACM');
