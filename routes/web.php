<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaqueteController;
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

Route::get('/BuscarPaquete', function () {
    return view('buscarPaquete');
});

Route::get('/almacen', function(){
    return view ('almacen');
});

Route::get('/Paquetes', function () {
    $response = Http::post('localhost:8000/api/ListaPaquetes'); // Replace with your API endpoint
    $Paquetes = $response->json();
    
    return view('almacen', ['paquete' => $Paquetes]);
});

Route::get('/ListaPaquetes', [PaqueteController::class, "MostrarTodosLosPaquetes"]);

route::get('/MostrarPaquete/{d}', [PaqueteController::class, "MostrarMiPaquete"]);

Route::post('/IngresarUnPaquete', [PaqueteController::class, "IngresarUnPaquete"]);


Route::delete("/eliminar/{d}",[PaqueteController::class,"Eliminar"]);