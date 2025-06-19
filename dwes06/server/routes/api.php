<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiACM\Auth\LoginController;
use App\Http\Controllers\ApiACM\ACMMascotasControllerAPI;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/** Respuesta por defecto cuando no hay usuario autenticado*/
Route::get('/login', function () {
    return response()->json(["mensaje"=>"Es necesaria autenticación para acceder"],401);
})->name('login');

/** Ruta que permite a un usuario autenticado ver sus datos completos (JSON) tras autenticación.
 *  HTTP GET
 *  http://localhost:.../api/user
 */
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/** Ruta que permite a un usuario hacer login vía API. 
 *  HTTP POST
 *  http://localhost:.../api/login
 */
Route::post('/login', [LoginController::class,'doLogin']);

/** Ruta que permite a un usuario hacer logout (borrar tokens) 
 *  HTTP Cualquiera
 *  http://localhost:.../api/logout
 */
Route::any('/logout', [LoginController::class,'doLogout'])->middleware('auth:sanctum');

//Ruta para obtener todas las mascotas
Route::get('/mascotasACM', [ACMMascotasControllerAPI::class,'listarMascotasACM'])->middleware('auth:sanctum');

//Ruta para crear mascota
Route::post('/crearmascotaACM', [ACMMascotasControllerAPI::class,'crearMascotaACM'])->middleware('auth:sanctum');

//Ruta para editar una mascota
Route::put('/mascotaACM/{mascota}', [ACMMascotasControllerAPI::class,'cambiarMascotaACM'])->middleware('auth:sanctum');

//Ruta para borrar mascotas
Route::delete('/mascotaACM/{mascota}', [ACMMascotasControllerAPI::class,'borrarMascotaACM'])->middleware('auth:sanctum');
