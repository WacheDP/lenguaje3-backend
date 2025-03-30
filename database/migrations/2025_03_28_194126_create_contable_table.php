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
        Schema::create("deudas", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->date("fecha")->default(DB::raw("CURRENT_DATE"));
            $tabla->string("estado", 20)->default("Por pagar");
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });

        Schema::create("pagos", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("venta", 36);
            $tabla->foreign("venta")->references("id")->on("ventas");
            $tabla->string("tipo", 20);
            $tabla->float("monto", 2);
            $tabla->date("fecha");
        });

        Schema::create("deuda_empresa", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("deuda", 36);
            $tabla->foreign("deuda")->references("id")->on("deudas");
            $tabla->text("motivo");
        });

        Schema::create("deuda_cliente", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("deuda", 36);
            $tabla->foreign("deuda")->references("id")->on("deudas");
            $tabla->char("cliente", 36);
            $tabla->foreign("cliente")->references("id")->on("clientes");
        });

        Schema::create("deuda_empleado", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("deuda", 36);
            $tabla->foreign("deuda")->references("id")->on("deudas");
            $tabla->char("cliente", 36);
            $tabla->foreign("cliente")->references("id")->on("clientes");
            $tabla->char("empleado", 36);
            $tabla->foreign("empleado")->references("id")->on("personal");
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

        Schema::create("caja_chica", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->float("dinero", 2);
            $tabla->float("porcentaje", 2);
            $tabla->date("fecha")->default(DB::raw("CURRENT_DATE"));
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });

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
        Schema::dropIfExists("libro_perdidas");
        Schema::dropIfExists("relacion_perdida_activos");
        Schema::dropIfExists("relacion_perdida_reparacion");
        Schema::dropIfExists("relacion_perdida_deudas");
        Schema::dropIfExists("relacion_perdida_prestamos");
        Schema::dropIfExists("relacion_perdida_nomina1");
        Schema::dropIfExists("relacion_perdida_nomina2");
        Schema::dropIfExists("relacion_perdida_servicios");
        Schema::dropIfExists("caja_chica");
        Schema::dropIfExists("libro_ganancias");
        Schema::dropIfExists("relacion_ganancia_envio");
        Schema::dropIfExists("relacion_ganancia_pago");
        Schema::dropIfExists("relacion_ganancia_deuda");
        Schema::dropIfExists("relacion_ganancia_prestamo");
        Schema::dropIfExists("prestamos");
        Schema::dropIfExists("deuda_empleado");
        Schema::dropIfExists("deuda_cliente");
        Schema::dropIfExists("deuda_empresa");
        Schema::dropIfExists("pagos");
        Schema::dropIfExists("deudas");
    }
};
