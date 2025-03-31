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
        Schema::create('registro_tipoinfraest_af', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userprofile_id');
            $table->float('estanque_rustico_sup');
            $table->float('estanque_rustico_vol');
            $table->string('estanque_rustico_can');
            $table->float('recubiertomem_sup');
            $table->float('recubiertomem_vol');
            $table->string('recubiertomem_can');
            $table->float('geomallagallamina_sup');
            $table->float('geomallagallamina_vol');
            $table->string('geomallagallamina_can');
            $table->float('tipo_circular_sup');
            $table->float('tipo_circular_vol');
            $table->string('tipo_circular_can');
            $table->float('tipo_rectangular_sup');
            $table->float('tipo_rectangular_vol');
            $table->string('tipo_rectangular_can');
            $table->float('jaula_flotante_sup');
            $table->float('jaula_flotante_vol');
            $table->string('jaula_flotante_can');
            $table->float('cercas_encierros_sup');
            $table->float('cercas_encierros_vol');
            $table->string('cercas_encierros_can');
            $table->float('otro_superficie');
            $table->float('otro_volumen');
            $table->string('otro_cantidad');

            $table->foreign('userprofile_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_tipoinfraest_af');
    }
};
