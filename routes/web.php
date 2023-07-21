<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaqueteController;
use App\Http\Controllers\LoteController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/IngresarPaquete', function () {
    return view('ingresarPaquete');
});



Route::get('/almacen', function(){
    return view ('almacen');
});

Route::get('/Paquetes', function () {
    $response = Http::post('localhost:8000/api/ListaPaquetes'); // Esto es un intento de mostrar en una vista, no funca 
    $Paquetes = $response->json();
    
    return view('almacen', ['paquete' => $Paquetes]);
});

Route::get('/ListaPaquetes', [PaqueteController::class, "MostrarTodosLosPaquetes"]);

route::get('/MostrarPaquete/{d}', [PaqueteController::class, "MostrarMiPaquete"]);

Route::post('/IngresarUnPaquete', [PaqueteController::class, "IngresarUnPaquete"]);

Route::put("/Modificar/{d}", [PaqueteController::class, "Modificar"]);

Route::delete("/eliminar/{d}",[PaqueteController::class,"Eliminar"]);

Route::get('/ListarLotes', [LoteController::class, "MostrarTodosLosLotes"]);

Route::get('IngresarLote', [LoteController::class, "IngresarUnLote"]);

Route::get('/MostrarLote/{d}', [LoteController::class, "MostrarUnLote"]); 

Route::delete('/EliminarLote/{d}', [LoteController::class, "Eliminar"]);