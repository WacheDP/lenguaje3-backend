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
        Schema::create("roles", function (Blueprint $table) {
            $table->char("id", 36)->primary()->default(DB::raw('UUID()'));
            $table->string("rol", 20);
            $table->json("permisos");
        });

        Schema::create("usuarios", function (Blueprint $tabla) {
            $tabla->char("id", 36)->primary()->default(DB::raw("UUID()"));
            $tabla->string("nombre", 30)->unique();
            $tabla->string("correo", 100)->unique()->nullable();
            $tabla->string("contraseña", 60);
            $tabla->text("token");
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
        Schema::dropIfExists("roles");
        Schema::dropIfExists("usuarios");
    }
};
