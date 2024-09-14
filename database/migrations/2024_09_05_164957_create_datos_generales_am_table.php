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
        Schema::create('datos_generales_am', function (Blueprint $table) {
            $table->id();
            $table->string('razon_social');
            $table->string('RFC');
            $table->string('CURP');
            $table->string('telefono');
            $table->string('domicilio');
            $table->unsignedBigInteger('local_id');
            $table->unsignedBigInteger('muni_id');
            $table->unsignedBigInteger('distrito_id');
            $table->unsignedBigInteger('region_id');
            $table->string('email');
            $table->string('especies_producen');
            $table->string('socios');
            $table->unsignedBigInteger('etnia_id');
            $table->boolean('cuenca_siscuarente')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_generales_am');
    }
};
