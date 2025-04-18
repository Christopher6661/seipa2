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
        Schema::create('datos_generales_af', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userprofile_id');
            $table->unsignedBigInteger('oficregis_id');
            $table->string('nombres');
            $table->string('apellido_pa');
            $table->string('apellido_ma');
            $table->string('RFC')->unique();
            $table->string('CURP')->unique();
            $table->string('telefono')->unique();
            $table->string('email');
            $table->string('domicilio');
            $table->unsignedBigInteger('localidad_id');
            $table->unsignedBigInteger('municipio_id');
            $table->unsignedBigInteger('distrito_id');
            $table->unsignedBigInteger('region_id');
            $table->string('grupo_sanguineo');
            $table->unsignedBigInteger('etnia_id');
            $table->boolean('cuenta_siscaptura')->default(false);
	        $table->string('motivo_no_cuenta')->nullable();

            $table->foreign('userprofile_id')->references('id')->on('users');
            $table->foreign('oficregis_id')->references('id')->on('oficinas');
            $table->foreign('localidad_id')->references('id')->on('localidades');
            $table->foreign('municipio_id')->references('id')->on('municipios');
            $table->foreign('distrito_id')->references('id')->on('distritos');
            $table->foreign('region_id')->references('id')->on('regiones');
            $table->foreign('etnia_id')->references('id')->on('etnias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_generales_af');
    }
};
