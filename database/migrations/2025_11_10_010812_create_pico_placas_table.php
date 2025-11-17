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
    Schema::create('pico_placas', function (Blueprint $table) {
        $table->id();
        $table->string('mensaje')->nullable(); // Ejemplo: "Hoy no circulan placas terminadas en 5 y 6"
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pico_placas');
    }
};
