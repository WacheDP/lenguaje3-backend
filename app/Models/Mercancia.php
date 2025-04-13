<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mercancia extends Model
{
    public static function Todos($filtro, $orden, $limite, $salto)
    {
        $cadena = "SELECT * FROM mercancia AS m ";
        $valores = [];

        if (!empty($filtro)) {
            $cadena .= "WHERE m.producto LIKE ? AND m.adquisicion LIKE ? ";
            $valores[] = "%$filtro%";
            $valores[] = "%$filtro%";
        };

        $total = count(DB::select($cadena, $valores));

        $cadena .= "ORDER BY m.producto $orden LIMIT ? OFFSET ?";
        $valores[] = $limite;
        $valores[] = $salto;

        $mercancia = DB::select($cadena, $valores);

        return ["filas" => $total, "datos" => $mercancia];
    }

    public static function Uno($id)
    {
        return DB::select("SELECT * FROM mercancia AS m WHERE m.id = ?", [$id]);
    }

    public static function Crear($item, $estado, $numero, $precio)
    {
        $campos = [];
        $valores = [];
        $campos[] = "producto";
        $valores[] = $item;

        if (!empty($estado)) {
            $campos[] = "presentacion";
            $valores[] = $estado;
        };

        if (!empty($numero)) {
            $campos[] = "cantidad";
            $valores[] = $numero;
        };

        $campos[] = "precio_unidad";
        $valores[] = $precio;

        $cadena = "INSERT INTO mercancia(" . implode(", ", $campos) . ") ";
        $cadena .= "VALUES (" . implode(", ", array_fill(0, count($campos), "?")) . ")";

        return DB::insert($cadena, $valores);
    }

    public static function Editar($id, $item, $tipo, $numero, $precio, $fecha, $estado)
    {
        $cadena = "UPDATE mercancia AS m SET ";
        $valores = [];

        if (!empty($item)) {
            $cadena .= "m.producto = ?, ";
            $valores[] = $item;
        };

        if (!empty($tipo)) {
            $cadena .= "m.presentacion = ?, ";
            $valores[] = $tipo;
        };

        if (!empty($numero)) {
            $cadena .= "m.cantidad = ?, ";
            $valores[] = $numero;
        };

        if (!empty($precio)) {
            $cadena .= "m.precio_unidad = ?, ";
            $valores[] = $precio;
        };

        if (!empty($fecha)) {
            $cadena .= "m.adquisicion = ?, ";
            $valores[] = $fecha;
        };

        if (!empty($estado)) {
            $cadena .= "m.estado = ?, ";
            $valores[] = $estado;
        };

        $cadena .= "m.actualizado = CURRENT_TIMESTAMP WHERE m.id = ?";
        $valores[] = $id;

        return DB::update($cadena, $valores);
    }

    public static function Borrar($id)
    {
        return DB::delete("DELETE FROM mercancia WHERE id = ?", [$id]);
    }
}
