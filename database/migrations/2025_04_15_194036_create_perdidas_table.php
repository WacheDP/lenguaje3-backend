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
        Schema::create("libro_perdidas", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->float("perdida", 2);
            $tabla->date("fecha");
        });

        Schema::create("relacion_perdida_activos", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("perdida", 36);
            $tabla->foreign("perdida")->references("id")->on("libro_perdidas");
            $tabla->char("activo", 36);
            $tabla->foreign("activo")->references("id")->on("activos");
            $tabla->float("monto", 2);
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });

        Schema::create("relacion_perdida_reparacion", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("perdida", 36);
            $tabla->foreign("perdida")->references("id")->on("libro_perdidas");
            $tabla->char("reparacion", 36);
            $tabla->foreign("reparacion")->references("id")->on("reparaciones");
            $tabla->float("monto", 2);
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });

        Schema::create("relacion_perdida_deudas", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("perdida", 36);
            $tabla->foreign("perdida")->references("id")->on("libro_perdidas");
            $tabla->char("deuda", 36);
            $tabla->foreign("deuda")->references("id")->on("deuda_empresa");
            $tabla->float("monto", 2);
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });

        Schema::create("relacion_perdida_prestamos", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("perdida", 36);
            $tabla->foreign("perdida")->references("id")->on("libro_perdidas");
            $tabla->char("prestamo", 36);
            $tabla->foreign("prestamo")->references("id")->on("prestamos");
            $tabla->float("monto", 2);
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });

        Schema::create("relacion_perdida_nomina1", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("perdida", 36);
            $tabla->foreign("perdida")->references("id")->on("libro_perdidas");
            $tabla->char("pago", 36);
            $tabla->foreign("pago")->references("id")->on("nomina1");
            $tabla->float("monto", 2);
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });

        Schema::create("relacion_perdida_nomina2", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("perdida", 36);
            $tabla->foreign("perdida")->references("id")->on("libro_perdidas");
            $tabla->char("pago", 36);
            $tabla->foreign("pago")->references("id")->on("nomina2");
            $tabla->float("monto", 2);
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libro_perdidas');
        Schema::dropIfExists('relacion_perdida_activos');
        Schema::dropIfExists('relacion_perdida_reparacion');
        Schema::dropIfExists('relacion_perdida_deudas');
        Schema::dropIfExists('relacion_perdida_prestamos');
        Schema::dropIfExists('relacion_perdida_nomina1');
        Schema::dropIfExists('relacion_perdida_nomina2');
    }
};
