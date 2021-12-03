<?php

use App\Http\Controllers\auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout',[AuthController::class, 'logout']);

Route::resource('producto', App\Http\Controllers\ProductoController::class)->only(["index","store","update","show","destroy"]);
Route::resource('proveedor', App\Http\Controllers\ProveedorController::class)->only(["index","store","update","show","destroy"]);
Route::resource('usuario', App\Http\Controllers\UserController::class)->only(["index","store","update","show","destroy"]);
Route::resource('precio', App\Http\Controllers\PrecioController::class)->only(["index","store","update","show","destroy","proveedoresPrecios"]);
Route::resource('contenedor', App\Http\Controllers\ContenedorController::class)->only(["index","store","update","show","destroy"]);
Route::resource('envio', App\Http\Controllers\EnvioController::class)->only(["index","store","update","show","destroy"]);
Route::resource('compra', App\Http\Controllers\CompraController::class)->only(["index","store","update","show","destroy"]);
Route::post('/crearCompra',[App\Http\Controllers\CompraController::class, 'nuevaCompra']);