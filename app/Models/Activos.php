<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activos extends Model
{
    protected $table = "activos";
    protected $primaryKey = "id";
    public $incrementing = false;
    protected $keyType = "string";
    public $timestamps = false;
}
