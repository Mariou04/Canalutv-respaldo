<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::rename('pico_placa', 'pico_placas');
}

public function down()
{
    Schema::rename('pico_placas', 'pico_placa');
}

};
