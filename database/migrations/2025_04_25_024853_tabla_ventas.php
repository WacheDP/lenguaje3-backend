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
        Schema::create("ventas", function (Blueprint $tabla) {
            $tabla->uuid("id")->primary();
            $tabla->uuid("cliente");
            $tabla->foreign("cliente")->references("id")->on("clientes");
            $tabla->float("total", 2);
            $tabla->date("fecha");
            $tabla->string("estado", 15)->default("En deuda");
            $tabla->timestamp("creado")->useCurrent();
            $tabla->timestamp("actualizado")->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("ventas");
    }
};
