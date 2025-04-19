<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Usuarios extends Model
{
    public static function Todos($filtro, $orden, $limite, $salto)
    {
        $cadena = "SELECT u.id, u.nombre, u.correo, u.estado, u.creado, u.actualizado, r.rol ";
        $cadena .= "FROM usuarios AS u INNER JOIN roles AS r ON u.rol = r.id ";
        $valores = [];

        if (!empty($filtro)) {
            $cadena .= "WHERE u.nombre LIKE ? AND u.correo LIKE ? ";
            $valores[] = "%$filtro%";
            $valores[] = "%$filtro%";
        };

        $total = count(DB::select($cadena, $valores));

        $cadena .= "ORDER BY u.nombre $orden LIMIT ? OFFSET ? ";
        $valores[] = $limite;
        $valores[] = $salto;

        $consultas = DB::select($cadena, $valores);

        return ["filas" => $total, "datos" => $consultas];
    }

    public static function Unico($id)
    {
        $cadena = "SELECT u.id, u.nombre, u.correo, r.rol, u.estado, u.creado, u.actualizado ";
        $cadena .= "FROM usuarios AS u INNER JOIN roles AS r ON u.rol = r.id ";
        $cadena .= "WHERE u.id = ?";

        return DB::select($cadena, [$id]);
    }

    public static function Crear($usuario, $email, $clave, $nivel)
    {
        return DB::insert(
            "INSERT INTO usuarios(nombre, correo, contraseña, rol) VALUES (?, ?, ?, ?)",
            [$usuario, $email, $clave, $nivel]
        );
    }

    public static function Editar($id, $nombre, $correo, $rol, $estado)
    {
        $cadena = "UPDATE usuarios AS u SET ";
        $valores = [];

        if (!empty($nombre)) {
            $cadena .= "u.nombre = ?, ";
            $valores[] = $nombre;
        };

        if (!empty($correo)) {
            $cadena .= "u.correo = ?, ";
            $valores[] = $correo;
        };

        if (!empty($rol)) {
            $cadena .= "u.rol = ?, ";
            $valores[] = $rol;
        };

        if (!empty($estado)) {
            $cadena .= "u.estado = ?, ";
            $valores[] = $estado;
        };

        $cadena .= "u.actualizado = CURRENT_TIMESTAMP WHERE u.id = ?";
        $valores[] = $id;

        return DB::update($cadena, $valores);
    }

    public static function Borrar($id)
    {
        return DB::delete("DELETE FROM usuarios WHERE id = ?", [$id]);
    }

    public static function InicioSesion($usuario)
    {
        $cadena = "SELECT u.contraseña FROM usuarios AS u WHERE u.nombre = ? OR u.correo = ?";
        $valores = [$usuario, $usuario];

        return DB::select($cadena, $valores);
    }
}
