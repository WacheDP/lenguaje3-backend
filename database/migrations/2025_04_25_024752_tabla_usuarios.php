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
        Schema::create("usuarios", function (Blueprint $tabla) {
            $tabla->uuid("id")->primary();
            $tabla->string("usuario", 20)->unique();
            $tabla->string("correo", 100)->unique();
            $tabla->string("contraseña", 100);
            $tabla->uuid("rol");
            $tabla->foreign("rol")->references("id")->on("roles");
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
        Schema::dropIfExists("usuarios");
    }
};
