<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalles_Venta extends Model
{
    protected $table = "detalles_venta";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;
}
