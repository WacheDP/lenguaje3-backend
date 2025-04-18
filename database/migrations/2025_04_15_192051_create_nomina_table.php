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
        Schema::create("nomina1", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("empleado", 36);
            $tabla->foreign("empleado")->references("id")->on("personal");
            $tabla->date("fecha")->default(DB::raw("CURRENT_DATE"));
            $tabla->float("monto", 2);
            $tabla->float("deudas", 2);
            $tabla->float("total", 2);
            $tabla->string("estado", 20)->default("Por pagar");
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });

        Schema::create("nomina2", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("empleado", 36);
            $tabla->foreign("empleado")->references("id")->on("personal");
            $tabla->date("fecha")->default(DB::raw("CURRENT_DATE"));
            $tabla->integer("horas");
            $tabla->float("monto", 2);
            $tabla->float("deudas", 2);
            $tabla->float("total", 2);
            $tabla->string("estado", 20)->default("Por pagar");
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("nomina1");
        Schema::dropIfExists("nomina2");
    }
};
