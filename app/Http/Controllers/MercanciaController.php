<?php

namespace App\Http\Controllers;

use App\Models\Mercancia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MercanciaController extends Controller
{
    public function Todos(Request $parametros)
    {
        $salto = ($parametros->json("posicion") - 1) * $parametros->json("limite");

        try {
            $mercancia = Mercancia::Todos(
                $parametros->json("filtro"),
                $parametros->json("orden"),
                $parametros->json("limite"),
                $salto
            );

            if ($mercancia["filas"] == 0) {
                return response()->json(
                    ["mensaje" => "No existe mercancia registrada"],
                    404
                );
            };

            return response()->json(["filas" => $mercancia["filas"], "datos" => $mercancia["datos"]], 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }

    public function Uno($id)
    {
        try {
            $mercancia = Mercancia::Uno($id);

            if (empty($mercancia)) {
                return response()->json(["mensaje" => "No se encontró la mercancia"], 404);
            };

            return response()->json(["datos" => $mercancia], 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }

    public function Crear(Request $req)
    {
        $validacion = Validator::make($req->json()->all(), [
            "producto" => "required|string",
            "presentacion" => "nullable|string",
            "cantidad" => "nullable|integer",
            "precio_unidad" => "required|numeric"
        ]);

        if ($validacion->fails()) {
            return response()->json(["error" => $validacion->errors()], 500);
        };

        try {
            if (Mercancia::Crear(
                $req->json("producto"),
                $req->json("presentacion"),
                $req->json("cantidad"),
                $req->json("precio_unidad")
            )) {
                return response()->json(["mensaje" => "Mercancia registrada correctamente"], 200);
            } else {
                return response()->json(["mensaje" => "No se pudo registrar la mercancia"], 404);
            };
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        };
    }

    public function Actualizar(Request $req, $id)
    {
        $validacion = Validator::make($req->json()->all(), [
            "producto" => "nullable|string",
            "presentacion" => "nullable|string",
            "cantidad" => "nullable|integer",
            "precio_unidad" => "nullable|numeric",
            "adquisicion" => "nullable|date",
            "estado" => "nullable|string"
        ]);

        if ($validacion->fails()) {
            return response()->json(["error" => $validacion->errors()], 404);
        };

        try {
            if (Mercancia::Editar(
                $id,
                $req->json("producto"),
                $req->json("presentacion"),
                $req->json("cantidad"),
                $req->json("precio_unidad"),
                $req->json("adquisicion"),
                $req->json("estado")
            )) {
                return response()->json(["mensaje" => "Mercancia actualizada correctamente"], 200);
            } else {
                return response()->json(["mensaje" => "No se encontró la mercancia"], 404);
            };
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }

    public function Eliminar($id)
    {
        try {
            if (Mercancia::Borrar($id)) {
                return response()->json(["mensaje" => "Mercancia eliminada correctamente"], 200);
            } else {
                return response()->json(["mensaje" => "No se encontró la mercancia"], 404);
            };
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }
}
