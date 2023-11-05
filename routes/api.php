<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaqueteController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\Paquete_Contiene_LoteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\Camion_Lleva_LoteController;
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

Route::post("/paquete", [PaqueteController::class, "ComprobarDatosPaqueteAIngresar"]);

Route::put("/paquete/{d}", [PaqueteController::class, "ComprobarDatosPaqueteAModificar"]);

Route::delete("/paquete/{d}", [PaqueteController::class, "Eliminar"]);

Route::patch("/paquete/{d}", [PaqueteController::class, "restore"]);


Route::get('/lote', [LoteController::class, "MostrarTodosLosLotes"]);

Route::post('/lote', [LoteController::class, "IngresarUnLote"]);

Route::get('/lote/{d}', [LoteController::class, "MostrarUnLote"]);

Route::delete('/lote/{d}', [LoteController::class, "Eliminar"]);

Route::patch('/lote/{d}', [LoteController::class, "Recuperar"]);


Route::get('/paquete-lote', [Paquete_Contiene_LoteController::class, "MostrarTodosLosLotes"]);

Route::post('/paquete-lote', [Paquete_Contiene_LoteController::class, "ComprobarDatosLote"]);

Route::get('/paquete-lote/{d}', [Paquete_Contiene_LoteController::class, "MostrarUnLote"]);

Route::delete('/paquete-lote/{d}', [Paquete_Contiene_LoteController::class, "Eliminar"]);

Route::put('/paquete-lote/{d}', [Paquete_Contiene_LoteController::class, "Modificar"]);


Route::get('/producto', [ProductoController::class, "MostrarTodosLosProductos"]);

route::get('/producto/{d}', [ProductoController::class, "MostrarUnproducto"]);

Route::post("/producto", [ProductoController::class, "ComprobarDatosProducto"]);

Route::put("/producto/{d}", [ProductoController::class, "Modificar"]);

Route::delete("/producto/{d}", [ProductoController::class, "Eliminar"]);

Route::patch("/producto/{d}", [ProductoController::class, "restore"]);


Route::get('/loteCamion', [Camion_Lleva_LoteController::class, "MostrarTodosLosCamionesConLotes"]);

route::get('/loteCamion/{d}', [Camion_Lleva_LoteController::class, "MostrarUnCamionConSusLotes"]);

Route::post("/loteCamion", [Camion_Lleva_LoteController::class, "IngresarUnLoteAUnCamion"]);

Route::put("/loteCamion/{d}", [Camion_Lleva_LoteController::class, "ModificarUnLoteEnUnCamion"]);

Route::delete("/loteCamion/{d}", [Camion_Lleva_LoteController::class, "Eliminar"]);

Route::patch("/loteCamion/{d}", [Camion_Lleva_LoteController::class, "restore"]);