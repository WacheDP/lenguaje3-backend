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
        Schema::create("libro_ganancias", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->float("ganancia", 2);
            $tabla->date("fecha");
        });

        Schema::create("relacion_ganancia_envio", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("ganancia", 36);
            $tabla->foreign("ganancia")->references("id")->on("libro_ganancias");
            $tabla->char("envio", 36);
            $tabla->foreign("envio")->references("id")->on("envios");
            $tabla->float("monto", 2);
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });

        Schema::create("relacion_ganancia_pago", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("ganancia", 36);
            $tabla->foreign("ganancia")->references("id")->on("libro_ganancias");
            $tabla->char("pago", 36);
            $tabla->foreign("pago")->references("id")->on("pagos");
            $tabla->float("monto", 2);
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });

        Schema::create("relacion_ganancia_deuda", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("ganancia", 36);
            $tabla->foreign("ganancia")->references("id")->on("libro_ganancias");
            $tabla->char("deuda", 36);
            $tabla->foreign("deuda")->references("id")->on("deuda_cliente");
            $tabla->float("monto", 2);
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });

        Schema::create("relacion_ganancia_prestamo", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("ganancia", 36);
            $tabla->foreign("ganancia")->references("id")->on("libro_ganancias");
            $tabla->char("prestamo", 36);
            $tabla->foreign("prestamo")->references("id")->on("deuda_empleado");
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
        Schema::dropIfExists('libro_ganancias');
        Schema::dropIfExists('relacion_ganancia_envio');
        Schema::dropIfExists('relacion_ganancia_pago');
        Schema::dropIfExists('relacion_ganancia_deuda');
        Schema::dropIfExists('relacion_ganancia_prestamo');
    }
};
