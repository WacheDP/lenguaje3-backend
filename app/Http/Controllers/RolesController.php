<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function Todos()
    {
        try {
            $roles = Roles::Todos();
            return response()->json(["datos" => $roles], 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }
}
