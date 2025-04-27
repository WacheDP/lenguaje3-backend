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
            $tabla->string("cedula", 20)->unique();
            $tabla->uuid("usuario");
            $tabla->foreign("usuario")->references("id")->on("usuarios");
            $tabla->string("nombre", 20);
            $tabla->string("apellido", 20);
            $tabla->date("nacimiento");
            $tabla->string("telefono");
            $tabla->string("estado", 15)->default("Habilitado");
            $tabla->timestamp("creado")->useCurrent();
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
