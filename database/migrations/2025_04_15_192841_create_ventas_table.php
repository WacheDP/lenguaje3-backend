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

        Schema::create("pagos", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->char("venta", 36);
            $tabla->foreign("venta")->references("id")->on("ventas");
            $tabla->string("tipo", 20);
            $tabla->float("monto", 2);
            $tabla->date("fecha");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
        Schema::dropIfExists('detalles_venta');
        Schema::dropIfExists('pagos');
    }
};
