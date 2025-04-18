<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    public function Todos(Request $req)
    {
        try {
            $clientes = Clientes::Todos(
                $req->json("filtro"),
                $req->json("orden"),
                $req->json("limite"),
                ($req->json("posicion") - 1) * $req->json("limite")
            );

            if ($clientes["filas"] == 0) {
                return response()->json(["mensaje" => "No existen clientes registrados"], 404);
            };

            return response()->json(["filas" => $clientes["filas"], "datos" => $clientes["datos"]], 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }
}
