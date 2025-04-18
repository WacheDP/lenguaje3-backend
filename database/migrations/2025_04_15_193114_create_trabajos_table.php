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
        Schema::create("trabajos", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->string("tipo", 20);
            $tabla->float("paga", 2);
            $tabla->date("inicio");
            $tabla->date("final");
            $tabla->string("estado", 20)->default("Por pagar");
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });

        Schema::create("detalle_trabajo_empleado", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("trabajo", 36);
            $tabla->foreign("trabajo")->references("id")->on("trabajos");
            $tabla->char("empleado", 36);
            $tabla->foreign("empleado")->references("id")->on("personal");
            $tabla->boolean("asistencia");
        });

        Schema::create("detalle_trabajo_activo", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("trabajo", 36);
            $tabla->foreign("trabajo")->references("id")->on("trabajos");
            $tabla->char("activo", 36);
            $tabla->foreign("activo")->references("id")->on("activos");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trabajos');
        Schema::dropIfExists('detalle_trabajo_empleado');
        Schema::dropIfExists('detalle_trabajo_activo');
    }
};
