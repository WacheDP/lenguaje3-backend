<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientesController extends Controller
{
    public function Listar(Request $req)
    {
        $validacion = Validator::make($req->json()->all(), [
            "limite" => "required|integer",
            "orden" => "required|string|in:desc,asc"
        ]);

        if ($validacion->fails()) {
            return response()->json(["error" => $validacion->errors()], 500);
        };

        $clientes = Clientes::with("usuario:id,usuario")
            ->select("id", "cedula", "nombre", "apellido", "estado", "creado", "actualizado", "usuario")
            ->orderby("id", $req->json("orden"))
            ->paginate($req->json("limite"));

        if (count($clientes) == 0) {
            response()->json(["mensaje" => "No hay clientes registrados"], 200);
        };

        return response()->json(["datos" => $clientes], 200);
    }

    public function Busqueda($id)
    {
        $cliente = Clientes::find($id);

        if (empty($cliente)) {
            return response()->json(["mensaje" => "Cliente no encontrado"], 404);
        };

        return response()->json(["cliente" => $cliente], 200);
    }

    public function Registrar() {}

    public function Actualizar() {}

    public function Eliminar() {}
}
