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

            if ($usuarios["filas"] == 0) {
                return response()->json(["mensaje" => "No existen usuarios registrados"]);
            };

            return response()->json(["filas" => $usuarios["filas"], "datos" => $usuarios["datos"]], 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }

    public function Uno($id)
    {
        try {
            $usuario = Usuarios::Unico($id);

            if (empty($usuario)) {
                return response()->json(["mensaje" => "No se encontró el usuario"], 404);
            };

            return response()->json(["datos" => $usuario], 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }

    public function Crear(Request $req)
    {
        $validacion = Validator::make($req->json()->all(), [
            "nombre" => "required|string|unique:usuarios,nombre",
            "correo" => "required|email|unique:usuarios,correo",
            "contraseña" => "required|string",
            "rol" => "required|string|in:513a9541-1b9d-11f0-b7e0-84a93ea1a4c5,51408bd6-1b9d-11f0-b7e0-84a93ea1a4c5,51408dcb-1b9d-11f0-b7e0-84a93ea1a4c5,51408e42-1b9d-11f0-b7e0-84a93ea1a4c5,51408eac-1b9d-11f0-b7e0-84a93ea1a4c5,51408f15-1b9d-11f0-b7e0-84a93ea1a4c5"
        ]);

        if ($validacion->fails()) {
            return response()->json(["error" => $validacion->errors()], 500);
        };

        $crypta = Hash::make($req->json("contraseña"));

        try {
            if (Usuarios::Crear($req->json("nombre"), $req->json("correo"), $crypta, $req->json("rol"))) {
                return response()->json(["mensaje" => "El usuario se registró correctamente"], 201);
            } else {
                return response()->json(["mensaje" => "No se pudo registrar el usuario"], 404);
            };
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }

    public function Actualizar(Request $req, $id)
    {
        $validacion = Validator::make($req->json()->all(), [
            "nombre" => "nullable|string|unique:usuarios,nombre",
            "correo" => "nullable|email|unique:usuarios,correo",
            "rol" => "nullable|string|in:513a9541-1b9d-11f0-b7e0-84a93ea1a4c5,51408bd6-1b9d-11f0-b7e0-84a93ea1a4c5,51408dcb-1b9d-11f0-b7e0-84a93ea1a4c5,51408e42-1b9d-11f0-b7e0-84a93ea1a4c5,51408eac-1b9d-11f0-b7e0-84a93ea1a4c5,51408f15-1b9d-11f0-b7e0-84a93ea1a4c5",
            "estado" => "nullable|string|in:Habilitado,Deshabilitado"
        ]);

        if ($validacion->fails()) {
            return response()->json(["error" => $validacion->errors()], 404);
        };

        try {
            if (Usuarios::Editar(
                $id,
                $req->json("nombre"),
                $req->json("correo"),
                $req->json("rol"),
                $req->json("estado")
            )) {
                return response()->json(["mensaje" => "El usuario se actualizó correctamente"], 200);
            } else {
                return response()->json(["mensaje" => "No se pudo actualizar el usuario"], 404);
            };
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }

    public function Eliminar($id)
    {
        try {
            if (Usuarios::Borrar($id)) {
                return response()->json(["mensaje" => "Usuario eliminado correctamente"], 200);
            } else {
                return response()->json(["mensaje" => "No se encontró el usuario"], 404);
            };
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }

    public function Login(Request $req)
    {
        $validacion = Validator::make($req->json()->all(), [
            "id" => "required|string",
            "contraseña" => "required|string"
        ]);

        if ($validacion->fails()) {
            return response()->json(["error" => $validacion->errors()], 400);
        }

        try {
            $login = Usuarios::InicioSesion($req->json("id"));

            if (empty($login)) {
                return response()->json(["mensaje" => "El correo o nombre de usuario es incorrecto"], 404);
            }

            if (Hash::check($req->json("contraseña"), $login[0]->contraseña)) {
                return response()->json(["mensaje" => "Inicio de sesión exitoso"], 200);
            } else {
                return response()->json(["mensaje" => "La contraseña es incorrecta"], 401);
            }
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }
}
