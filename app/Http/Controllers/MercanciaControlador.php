<?php

namespace App\Http\Controllers;

use App\Models\Mercancias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MercanciaControlador extends Controller
{
    public function Lista($pagina)
    {
        try {
            $validacion = Validator::make(["pagina" => $pagina], ["pagina" => "required|integer"]);

            if ($validacion->fails()) {
                return response()->json(["validacion" => $validacion->errors()], 400);
            };

            $mercancia = Mercancias::paginate(6, ["*"], "pagina", $pagina);

            if ($mercancia->isEmpty()) {
                return response()->json(["mensaje" => "No hay mercancia registrada"], 200);
            };

            return response()->json(["paginacion" => [
                "total" => $mercancia->total(),
                "ultima_pagina" => $mercancia->lastPage(),
                "pagina_actual" => $mercancia->currentPage()
            ], "datos" => $mercancia->items()], 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }

    public function Registrar(Request $req)
    {
        try {
            $validacion = Validator::make($req->json()->all(), [
                "producto" => "required|string",
                "cantidad" => "required|integer",
                "adquisicion" => "required|date",
                "precio_unidad" => "required|numeric"
            ]);

            if ($validacion->fails()) {
                return response()->json(["validacion" => $validacion->errors()], 400);
            };

            $codigo = Str::uuid();
            $producto = new Mercancias();
            $producto->id = $codigo;
            $producto->producto = $req->json("producto");
            $producto->cantidad = $req->json("cantidad");
            $producto->adquisicion = $req->json("adquisicion");
            $producto->precio_unidad = $req->json("precio_unidad");
            $producto->save();

            return response()->json(["mensaje" => "La mercancia se creó correctamente"], 201);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }
}
