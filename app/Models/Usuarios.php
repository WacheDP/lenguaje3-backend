<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Usuarios extends Model
{
    public static function Todos($filtro, $orden, $limite, $salto)
    {
        $cadena = "SELECT u.id, u.nombre, u.correo, u.estado, u.creado, u.actualizado, r.rol ";
        $cadena .= "FROM usuarios AS u INNER JOIN roles AS r ON u.rol = r.id";
        $valores = [];

        if (!empty($filtro)) {
            $cadena .= "WHERE u.nombre LIKE ? AND u.correo LIKE ? ";
            $valores[] = "%$filtro%";
            $valores[] = "%$filtro%";
        };

        $total = count(DB::select($cadena, $valores));

        $cadena .= "ORDER BY u.nombre $orden LIMIT ? OFFSET ?";
        $valores[] = $limite;
        $valores[] = $salto;

        $consultas = DB::select($cadena, $valores);

        return ["filas" => $total, "datos" => $consultas];
    }

    public static function Crear($usuario, $email, $clave, $nivel)
    {
        return DB::insert(
            "INSERT INTO usuarios(nombre, correo, contraseña, rol) VALUES (?, ?, ?, ?)",
            [$usuario, $email, $clave, $nivel]
        );
    }
}
