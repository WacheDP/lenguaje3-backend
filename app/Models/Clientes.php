<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = "clientes";
    protected $primaryKey = "id";
    public $incrementing = false;
    protected $keyType = "string";
    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, "usuario", "id");
    }
}
