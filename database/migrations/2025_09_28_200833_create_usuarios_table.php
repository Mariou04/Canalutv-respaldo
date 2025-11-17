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
        Schema::create('usuarios', function (Blueprint $table) {
    $table->id('id_usuario');
    $table->string('nombre');
    $table->string('apellido');
    $table->string('email')->unique();
    $table->string('password');
    $table->boolean('activo')->default(true);
    $table->unsignedBigInteger('rol_id');
    $table->timestamps();

    $table->foreign('rol_id')->references('id_rol')->on('roles')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
