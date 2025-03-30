<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("clientes", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->string("cedula", 15)->unique();
            $tabla->string("nombre", 20);
            $tabla->string("apellido", 20);
            $tabla->string("telefono", 20);
            $tabla->string("direccion", 100)->nullable();
            $tabla->string("estado", 20)->default("Habilitado");
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });

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

        Schema::create("contratos", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->string("compañia", 30);
            $tabla->char("usuario", 36);
            $tabla->foreign("usuario")->references("id")->on("usuarios");
            $tabla->date("firma")->default(DB::raw("CURRENT_DATE"));
            $tabla->date("vencimiento");
            $tabla->string("estado", 20)->default("Vigente");
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });

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
        Schema::dropIfExists("detalle_trabajo_empleado");
        Schema::dropIfExists("trabajos");
        Schema::dropIfExists("contratos");
        Schema::dropIfExists("clientes");
        Schema::dropIfExists("personal");
        Schema::dropIfExists("asistencias");
    }
};
