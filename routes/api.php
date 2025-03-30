<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivosController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Activos
Route::get("/activos", [ActivosController::class, "Todos"]);
Route::get("/activos/{id}", [ActivosController::class, "Uno"]);
Route::post("/activos", [ActivosController::class, "Crear"]);
Route::put("/activos/{id}", [ActivosController::class, "Actualizar"]);
Route::delete("/activos/{id}", [ActivosController::class, "Eliminar"]);
