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
       Schema::create('multimedia', function (Blueprint $table) {
    $table->id('id_media');
    $table->unsignedBigInteger('noticia_id');
    $table->string('ruta_archivo');
    $table->string('tipo'); // imagen, video, audio, etc
    $table->string('descripcion')->nullable();
    $table->integer('orden')->default(0);
    $table->timestamp('uploaded_at')->useCurrent();
    
    $table->foreign('noticia_id')->references('id_noticia')->on('noticias')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multimedia');
    }
};
