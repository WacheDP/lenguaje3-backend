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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
