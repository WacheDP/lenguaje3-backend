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
        Schema::create("deudas", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->date("fecha")->default(DB::raw("CURRENT_DATE"));
            $tabla->string("estado", 20)->default("Por pagar");
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deudas');
        Schema::dropIfExists('deuda_empresa');
        Schema::dropIfExists('deuda_cliente');
        Schema::dropIfExists('deuda_empleado');
    }
};
