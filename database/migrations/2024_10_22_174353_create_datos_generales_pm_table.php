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
            $table->unsignedBigInteger('region_id');
            $table->unsignedBigInteger('distrito_id');
            $table->unsignedBigInteger('municipio_id');
            $table->unsignedBigInteger('localidad_id');            
            $table->string('zona_pesca');
            $table->string('cuota_captura');
            $table->string('cant_artepesca');
            $table->unsignedBigInteger('etnia_id');
            $table->string('acta_constitutiva');
            $table->integer('socios');
            $table->boolean('cuenta_permiso')->default(false);
            $table->string('motivo_no_cuenta');
            $table->boolean('cuentaemb_ma')->default(false);
            $table->string('motivono_cuenta_embma');
            $table->integer('cant_emb_ma')->nullable();
            $table->integer('cant_motor_ma')->nullable();
            $table->string('tipos_motores_ma')->nullable();
            $table->boolean('cuentaemb_me')->default(false);
            $table->string('motivono_cuenta_embme');
            $table->integer('cant_emb_me')->nullable();
            $table->integer('cant_motor_me')->nullable();
            $table->string('tipos_motores_me')->nullable();

            $table->foreign('region_id')->references('id')->on('regiones');
            $table->foreign('distrito_id')->references('id')->on('distritos');
            $table->foreign('municipio_id')->references('id')->on('municipios');
            $table->foreign('localidad_id')->references('id')->on('localidades');

            $table->foreign('etnia_id')->references('id')->on('etnias');
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
