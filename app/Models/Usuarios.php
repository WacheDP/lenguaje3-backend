<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    protected $table = "usuarios";
    protected $primaryKey = "id";
    public $incrementing = false;
    protected $keyType = "string";
    public $timestamps = false;

    public function clientes()
    {
        return $this->hasMany(Clientes::class, "usuario", "id");
    }
}
