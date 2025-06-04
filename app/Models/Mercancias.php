<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mercancias extends Model
{
    protected $table = "mercancia";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;
}
