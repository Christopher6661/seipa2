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
        Schema::create('registro_ubfisica_af', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('RNPA');
            $table->string('paraje');
            $table->string('domicilio');
            $table->string('codigo_postal');
            $table->string('telefono');
            $table->unsignedBigInteger('region_id');
            $table->unsignedBigInteger('distr_id');
            $table->unsignedBigInteger('muni_id');
            $table->unsignedBigInteger('local_id');
            $table->date('inicio_operacion');
            $table->date('fin_operacion');
            $table->string('coordenadas_map');
            $table->string('fuente_agua');

            $table->foreign('local_id')->references('id')->on('localidades');
            $table->foreign('muni_id')->references('id')->on('municipios');
            $table->foreign('distr_id')->references('id')->on('distritos');
            $table->foreign('region_id')->references('id')->on('regiones');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_ubfisica_af');
    }
};
