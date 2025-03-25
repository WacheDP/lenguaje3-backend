<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("activos", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->string("objeto", 30);
            $tabla->integer("cantidad")->default(1);
            $tabla->date("adquisicion")->default(DB::raw("CURRENT_DATE"));
            $tabla->float("precio_unidad", 2);
            $tabla->string("estado", 20);
            $tabla->date("creado")->default(DB::raw("CURRENT_DATE"));
            $tabla->date("actualizado")->default(DB::raw("CURRENT_DATE"));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("activos");
    }
};
