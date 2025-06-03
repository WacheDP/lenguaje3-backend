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
        Schema::create("detalles_venta", function (Blueprint $tabla) {
            $tabla->uuid("id")->primary();
            $tabla->uuid("venta");
            $tabla->foreign("venta")->references("id")->on("ventas");
            $tabla->uuid("producto");
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
        Schema::dropIfExists("detalles_venta");
    }
};
