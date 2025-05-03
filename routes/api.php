<?php

use App\Http\Controllers\ActivosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Activos
Route::get("/activos", [ActivosController::class, "Listar"]);
Route::post("/activos", [ActivosController::class, "Registrar"]);
