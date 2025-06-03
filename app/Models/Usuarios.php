<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    protected $table = "usuarios";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;

    public function cliente()
    {
        return $this->hasOne(Clientes::class, "usuario", "id");
    }

    public function role()
    {
        return $this->belongsTo(Roles::class, "rol", "id");
    }
}
