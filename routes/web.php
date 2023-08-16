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



