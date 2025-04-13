<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivosController;
use App\Http\Controllers\MercanciaController;
use App\Http\Controllers\UsuariosController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Activos
Route::get("/activos", [ActivosController::class, "Todos"]);
Route::get("/activos/{id}", [ActivosController::class, "Uno"]);
Route::post("/activos", [ActivosController::class, "Crear"]);
Route::put("/activos/{id}", [ActivosController::class, "Actualizar"]);
Route::delete("/activos/{id}", [ActivosController::class, "Eliminar"]);

//Mercancia
Route::get("/mercancia", [MercanciaController::class, "Todos"]);
Route::get("/mercancia/{id}", [MercanciaController::class, "Uno"]);
Route::post("/mercancia", [MercanciaController::class, "Crear"]);
Route::put("/mercancia/{id}", [MercanciaController::class, "Actualizar"]);
Route::delete("/mercancia/{id}", [MercanciaController::class, "Eliminar"]);

//Roles

//Usuarios
Route::get("/usuarios", [UsuariosController::class, "Todos"]);

//Clientes
