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

        Schema::create("mercancia", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->string("producto", 30);
            $tabla->string("presentacion", 30);
            $tabla->integer("cantidad");
            $tabla->float("precio_unidad", 2);
            $tabla->date("adquisicion")->default(DB::raw("CURRENT_DATE"));
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

        Schema::create("envios", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("distribuidor", 36);
            $tabla->foreign("distribuidor")->references("id")->on("personal");
            $tabla->char("compañia", 36);
            $tabla->foreign("compañia")->references("id")->on("contratos");
            $tabla->text("destino");
            $tabla->date("entrega");
            $tabla->float("precio", 2);
            $tabla->string("estado", 20)->default("En camino");
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });

        Schema::create("detalles_envio", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("envio", 36);
            $tabla->foreign("envio")->references("id")->on("envios");
            $tabla->char("producto", 36);
            $tabla->foreign("producto")->references("id")->on("mercancia");
            $tabla->integer("cantidad");
            $tabla->float("precio", 2);
        });

        Schema::create("ventas", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("cliente", 36);
            $tabla->foreign("cliente")->references("id")->on("clientes");
            $tabla->date("fecha")->default(DB::raw("CURRENT_DATE"));
            $tabla->float("monto", 2);
            $tabla->string("estado", 20)->default("Por pagar");
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });

        Schema::create("detalles_venta", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("venta", 36);
            $tabla->foreign("venta")->references("id")->on("ventas");
            $tabla->char("producto", 36);
            $tabla->foreign("producto")->references("id")->on("mercancia");
            $tabla->integer("cantidad");
            $tabla->float("precio", 2);
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
        Schema::dropIfExists("detalle_trabajo_activo");
        Schema::dropIfExists("detalles_venta");
        Schema::dropIfExists("ventas");
        Schema::dropIfExists("activos");
        Schema::dropIfExists("mercancia");
        Schema::dropIfExists("reparaciones");
        Schema::dropIfExists("detalles_envio");
        Schema::dropIfExists("envios");
    }
};
