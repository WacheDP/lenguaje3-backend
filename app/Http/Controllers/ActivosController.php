<?php

namespace App\Http\Controllers;

use App\Models\Activos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ActivosController extends Controller
{
    public function Listar(Request $req)
    {
        $busqueda = $req->json("filtro", "");
        $limite = $req->json("limite", 10);

        $activos = Activos::where("objeto", "like", "%$busqueda%")
            ->orderBy("objeto", $req->json("orden"))->paginate($limite);

        return response()->json(["datos" => $activos], 200);
    }

    public function Registrar(Request $req)
    {
        $validacion = Validator::make($req->json()->all(), [
            "objeto" => "required|string",
            "cantidad" => "required|integer"
        ]);

        if ($validacion->fails()) {
            return response()->json(["error" => $validacion->errors()], 422);
        };

        date_default_timezone_set("America/Caracas");

        $activo = new Activos();
        $activo->id = (string) Str::uuid();
        $activo->objeto = $req->json("objeto");
        $activo->cantidad = $req->json("cantidad");
        $activo->adquisicion = date("Y-m-d");
        $activo->save();

        return response()->json([
            "mensaje" => "Activo registrado correctamente",
            "datos" => $activo
        ], 201);
    }
}
