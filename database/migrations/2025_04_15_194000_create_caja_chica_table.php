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
        Schema::create("caja_chica", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->float("dinero", 2);
            $tabla->float("porcentaje", 2);
            $tabla->date("fecha")->default(DB::raw("CURRENT_DATE"));
            $tabla->timestamp("creado")->default(DB::raw("CURRENT_TIMESTAMP"));
            $tabla->timestamp("actualizado")->default(DB::raw("CURRENT_TIMESTAMP"));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caja_chica');
    }
};
