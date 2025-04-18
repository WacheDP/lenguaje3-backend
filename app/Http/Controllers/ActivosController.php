<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activos;
use Illuminate\Support\Facades\Validator;

class ActivosController extends Controller
{
    public function Todos(Request $req)
    {
        $offset = ($req->json("posicion") - 1) * $req->json("limite");

        try {
            $activos = Activos::Todos($req->json("filtro"), $req->json("limite"), $offset, $req->json("orden"));

            if ($activos["filas"] == 0) {
                return response()->json(["mensaje" => "No existen activos registrados"], 404);
            };

            return response()->json([
                "filas" => $activos["filas"],
                "datos" => $activos["datos"]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }

    public function Uno($id)
    {
        try {
            $activo = Activos::Uno($id);

            if (!empty($activo)) {
                return response()->json(["datos" => $activo[0]], 200);
            } else {
                return response()->json(["mensaje" => "no se encontró el activo"], 404);
            };
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }

    public function Crear(Request $req)
    {
        $validacion = Validator::make($req->json()->all(), [
            "objeto" => "required|string",
            "cantidad" => "nullable|integer",
            "precio_unidad" => "required|numeric"
        ]);

        if ($validacion->fails()) {
            return response()->json(["error" => $validacion->errors()], 404);
        };

        try {
            if (Activos::Crear($req->json("objeto"), $req->json("cantidad"), $req->json("precio_unidad"))) {
                return response()->json(["mensaje" => "Activo registrado correctamente"], 201);
            } else {
                return response()->json(["mensaje" => "No se pudo registrar el activo"], 404);
            };
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }

    public function Actualizar(Request $req, $id)
    {
        $validacion = validator::make($req->json()->all(), [
            "objeto" => "nullable|string",
            "cantidad" => "nullable|integer",
            "adquisicion" => "nullable|date",
            "precio_unidad" => "nullable|numeric",
            "estado" => "nullable|string"
        ]);

        if ($validacion->fails()) {
            return response()->json(["error" => $validacion->errors()], 404);
        };

        try {
            if (Activos::Editar(
                $id,
                $req->json("objeto"),
                $req->json("cantidad"),
                $req->json("adquisicion"),
                $req->json("precio_unidad"),
                $req->json("estado")
            )) {
                return response()->json(["mensaje" => "Activo actualizado correctamente"], 200);
            } else {
                return response()->json(["mensaje" => "No se encontró el activo"], 404);
            };
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }

    public function Eliminar($id)
    {
        try {
            if (Activos::Borrar($id)) {
                return response()->json(["mensaje" => "Activo eliminado correctamente"], 200);
            } else {
                return response()->json(["mensaje" => "No se encontró el activo"], 404);
            };
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }
}
