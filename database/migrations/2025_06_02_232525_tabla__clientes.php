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
        Schema::create("clientes", function (Blueprint $tabla) {
            $tabla->uuid("id")->primary();
            $tabla->string("cedula", 10)->unique();
            $tabla->uuid("usuario");
            $tabla->foreign("usuario")->references("id")->on("usuarios");
            $tabla->string("nombre", 15);
            $tabla->string("apellido", 15);
            $tabla->date("nacimiento");
            $tabla->string("telefono", 20)->nullable();
            $tabla->string("estado", 1)->default("A");
            $tabla->timestamp("creado")->useCurrent()->useCurrentOnUpdate();
            $tabla->timestamp("actualizado")->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("clientes");
    }
};
