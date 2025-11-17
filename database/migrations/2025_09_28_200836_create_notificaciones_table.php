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
        Schema::create('notificaciones', function (Blueprint $table) {
    $table->id('id_notificacion');
    $table->unsignedBigInteger('usuario_id');
    $table->unsignedBigInteger('noticia_id')->nullable();
    $table->string('tipo'); // ej: nueva noticia, cambio de estado
    $table->text('mensaje');
    $table->boolean('leida')->default(false);
    $table->timestamp('created_at')->useCurrent();

    $table->foreign('usuario_id')->references('id_usuario')->on('usuarios')->onDelete('cascade');
    $table->foreign('noticia_id')->references('id_noticia')->on('noticias')->nullOnDelete();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
