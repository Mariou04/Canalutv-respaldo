<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id('id_noticia');
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->text('entradilla'); 
            $table->text('cuerpo');
            $table->text('seo')->nullable(); 
            $table->timestamp('fecha_publicacion')->nullable();
            $table->string('imagen_portada')->nullable();
            $table->boolean('publicada')->default(false);
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('usuario_id');
            $table->timestamps();

            $table->foreign('categoria_id')->references('id_categoria')->on('categorias')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id_usuario')->on('usuarios')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('noticias');
    }
};