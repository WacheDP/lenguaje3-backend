<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Activos extends Model
{
    public static function Todos($filtro, $limite, $offset, $orden)
    {
        $cadena = "SELECT * FROM activos AS a ";
        $valores = [];

        if (!empty($filtro)) {
            $cadena .= "WHERE a.objeto LIKE ? OR a.adquisicion LIKE ? ";
            $valores[] = "%$filtro%";
            $valores[] = "%$filtro%";
        };

        $cadena .= "ORDER BY a.objeto $orden ";

        $total = count(DB::select($cadena, $valores));

        $cadena .= "LIMIT ? OFFSET ?";
        $valores[] = $limite;
        $valores[] = $offset;

        $consultas = DB::select($cadena, $valores);

        return ["filas" => $total, "datos" => $consultas];
    }

    public static function Uno($id)
    {
        $activo = DB::select(
            "SELECT * FROM activos as a WHERE a.id = ?",
            [$id]
        );

        return $activo;
    }

    public static function Crear($item, $numero, $precio)
    {
        if (!empty($numero)) {
            $insert = DB::insert(
                "INSERT INTO activos(objeto, cantidad, precio_unidad) VALUES (?, ?, ?)",
                [$item, $numero, $precio]
            );
        } else {
            $insert = DB::insert(
                "INSERT INTO activos(objeto, precio_unidad) VALUES (?, ?)",
                [$item, $precio]
            );
        };

        return $insert;
    }

    public static function Editar($id, $item, $numero, $fecha, $precio, $estado)
    {
        $cadena = "UPDATE activos AS a SET ";
        $valores = [];

        if (!empty($item)) {
            $cadena .= "a.objeto = ?, ";
            $valores[] = $item;
        };

        if (!empty($numero)) {
            $cadena .= "a.cantidad = ?, ";
            $valores[] = $numero;
        };

        if (!empty($fecha)) {
            $cadena .= "a.adquisicion = ?, ";
            $valores[] = $fecha;
        };

        if (!empty($precio)) {
            $cadena .= "a.precio_unidad = ?, ";
            $valores[] = $precio;
        };

        if (!empty($estado)) {
            $cadena .= "a.estado = ?, ";
            $valores[] = $estado;
        };

        $cadena .= "a.actualizado = CURRENT_TIMESTAMP WHERE a.id = ?";
        $valores[] = $id;

        return DB::update($cadena, $valores);
    }

    public static function Borrar($id)
    {
        return DB::delete("DELETE FROM activos WHERE id = ?", [$id]);
    }

    public static function Buscar() {}
}
