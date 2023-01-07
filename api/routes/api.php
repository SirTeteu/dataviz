<?php

use Illuminate\Http\Request;

use App\Http\Controllers\EstadoController;
use App\Http\Controllers\RefugiadoController;
use App\Http\Controllers\RegiaoController;

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

Route::get('estados', [EstadoController::class, "index"]);
Route::get('refugiados', [RefugiadoController::class, "index"]);
Route::get('regiao/estados', [RegiaoController::class, "indexEstados"]);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
