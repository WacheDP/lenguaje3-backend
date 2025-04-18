<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuariosController extends Controller
{
    public function Todos(Request $req)
    {
        $salto = ($req->json("posicion") - 1) * $req->json("limite");

        try {
            $usuarios = Usuarios::Todos(
                $req->json("filtro"),
                $req->json("orden"),
                $req->json("limite"),
                $salto
            );

            if ($usuarios["filas" == 0]) {
                return response()->json(["mensaje" => "No existen usuarios registrados"]);
            };

            return response()->json(["filas" => $usuarios["filas"], "datos" => $usuarios["datos"]], 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }

    public function Crear(Request $req)
    {
        $validacion = Validator::make($req->json()->all(), [
            "nombre" => "required|string|unique",
            "correo" => "required|email|unique",
            "contraseña" => "required|string",
            "rol" => "required|string"
        ]);

        if ($validacion->fails()) {
            return response()->json(["error" => $validacion->errors()], 500);
        };

        $crypta = Hash::make($req->json("contraseña"));

        try {
            if (Usuarios::Crear($req->json("nombre"), $req->json("correo"), $crypta, $req->json("rol"))) {
                return response()->json(["mensaje" => "El usuario se registró correctamente"], 200);
            } else {
                return response()->json(["mensaje" => "No se pudo registrar el usuario"], 404);
            };
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }
}
