<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivosController;

Route::get('/', function () {
    return view('welcome');
});

//Activos
Route::get("/activos", [ActivosController::class, "Todos"]);
