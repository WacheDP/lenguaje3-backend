<?php

namespace App\Http\Controllers;

use App\Models\Activos;
use Illuminate\Http\Request;

class ActivosController extends Controller
{
    public function Todos()
    {
        try {
            $activos = Activos::all();
            return response()->json($activos);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th], 500);
        }
    }
}
