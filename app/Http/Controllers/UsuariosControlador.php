<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Roles;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UsuariosControlador extends Controller
{
    public function Informacion($usuario)
    {
        try {
            $usuario = Usuarios::with(["cliente", "role"])->find($usuario);

            if (is_null($usuario)) {
                return response()->json(["Validacion" => "El cliente no existe"], 400);
            };

            $resultado = [
                "usuario" => $usuario->usuario,
                "correo" => $usuario->correo,
                "rol" => $usuario->role->rol,
                "estadousuario" => ($usuario->estado == "A") ? "Activo" : "Desactivado",
                "usuariocreado" => $usuario->creado,
                "usuarioactualizado" => $usuario->actualizacion,
                "cedula" => $usuario->cliente->cedula,
                "nombre" => $usuario->cliente->nombre,
                "apellido" => $usuario->cliente->apellido,
                "nacimiento" => $usuario->cliente->nacimiento,
                "telefono" => $usuario->cliente->telefono,
                "estadocliente" => ($usuario->cliente->estado == "A") ? "Activo" : "Desactivo",
                "clientecreado" => $usuario->cliente->creado,
                "clienteactualizado" => $usuario->cliente->actualizado
            ];

            return response()->json(["datos" => $resultado], 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }

    public function Listado_Cliente($pagina)
    {
        try {
            $validacion = Validator::make(["pagina" => $pagina], ["pagina" => "required|integer"]);

            if ($validacion->fails()) {
                return response()->json(["validacion" => $validacion->errors()], 400);
            };

            $lista = Usuarios::with("cliente")->paginate(6, ["*"], "pagina", $pagina);

            if ($lista->isEmpty()) {
                return response()->json(["mensaje" => "No hay clientes registrados"], 200);
            };

            $resultado = $lista->map(function ($usuario) {
                return [
                    "id" => $usuario->id,
                    "usuario" => $usuario->usuario,
                    "correo" => $usuario->correo,
                    "cedula" => $usuario->cliente->cedula,
                    "nombre" => $usuario->cliente->nombre,
                    "apellido" => $usuario->cliente->apellido
                ];
            });

            return response()->json(["paginacion" => [
                "pagina_actual" => $lista->currentPage(),
                "total" => $lista->total(),
                "ultima_pagina" => $lista->lastPage()
            ], "datos" => $resultado], 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }

    public function Select_Roles()
    {
        try {
            $roles = Roles::all("id", "rol");
            return response()->json(["datos" => $roles], 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }

    public function Crear_Cliente(Request $req)
    {
        try {
            $validacion = Validator::make($req->json()->all(), [
                "cedula" => "required|string|unique:clientes,cedula",
                "nombre" => "required|string",
                "apellido" => "required|string",
                "nacimiento" => "required|date",
                "telefono" => "nullable|string",
                "nombreusuario" => "required|string|unique:usuarios,usuario",
                "correo" => "nullable|string|email|unique:usuarios,correo",
                "contraseña" => "required|string",
                "rol" => "required|string|in:66c74d0c-4014-11f0-b4df-84a93ea1a4c5,66cec200-4014-11f0-b4df-84a93ea1a4c5"
            ]);

            if ($validacion->fails()) {
                return response()->json(["validacion" => $validacion->errors()], 400);
            };

            $usuario = new Usuarios();
            $cod_user = Str::uuid();
            $usuario->id = $cod_user;
            $usuario->usuario = $req->json("nombreusuario");
            $usuario->correo = $req->json("correo", null);
            $usuario->contraseña = Hash::make($req->json("contraseña"));
            $usuario->rol = $req->json("rol");

            if (!$usuario->save()) {
                return response()->json(["error" => "No se pudo crear el usuario"], 500);
            };

            $cliente = new Clientes();
            $cod_client = Str::uuid();
            $cliente->id = $cod_client;
            $cliente->cedula = $req->json("cedula");
            $cliente->usuario = $cod_user;
            $cliente->nombre = $req->json("nombre");
            $cliente->apellido = $req->json("apellido");
            $cliente->nacimiento = $req->json("nacimiento");
            $cliente->telefono = $req->json("telefono", null);

            if (!$cliente->save()) {
                return response()->json(["error" => "No se pudo crear el cliente"], 500);
            };

            return response()->json(["mensaje" => "El cliente se creó correctamente"], 201);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }
}
