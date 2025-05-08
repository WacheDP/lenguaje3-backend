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
        $validacion = Validator::make($req->json()->all(), [
            "limite" => "required|integer",
            "orden" => "required|in:desc,asc"
        ]);

        if ($validacion->fails()) {
            return response()->json(["error" => $validacion->errors()], 422);
        };

        $activos = Activos::orderBy("objeto", $req->json("orden"))
            ->paginate($req->json("limite"));

        if (count($activos) == 0) {
            response()->json(["mensaje" => "No hay activos registrados"], 200);
        };

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

    public function Actualizar(Request $req, $id)
    {
        $validacion = Validator::make($req->json()->all(), [
            "objeto" => "nullable|string",
            "cantidad" => "nullable|integer",
            "adquisicion" => "nullable|date",
            "estado" => "nullable|string|in:En buen estado,En mal estado"
        ]);

        if ($validacion->fails()) {
            return response()->json(["error" => $validacion->errors()], 422);
        };

        $activo = Activos::find($id);

        if (empty($activo)) {
            return response()->json(["mensaje" => "Activo no encontrado"], 404);
        };

        if (!empty($req->json("objeto"))) {
            $activo->objeto = $req->json("objeto");
        };

        if (!empty($req->json("cantidad"))) {
            $activo->cantidad = $req->json("cantidad");
        };

        if (!empty($req->json("adquisicion"))) {
            $activo->adquisicion = $req->json("adquisicion");
        };

        if (!empty($req->json("estado"))) {
            $activo->estado = $req->json("estado");
        };

        $activo->save();

        return response()->json([
            "mensaje" => "Activo actualizado correctamente",
            "activo" => $activo
        ], 200);
    }

    public function Eliminar($id)
    {
        $activo = Activos::find($id);

        if (empty($activo)) {
            return response()->json(["mensaje" => "Activo no encontrado"], 404);
        };

        $activo->delete();

        return response()->json(["mensaje" => "Activo eliminado correctamente"], 200);
    }
}
