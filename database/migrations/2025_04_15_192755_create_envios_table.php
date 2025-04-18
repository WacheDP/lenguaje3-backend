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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('envios');
        Schema::dropIfExists('detalles_envio');
    }
};
