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
        Schema::create("trabajos", function (Blueprint $tabla) {
            Schema::create("usuarios", function (Blueprint $tabla) {
                $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
                $tabla->string("tipo", 20);
                $tabla->float("paga", 2);
                $tabla->date("inicio");
                $tabla->date("final");
                $tabla->string("estado", 20);
                $tabla->date("creado")->default(DB::raw("CURRENT_DATE"));
                $tabla->date("actualizado")->default(DB::raw("CURRENT_DATE"));
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("trabajos");
    }
};
