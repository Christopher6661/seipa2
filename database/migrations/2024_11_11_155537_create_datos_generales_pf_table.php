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
        Schema::create('datos_generales_pf', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userprofile_id');
            $table->unsignedBigInteger('oficregis_id');
            $table->string('nombres');
            $table->string('apellido_pa');
            $table->string('apellido_ma');
            $table->string('RFC')->unique();
            $table->string('CURP')->unique();
            $table->string('telefono');
            $table->string('email');
            $table->string('domicilio');
            $table->unsignedBigInteger('localidad_id');
            $table->unsignedBigInteger('municipio_id');
            $table->unsignedBigInteger('distrito_id');
            $table->unsignedBigInteger('region_id');
            $table->string('grupo_sanguineo');
            $table->string('zona_pesca');
            $table->string('acta_constitutiva');
            $table->string('cuota_captura');
            $table->unsignedBigInteger('etnia_id');
            $table->integer('cantidad_artepesca');
            $table->boolean('cuenta_permiso')->default(false);
            $table->string('motivo_no_cuenta')->nullable();;
            $table->boolean('cuenta_emb_mayor')->default(false);
            $table->string('motino_cuenta_embma')->nullable();
            $table->integer('cant_emb_ma')->nullable();
            $table->integer('cant_motores_ma')->nullable();
            $table->string('tipos_motores_ma')->nullable();
            $table->boolean('cuenta_emb_menores')->default(false);
            $table->string('motino_cuenta_embme')->nullable();
            $table->integer('cant_emb_me')->nullable();
            $table->integer('cant_motores_me')->nullable();
            $table->string('tipos_motores_me')->nullable();
        
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
        Schema::dropIfExists('datos_generales_pf');
    }
};
