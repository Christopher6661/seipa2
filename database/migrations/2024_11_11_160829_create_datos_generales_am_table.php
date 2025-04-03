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
            $table->unsignedBigInteger('userprofile_id');
            $table->unsignedBigInteger('oficregis_id');
            $table->string('razon_social');
            $table->string('RFC');
            $table->string('CURP');
            $table->string('telefono');
            $table->string('domicilio');
            $table->unsignedBigInteger('region_id');
            $table->unsignedBigInteger('distrito_id');
            $table->unsignedBigInteger('muni_id');
            $table->unsignedBigInteger('local_id');           
            $table->string('email');
            $table->unsignedBigInteger('etnia_id');
            $table->string('socios');
            $table->boolean('cuenta_siscuarente')->default(false);
            $table->string('motivo_no_cuenta')->nullable();

            $table->foreign('userprofile_id')->references('id')->on('users');
            $table->foreign('oficregis_id')->references('id')->on('oficinas');
            $table->foreign('region_id')->references('id')->on('regiones');
            $table->foreign('distrito_id')->references('id')->on('distritos');
            $table->foreign('muni_id')->references('id')->on('municipios');
            $table->foreign('local_id')->references('id')->on('localidades');
            $table->foreign('etnia_id')->references('id')->on('etnias');
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
