<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;

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
}
