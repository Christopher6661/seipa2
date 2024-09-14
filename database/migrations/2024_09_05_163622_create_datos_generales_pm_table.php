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
        Schema::create('datos_generales_pm', function (Blueprint $table) {
            $table->id();
            $table->string('razon_social');
            $table->string('RFC');
            $table->string('CURP');
            $table->string('telefono');
            $table->string('domicilio');
            $table->unsignedBigInteger('localidad_id');
            $table->unsignedBigInteger('municipio_id');
            $table->unsignedBigInteger('distrito_id');
            $table->unsignedBigInteger('region_id');
            $table->string('zona_pesca');
            $table->string('acta_constitutiva');
            $table->string('socios');
            $table->string('cuota_captura');
            $table->unsignedBigInteger('grupo_etnico_id');
            $table->boolean('cuenta_permiso')->default(false);
            $table->string('motivo_no_cuenta');

            $table->foreign('localidad_id')->references('id')->on('localidades');
            $table->foreign('municipio_id')->references('id')->on('municipios');
            $table->foreign('distrito_id')->references('id')->on('distritos');
            $table->foreign('region_id')->references('id')->on('regiones');
            $table->foreign('grupo_etnico_id')->references('id')->on('etnias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_generales_pm');
    }
};
