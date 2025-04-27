<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("mercancia", function (Blueprint $tabla) {
            $tabla->uuid("id")->primary();
            $tabla->string("producto", 30);
            $tabla->integer("cantidad");
            $tabla->date("adquisicion");
            $tabla->float("precio_unidad", 2);
            $tabla->string("estado", 15)->default("En buen estado");
            $tabla->timestamp("creado")->useCurrent();
            $tabla->timestamp("actualizado")->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("mercancia");
    }
};
