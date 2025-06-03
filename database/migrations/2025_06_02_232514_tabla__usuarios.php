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
            $tabla->string("usuario", 30)->unique();
            $tabla->string("correo", 100)->nullable()->unique();
            $tabla->string("contraseña", 60);
            $tabla->uuid("rol");
            $tabla->foreign("rol")->references("id")->on("roles");
            $tabla->string("estado", 1)->default("A");
            $tabla->timestamp("creado")->useCurrent()->useCurrentOnUpdate();
            $tabla->timestamp("actualizacion")->useCurrent()->useCurrentOnUpdate();
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
