<?php

use App\Http\Controllers\MercanciaControlador;
use App\Http\Controllers\UsuariosControlador;
use App\Http\Controllers\VentasControlador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get("/roles", [UsuariosControlador::class, "Select_Roles"]);
Route::post("/clientes", [UsuariosControlador::class, "Crear_Cliente"]);
Route::get("/clientes/{pagina}", [UsuariosControlador::class, "Listado_Cliente"]);
Route::get("/cliente/{usuario}", [UsuariosControlador::class, "Informacion"]);
Route::post("/mercancia", [MercanciaControlador::class, "Registrar"]);
Route::get("/mercancia/{pagina}", [MercanciaControlador::class, "Lista"]);
Route::post("/ventas", [VentasControlador::class, "Comprar"]);
Route::get("/ventas/{pagina}", [VentasControlador::class, "Lista"]);
