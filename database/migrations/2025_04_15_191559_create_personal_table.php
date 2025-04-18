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
        Schema::create("personal", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->string("cedula", 15)->unique();
            $tabla->string("nombre", 20);
            $tabla->string("apellido", 20);
            $tabla->char("usuario", 36);
            $tabla->foreign("usuario")->references("id")->on("usuarios");
            $tabla->string("telefono", 20);
            $tabla->date("nacimiento");
            $tabla->string("nacionalidad", 3);
            $tabla->string("genero", 1);
            $tabla->string("foto", 100);
            $tabla->char("rol", 36);
            $tabla->foreign("rol")->references("id")->on("roles");
            $tabla->string("estado", 20)->default("Habilitado");
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });

        Schema::create("asistencias", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("empleado", 36);
            $tabla->foreign("empleado")->references("id")->on("personal");
            $tabla->time("entrada")->default(DB::raw("CURRENT_TIME"));
            $tabla->time("salida")->nullable();
            $tabla->text("observacion")->nullable();
        });

        Schema::create("prestamos", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("empleado", 36);
            $tabla->foreign("empleado")->references("id")->on("personal");
            $tabla->float("monto", 2);
            $tabla->date("prestamo")->default(DB::raw("CURRENT_DATE"));
            $tabla->date("retorno");
            $tabla->string("estado", 20)->default("En deuda");
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("personal");
        Schema::dropIfExists("asistencias");
        Schema::dropIfExists("prestamos");
    }
};
