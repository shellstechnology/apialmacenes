<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaqueteController;
use App\Http\Controllers\LoteController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/paquete', [PaqueteController::class, "MostrarTodosLosPaquetes"]);

route::get('/paquete/{d}', [PaqueteController::class, "MostrarMiPaquete"]);

Route::post("/paquete", [PaqueteController::class, "ComprobarDatosPaquete"]);

Route::put("/paquete/{d}", [PaqueteController::class, "Modificar"]);

Route::delete("/paquete/{d}", [PaqueteController::class, "Eliminar"]);

Route::get('/lote', [LoteController::class, "MostrarTodosLosLotes"]);

Route::post('/lote', [LoteController::class, "ComprobarDatosLote"]);

Route::get('/lote/{d}', [LoteController::class, "MostrarUnLote"]);

Route::delete('/lote/{d}', [LoteController::class, "Eliminar"]);

Route::put('/lote/{d}', [LoteController::class, "Modificar"]);
