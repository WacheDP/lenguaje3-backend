<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Roles extends Model
{
    public static function Todos()
    {
        return DB::select("SELECT * FROM roles");
    }
}
