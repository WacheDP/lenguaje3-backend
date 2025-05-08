<?php

use App\Http\Controllers\ActivosController;
use App\Http\Controllers\ClientesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Activos
Route::get("/activos", [ActivosController::class, "Listar"]);
Route::post("/activos", [ActivosController::class, "Registrar"]);
Route::put("/activos/{id}", [ActivosController::class, "Actualizar"]);
Route::delete("/activos/{id}", [ActivosController::class, "Eliminar"]);

//Clientes
Route::get("/clientes", [ClientesController::class, "Listar"]);
Route::get("/clientes/{id}", [ClientesController::class, "Busqueda"]);
