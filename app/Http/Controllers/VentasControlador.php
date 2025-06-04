<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Detalles_Venta;
use App\Models\Mercancias;
use App\Models\Ventas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class VentasControlador extends Controller
{
    public function Lista($pagina)
    {
        try {
            $validacion = Validator::make(["pagina" => $pagina], ["pagina" => "required|integer"]);

            $ventas = Ventas::paginate(6, ["*"], "pagina", $pagina);

            if (is_null($ventas)) {
                return response()->json(["mensaje" => "No hay ventas registradas"]);
            };

            return response()->json(["paginacion" => [
                "total" => $ventas->total(),
                "pagina_actual" => $ventas->currentPage(),
                "ultima_pagina" => $ventas->lastPage()
            ], "datos" => $ventas->items()], 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }

    public function Comprar(Request $req)
    {
        try {
            $validar_venta = Validator::make($req->json()->all(), [
                "cliente" => "required|string",
                "fecha" => "required|date",
                "detalles" => "required|array"
            ]);

            if ($validar_venta->fails()) {
                return response()->json(["validacion" => $validar_venta->errors()], 400);
            };

            $perso = Clientes::find($req->json("cliente"));

            if (is_null($perso)) {
                return response()->json(["validacion" => "El cliente no existe"], 400);
            };

            $total = 0.0;
            $detalles = $req->json("detalles");

            if (is_null($detalles) || !is_array($detalles)) {
                return response()->json(["validacion" => "Los detalles de la venta son requeridos"], 400);
            }

            foreach ($detalles as $detalle) {
                $validar_detalle = Validator::make($detalle, [
                    "producto" => "required|string",
                    "cantidad" => "required|integer"
                ]);

                if ($validar_detalle->fails()) {
                    return response()->json(["validacion" => $validar_detalle->errors()], 400);
                }

                $merca = Mercancias::find($detalle['producto']);

                if (is_null($merca)) {
                    return response()->json(["validacion" => "El producto no existe"], 400);
                }

                $total += $merca->precio_unidad * $detalle['cantidad'];
            }

            $codigo_venta = Str::uuid();
            $venta = new Ventas();
            $venta->id = $codigo_venta;
            $venta->cliente = $req->json("cliente");
            $venta->total = $total;
            $venta->fecha = $req->json("fecha");
            $venta->save();

            foreach ($req->json("detalles") as $det) {
                $merca = Mercancias::find($det["producto"]);

                if (is_null($merca)) {
                    return response()->json(["validacion" => "El producto no existe"], 400);
                };

                $codigo_detalle = Str::uuid();
                $detalle = new Detalles_Venta();
                $detalle->id = $codigo_detalle;
                $detalle->venta = $codigo_venta;
                $detalle->producto = $det["producto"];
                $detalle->cantidad = $det["cantidad"];
                $detalle->precio = $merca->precio_unidad * $det["cantidad"];
                $merca->cantidad = $merca->cantidad - $det["cantidad"];
                $detalle->save();
                $merca->save();
            }

            return response()->json(["mensaje" => "Se registró la venta correctamente"], 201);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }
}
