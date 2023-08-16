<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaqueteController;
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

Route::get('/paquetes', [PaqueteController::class, "MostrarTodosLosPaquetes"]);

route::get('/paquete/{d}', [PaqueteController::class, "MostrarMiPaquete"]);

Route::post('/ingresarpaquete', [PaqueteController::class, "IngresarUnPaquete"]);

Route::put("/paquete/{d}", [PaqueteController::class, "Modificar"]);

Route::delete("/paquete/{d}",[PaqueteController::class,"Eliminar"]);

Route::get('/lotes', [LoteController::class, "MostrarTodosLosLotes"]);

Route::get('ingresarlote', [LoteController::class, "IngresarUnLote"]);

Route::get('/lote/{d}', [LoteController::class, "MostrarUnLote"]); 

Route::delete('/lote/{d}', [LoteController::class, "Eliminar"]);

Route::put('/lote/{d}', [LoteController::class, "Modificar"]);