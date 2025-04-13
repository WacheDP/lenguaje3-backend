<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Usuarios extends Model
{
    public static function Todos($filtro, $orden, $limite, $salto)
    {
        $cadena = "SELECT u.id, u.nombre, u.correo, u.estado, u.creado, u.actualizado FROM usuarios AS u ";
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
}
