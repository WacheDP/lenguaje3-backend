<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Clientes extends Model
{
    public static function Todos($filtro, $orden, $limite, $salto)
    {
        $cadena = "SELECT * FROM clientes AS c ";
        $valores = [];

        if (!empty($filtro)) {
            $cadena .= "WHERE c.cedula LIKE ? AND c.nombre LIKE ? AND c.apellido LIKE ? ";
            $valores[] = "%$filtro%";
            $valores[] = "%$filtro%";
            $valores[] = "%$filtro%";
        };

        $filas = count(DB::select($cadena, $valores));

        if ($filas == 0) {
            return ["filas" => $filas, "datos" => null];
        };

        $cadena .= "ORDER BY c.apellido $orden ";
        $cadena .= "LIMIT ? OFFSET ? ";
        $valores[] = $limite;
        $valores[] = $salto;

        $resultados = DB::select($cadena, $valores);

        return ["filas" => $filas, "datos" => $resultados];
    }
}
