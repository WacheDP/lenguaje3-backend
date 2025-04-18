<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
            $tabla->string("estado", 20)->default("En buen estado");
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });

        Schema::create("reparaciones", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("activo", 36);
            $tabla->foreign("activo")->references("id")->on("activos");
            $tabla->integer("cantidad");
            $tabla->float("precio", 2);
            $tabla->date("fecha")->default(DB::raw("CURRENT_DATE"));
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activos');
        Schema::dropIfExists("reparaciones");
    }
};
